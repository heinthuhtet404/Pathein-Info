<?php
include 'db.php';
// Noti မပြရသေးတဲ့ (is_notified = 0) ဘိုကင်အသစ် သို့မဟုတ် Cancel လုပ်ထားတာတွေကို ရေတွက်မယ်
$query = "SELECT COUNT(*) as total FROM appointments WHERE is_notified = 0";
$res = mysqli_fetch_assoc(mysqli_query($db, $query));
echo $res['total'];
?>