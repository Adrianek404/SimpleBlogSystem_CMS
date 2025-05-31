<?php

global $conn;
include("./inc/db.php");

$maxOnPage = 2;
$sql = "SELECT COUNT(id) FROM posts;";
$result = mysqli_query($conn, $sql);
$count = mysqli_fetch_array($result);
$numberResult = $count[0];
$numberPages = ceil($numberResult / $maxOnPage);

if (isset($_GET['page'])) {
    if ($_GET['page'] < 1 || $_GET['page'] > $numberPages) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    setcookie("page", $page, time() + (86400 * 30), "/");
} else {
    if(!isset($_COOKIE["page"])) {
        $page = 1;
    } else {
        $page = $_COOKIE["page"];
    }

}
$from = $maxOnPage * ($page - 1);

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
        $sql = "SELECT id, title, content FROM posts LIMIT $maxOnPage OFFSET $from;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                        <div class="post-box">
                            <?php
                            echo "<h2>" . $row["title"] . "</h2>
                            <p>" . $row["content"] . "</p>
                            <a href='post.php?id=" . $row["id"] . "'>Czytaj więcej</a>";
                            ?>
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>
    </div>
    <div class="pagination">
        <?php
        if ($numberResult > 2) {
            $next = $page + 1;
            $prevous = $page - 1;

            if ($prevous > 0) {
                echo "<a href='index.php?page=$prevous'>&laquo;</a>";
            } else {
                echo "<a href='#'>&laquo;</a>";
            }
            for ($i = 1; $i <= $numberPages; $i++) {
                if ($page == $i) {
                    echo "<a class='active' href='index.php?page=$i'>$i</a>";
                } else {
                    echo "<a href='index.php?page=$i'>$i</a>";
                }
                /* TODO: stworzyć system przewijania paginatora: limit na strone 10, wiec np na stronie 14 wezmie srodek 14 i wezmie 4 dodatkowe liczby na lewo i 5 liczb na prawo aby bylo 10
                    np:
                    << 2 3 4 5 6 7 8 9 10 11 >> -- active 6
                    <<10 11 12 13 14 15 16 17 18 19 >> active 14
                w liczbach od 1 do 5 active podaza za strona a powyzej 5 zostaje na srodku i liczby sie zmieniaja na koncu o jedno mniej a drugim o jedno wiecej
                im blizej konca np ostatnia to 22 liczba to jesli polewej stronie jest mniej niz 5 to active idzie do ostatniej liczby
                  */
                if ($i == 10){
                    $i = $numberPages;
                }
            }
            ?>
            <?php
            if ($next <= $numberPages) {
                echo "<a href='index.php?page=$next'>&raquo;</a>";
            } else {
                echo "<a href='#'>&raquo;</a>";
            }
        }
        ?>
    </div>
</main>
<footer>
    <p>&copy; 2025 Adrian Rzeszutek</p>
</footer>
</body>
<script src="./js/index.js"></script>

