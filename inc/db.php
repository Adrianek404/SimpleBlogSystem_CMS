<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "SimpleBlogSystem";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (file_exists("./sql/schema.sql")) {
    $sql = file_get_contents("./sql/schema.sql");
} else if (file_exists("../sql/schema.sql")) {
    $sql = file_get_contents("../sql/schema.sql");
} else {
    die("Unable to load SQL file.");
}

if ($conn->multi_query($sql)) {
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
} else {
    die("Error: " . $sql . "<br>" . $conn->error);
}