<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Get school_id */
$getSchool = mysqli_query($db,
    "SELECT school_id FROM schools WHERE user_id = $user_id"
);
$schoolRow = mysqli_fetch_assoc($getSchool);
$school_id = $schoolRow['school_id'];

$id = intval($_GET['id']);
$status = $_GET['status'];

if($status == 'accepted' || $status == 'rejected'){

    mysqli_query($db,"
        UPDATE studentregisters
        SET status='$status'
        WHERE register_id=$id
        AND school_id=$school_id
    ");
}

header("Location: StudentAdminRegister.php");
exit;
?>