<?php

require_once '../inc/auth.php';
requireLogin();
global $conn;
include("../inc/db.php");

$username = $_SESSION['data'][1];

$sql = "SELECT * FROM comments";
if ($stmt = mysqli_prepare($conn, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $comment_Count = mysqli_num_rows(mysqli_stmt_get_result($stmt));
        mysqli_stmt_free_result($stmt);
    }
}
$sql = "SELECT * FROM posts";
if ($stmt = mysqli_prepare($conn, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $post_Count = mysqli_num_rows(mysqli_stmt_get_result($stmt));
        mysqli_stmt_free_result($stmt);
    }
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Blog System (CMS) | Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/toast.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<div class="wrapper">
    <aside class="sidebar">
        <h2>CMS Panel</h2>
        <nav>
            <a href="#" data-screen="create">Stwórz</a>
            <a href="#" data-screen="edit">Edytuj</a>
            <a href="#" data-screen="delete">Usuń</a>
            <a href="#" data-screen="comments">Komentarze</a>
            <a href="logout.php">Wyloguj</a>
        </nav>
    </aside>
    <main class="screen">
        <section class="dashboard">
            <header>
                <h1>Witaj w panelu administratora</h1>
            </header>

            <div class="cards">
                <div class="card">
                    <h3>Postów</h3>
                    <p><?php echo $post_Count; ?></p>
                </div>
                <div class="card">
                    <h3>Komentarzy</h3>
                    <p><?php echo $comment_Count; ?></p>
                </div>
                <div class="card">
                    <h3>Użytkowników</h3>
                    <p>3</p>
                </div>
            </div>

            <div class="comments">
                <h3>Ostatnie komentarze:</h3>
                <?php
                $sql = "SELECT author, content, created_at FROM comments ORDER BY created_at DESC LIMIT 3";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    if (mysqli_stmt_execute($stmt)) {
                        $result = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <div class="comment">
                                <strong>' . $row['author'] . '</strong> ' . $row['content'] . '
                            </div>
                            ';
                            }
                        }
                    }
                }
                ?>
            </div>
        </section>
        <section id="create" class="screen-section">
            <h2>Stwórz nowy post</h2>
            <form method="post" action="<?php echo htmlspecialchars("create.php"); ?>">
                <input type="text" name="title" placeholder="Tytuł" required>
                <textarea name="content" placeholder="Treść" required></textarea>
                <button type="submit">Opublikuj</button>
            </form>
        </section>

        <section id="edit" class="screen-section">
            <div class="toast">
                <div class="toast-content">
                    <i class="fas fa-solid fa-check check"></i>
                    <div class="message">
                        <span class="text text-1">Sukces</span>
                        <span class="text text-2">Poprawnie edytowano post!</span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close"></i>
                <div class="progress"></div>
            </div>
        </section>

        <section id="delete" class="screen-section">
            <h2>Usuń post</h2>
            <p>Lista postów z opcją usuwania</p>
        </section>

        <section id="comments" class="screen-section">
            <ul class="comment-list" id="commentList">

            </ul>

            <div class="load-more-container">
                <button id="loadMoreBtn">↓ Wczytaj więcej</button>
            </div>

        </section>
    </main>
</div>
<script src="../js/dashboard.js"></script>
</html>
