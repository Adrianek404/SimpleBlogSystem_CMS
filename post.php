<?php

global $conn;
include("./inc/db.php");

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $Postid = $_GET['id'];
    $sql = "SELECT title, content, created_at FROM posts WHERE id = " . $Postid;
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row["title"];
                    $content = $row["content"];
                    $created_at = $row["created_at"];
                }
            }  else {
                header('Location: index.php');
            }
        }
    }
} else {
    header('Location: index.php');
}
$authorErr = $commentErr = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["author"])) {
        $authorErr = "Wpisz pseudonim";
        $error = true;
    } else {
        $author = $_POST["author"];
    }
    if (empty($_POST['comment'])) {
        $commentErr = "Nie wpisałeś żadnego komentarza";
        $error = true;
    } else {
        $comment = $_POST["comment"];
    }
    if (!$error) {
        $sql = "INSERT INTO comments (post_id, author, content) VALUES ('" . $Postid . "', '" . $author . "', '" . $comment . "')";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                echo '<script type="text/javascript">
       window.onload = function () { alert("Poprawnie dodano komentarz!"); } 
</script>';
            }
            mysqli_stmt_close($stmt);
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
    <title>Simple Blog System (CMS) | <?php echo $title; ?></title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/post.css">
</head>
<body>
<nav>
    <div class="logo">
        <span>Nazwa</span>
        <button class="login-button"><a href="admin/login.php">ZALOGUJ</a></button>
    </div>
    <div class="nav-links">
        <span>Strona główna</span>
        <span>O mnie</span>
        <span>Kontakt</span>
    </div>
</nav>
<main>
    <?php
    echo '<h1>Czytasz aktualnie: ' . $title . '</h1>';
    echo '<div class="post-container">';
    echo '<div class="post-box">';
    echo '<h2>' . $title . '</h2>';
    echo '<p>' . $content . '</p>';
    echo '<button><a href="index.php">Powrót</a></button>';
    echo '<span> Opublikowano: ' . $created_at . '</span>';
    ?>
    </div></div>
    <h1>Sekcja komentarzy:</h1>
    <div class="comments-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) .'?id=' . $Postid; ?>" method="post">
            <div class="comment-box">
                <h4>Skomentuj</h4>
                <div class="author"><input name="author" maxlength="100" type="text" placeholder="Wpisz pseudonim"><span class="error"><?php echo $authorErr;?></span></div>
                <div><span class="comment" role="textbox" contenteditable oninput="syncContent()"></span><span class="error"><?php echo $commentErr;?></span></div>
                <input type="hidden" name="comment" id="commentHidden">
                <button type="submit">Dodaj</button>
            </div>
        </form>
    </div>
    <div class="comments-container">
        <?php
        $sql = "SELECT author, content, created_at FROM comments WHERE post_id=" . $Postid . " ORDER BY created_at DESC";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="comment-box">
                                <h3>'. $row["author"] .'</h3>
                                <p>'. $row["content"] .'</p>
                                <span class="public">Opublikowano: '. $row["created_at"] .'</span>
                            </div>';
                    }
                }
            }
        }
        ?>

    </div>
</main>
<footer>
    <p>&copy; 2025 Adrian Rzeszutek</p>
</footer>
<script>
    function syncContent() {
        const editable = document.querySelector('.comment');
        const hidden = document.getElementById('commentHidden');
        hidden.value = editable.innerText.trim();
    }
    document.querySelector('form').addEventListener('submit', syncContent);
</script>
</body>
</html>
