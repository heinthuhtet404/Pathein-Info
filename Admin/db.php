<?php
$db = new mysqli("localhost", "root", "", "patheininfodb");
if ($db->connect_error) {
    die("DB Connection failed");
}


// Unicode support
mysqli_set_charset($db,"utf8mb4");
?>