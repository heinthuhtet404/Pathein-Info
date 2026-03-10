<?php
session_start();
include("Admin/db.php");

if (!isset($_SESSION['customer_id'])) {
    header("Location: buslogin.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($booking_id == 0) {
    $_SESSION['error_message'] = "မှားယွင်းသော ဘိုကင်နံပါတ်";
    header("Location: bushistory.php");
    exit();
}

// Check if booking belongs to this customer and is pending
$check_query = "SELECT * FROM bus_booking WHERE booking_id = $booking_id AND user_id = $customer_id AND status = 'pending'";
$check_result = mysqli_query($db, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    $_SESSION['error_message'] = "ဤဘိုကင်ကို ပယ်ဖျက်၍ မရနိုင်ပါ။";
    header("Location: bushistory.php");
    exit();
}

// Update booking status to cancelled
$update_query = "UPDATE bus_booking SET status = 'cancelled' WHERE booking_id = $booking_id";
if (mysqli_query($db, $update_query)) {
    $_SESSION['success_message'] = "ဘိုကင်ကို အောင်မြင်စွာ ပယ်ဖျက်လိုက်ပါပြီ။";
} else {
    $_SESSION['error_message'] = "ဘိုကင်ပယ်ဖျက်ရာတွင် အမှားရှိသွားပါသည်။";
}

header("Location: bushistory.php");
exit();
?>