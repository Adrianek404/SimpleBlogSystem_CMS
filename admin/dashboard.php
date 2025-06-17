<?php

require_once '../inc/auth.php';
requireLogin();

$username = $_SESSION['data'][1];

?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Blog System (CMS) | Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<div class="wrapper">
    <aside>
        <h2>CMS Panel</h2>
        <nav>
            <a href="#">Stwórz</a>
            <a href="#">Edytuj</a>
            <a href="#">Usuń</a>
            <a href="#">Komentarze</a>
            <a href="logout.php">Wyloguj</a>
        </nav>
    </aside>
    <main>
        <header>
            <h1>Witaj w panelu administratora</h1>
        </header>

        <div class="cards">
            <div class="card">
                <h3>Postów</h3>
                <p>54</p>
            </div>
            <div class="card">
                <h3>Komentarzy</h3>
                <p>134</p>
            </div>
            <div class="card">
                <h3>Użytkowników</h3>
                <p>3</p>
            </div>
        </div>

        <div class="comments">
            <h3>Ostatnie komentarze:</h3>
            <div class="comment">
                <strong>Anna:</strong> Świetny artykuł, dziękuję!
            </div>
            <div class="comment">
                <strong>Piotr:</strong> Czy będzie kontynuacja?
            </div>
            <div class="comment">
                <strong>Maria:</strong> Bardzo pomocne, super wpis.
            </div>
        </div>

    </main>
</div>
</html>
