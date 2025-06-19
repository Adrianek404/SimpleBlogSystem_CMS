<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = htmlspecialchars($_POST['content']);
    $post_id = (int)$_POST['post_id'];
    $title = htmlspecialchars($_POST['title']);
    global $conn;
    require_once '../inc/db.php';
    $sql = "UPDATE posts SET title=?, content=? WHERE id=?;";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        http_response_code(500);
        exit('Błąd zapytania SQL.');
    }
    mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $post_id);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) === 0) {
        http_response_code(400);
        exit('Nie zmodyfikowano żadnego wiersza.');
    } else {
        http_response_code(300);
    }
    mysqli_stmt_free_result($stmt);
}
