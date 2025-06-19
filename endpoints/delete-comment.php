<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)trim($_POST['id']);
    global $conn;
    require_once '../inc/db.php';
    $sql = "DELETE FROM comments WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        http_response_code(500);
        exit('Błąd zapytania SQL.');
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_execute($stmt);
    if (mysqli_stmt_get_result($stmt) == 0){
        throw new Exception("Usuniecie komentarza nie powiodło się.");
    }
} else {
    throw new Exception("Blad w zapytaniu");
}
?>
