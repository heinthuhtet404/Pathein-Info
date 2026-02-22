<?php
include("db.php");

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    mysqli_query($db, "UPDATE users SET status='Accept' WHERE user_id=$id");

    header("Location: SuperAdminUserLists.php"); // မင်း list page name
    exit;
}
?>