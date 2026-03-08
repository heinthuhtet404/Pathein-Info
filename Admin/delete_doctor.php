<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // အရင်ဆုံး ပုံအဟောင်းကို folder ထဲကနေ ဖျက်ထုတ်မယ်
    $res = mysqli_query($db, "SELECT doctor_image FROM doctors WHERE doctor_id = '$id'");
    $data = mysqli_fetch_assoc($res);
    if ($data['doctor_image']) {
        unlink("uploads/" . $data['doctor_image']);
    }

    // Database ထဲကနေ ဖျက်မယ်
    $del_query = "DELETE FROM doctors WHERE doctor_id = '$id'";
    if (mysqli_query($db, $del_query)) {
        header("Location: clinics_admindashboard.php");
    }
}
?>