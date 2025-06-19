<?php

global $conn;
require_once '../inc/db.php';

$offset = isset($_GET['offset']) ? (int)($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? (int)($_GET['limit']) : 10;

$sql = "SELECT id, post_id, author, content, created_at FROM comments ORDER BY created_at DESC LIMIT ? OFFSET ?;";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit('Błąd zapytania SQL.');
}

mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$badWords = [];
$sql = "SELECT word FROM forbidden_words";
$stmtW = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmtW);
$resultW = mysqli_stmt_get_result($stmtW);
while($row = mysqli_fetch_assoc($resultW)){
    $badWords[] = strtolower($row['word']);
}

while ($row = mysqli_fetch_assoc($result)) {
    $id = (int)$row['id'];
    $postId = (int)$row['post_id'];
    $author = htmlspecialchars($row['author']);
    $content = htmlspecialchars($row['content']);

    $hasProfanity = false;
    foreach ($badWords as $word){
        if (str_contains(strtolower($content), $word)){
            $hasProfanity = true;
            break;
        }
    }

    echo '<li class="comment-item">';
    echo '<span><strong>' . $author . ': </strong>' . $content . '</span>';
    echo '<span class="actions">';
    echo '<button><a href="../post.php?id=' . $postId . '&comment=' . $id . '" title="Zobacz komentarz">🔍</a></button>';

    if ($hasProfanity) {
        echo '<button title="Wykryto naruszenie">⚠️</button>';
    }

    echo '<button class="delete-comment" data-id="' . $id . '" title="Usuń komentarz">❌</button>';
    echo '</span></li>';
}
mysqli_stmt_free_result($stmt);