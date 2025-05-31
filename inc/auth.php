<?php

session_start();

function isLoggedIn(){
    return isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
}

function requireLogin()
{
    if(!isLoggedIn()){
        header("Location: ../admin/login.php");
        exit();
    }
}
