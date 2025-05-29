<?php
?>
<!doctype html>
<html lang="pl">
<head>
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
        <div class="post-box">
            <h2>Tytuł posta</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet justo nec lacus...</p>
            <a href="post.php?id=1">Czytaj więcej</a>
        </div><div class="post-box">
            <h2>Tytuł posta</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet justo nec lacus...</p>
            <a href="post.php?id=1">Czytaj więcej</a>
        </div><div class="post-box">
            <h2>Tytuł posta</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet justo nec lacus...</p>
            <a href="post.php?id=1">Czytaj więcej</a>
        </div>
    </div>
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
</html>
