<?php
include ("db.php");
$id = $_GET['id'];
$db->query("DELETE FROM users WHERE user_id=$id");

 header("Location: superAdminUserLists.php");
?>