<?php

global $conn;
include("../inc/db.php");

$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST['title'])){
        $error = true;
    } else {
        $title = $_POST['title'];
    }
    if (empty($_POST['content'])){
        $error = true;
    } else {
        $content = $_POST['content'];
    }
    $sql = "INSERT INTO posts (title, content) VALUES ('". $title . "', '". $content ."')";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php");
        }
        mysqli_stmt_close($stmt);
    }
}
