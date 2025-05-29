<?php

include ("./inc/db.php");


?>
<!doctype html>
<html lang="pl">
<head>
    <meta name="author" content="Adrian Rzeszutek">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Blog System (CMS)</title>
    <link rel="stylesheet" href="./css/index.css">
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
    <h1>POSTY:</h1>
    <div class="post-container">
        <?php
        $sql = "SELECT id, title, content FROM posts;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="post-box">
                            <?php
                            echo "<h2>". $row["title"] ."</h2>
                            <p>". $row["content"] ."</p>
                            <a href='post.php?id=". $row["id"] ."'>Czytaj więcej</a>";
                            ?>
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>
    </div>
<!--  TODO: bez przechodzenia na kolejną strone/ plik zmiana postow, dla testow limit na 2 posty,   -->
    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#">1</a>
        <a class="active" href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">&raquo;</a>
    </div>
</main>
<footer>
<p>&copy; 2025 Adrian Rzeszutek</p>
</footer>
</body>
<script src="./js/index.js"></script>
</html>
