<?php

global $conn;
include("../inc/db.php");
session_start();


$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = trim($_POST['username']);
    if (!filter_var($user, FILTER_VALIDATE_EMAIL)){
        $error = "Błędny login";
    }
    $pswd = trim($_POST['password']);
    if (empty($error)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $user);
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $password);
                    if (mysqli_stmt_fetch($stmt)){
                        if ($password == $pswd){
                            session_start();
                            $_SESSION['admin_logged'] = true;
                            $_SESSION['data'] = [$id, $username, $password];
                            header('Location: dashboard.php');
                        } else {
                            $error = "Błędny login lub hasło";
                        }
                    }
                } else {
                    $error = "Błędny login lub hasło";
                }
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "Błędny token CSRF";
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Blog System (CMS) | Logowanie</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<nav>
    <div class="logo">
        <span>Nazwa</span>
        <button class="login-button"><a href="#">ZALOGUJ</a></button>
    </div>
    <div class="nav-links">
        <span>Strona główna</span>
        <span>O mnie</span>
        <span>Kontakt</span>
    </div>
</nav>
<main>
    <div class="login-container">
        <div class="login-box">
            <h3>Logowanie do portalu</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Login</label>
                    <input type="text" id="username" name="username" required />
                </div>
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit">Zaloguj</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
