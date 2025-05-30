<?php

global $conn;
include("./inc/db.php");

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "Error on _GET";
    return;
}
$Postid = $_GET['id'];

$sql = "SELECT title, content, created_at FROM posts WHERE id = ". $Postid;
if ($stmt = mysqli_prepare($conn, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row["title"];
                $content = $row["content"];
                $created_at = $row["created_at"];
            }
        }
    }
}

?>
<!doctype html>
<html lang="pl">
<head>
    <meta name="author" content="Adrian Rzeszutek">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Blog System (CMS)  | </title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/post.css">
</head>
<body>
<nav>
    <div class="logo">
        <span>Nazwa</span>
        <button class="login-button">ZALOGUJ</button>
    </div>
    <div class="nav-links">
        <span>Strona główna</span>
        <span>O mnie</span>
        <span>Kontakt</span>
    </div>
</nav>
<main>
    <?php
    echo '<h1>Czytasz aktualnie: '.$title.'</h1>';
    echo '<div class="post-container">';
    echo '<div class="post-box">';
    echo '<p>'.$content.'</p>';
    echo '<button><a href="index.php">Powrót</a></button>';
    echo '<span>'.$created_at.'</span>';
    ?>
    </div></div>
    <h1>Sekcja komentarzy:</h1>

</main>
<footer>
    <p>&copy; 2025 Adrian Rzeszutek</p>
</footer>
</body>
</html>
