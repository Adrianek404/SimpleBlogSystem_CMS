<?php
global $conn;
require_once '../inc/db.php';

$sql = "SELECT id,title,content FROM posts";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit('Błąd zapytania SQL.');
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $id = (int)$row['id'];
    $title = htmlspecialchars($row['title']);
    $content = htmlspecialchars($row['content']);

    echo '<div class="post-item" data-id="'.$id.'">';
    echo '<div class="post-header">';
    echo '<strong>'.$title.'</strong>';
    echo '<button class="toggle-edit">Edytuj</button>';
    echo '</div>';
    echo '<div class="post-edit-form hidden">';
    echo '<form>';
    echo ' <input type="hidden" name="post_id" value="'.$id.'">';
    echo '<label>Tytuł:</label>';
    echo '<input type="text" name="title" value="'.$title.'">';
    echo '<label>Treść:</label>';
    echo '<textarea name="content" rows="10">'.$content.'</textarea>';
    echo '<button type="submit" class="save-btn">Zapisz</button>';
    echo '</form>';
    echo '</div>';
    echo ' </div>';
}

?>
