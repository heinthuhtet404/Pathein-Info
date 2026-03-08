<?php
include 'Admin/db.php';

if (isset($_POST['date']) && isset($_POST['doctor_id'])) {
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $doc_id = mysqli_real_escape_string($db, $_POST['doctor_id']);

    // ဆရာဝန်ရဲ့ Limit ကို ယူခြင်း
    $doc_res = mysqli_query($db, "SELECT booking_limit FROM doctors WHERE doctor_id = '$doc_id'");
    $doc_data = mysqli_fetch_assoc($doc_res);
    $max_limit = $doc_data['booking_limit'] ?? 20;

    // ရွေးချယ်ထားသောရက်အတွက် ဘိုကင်အရေအတွက် စစ်ဆေးခြင်း
    $count_res = mysqli_query($db, "SELECT COUNT(*) as total FROM appointments WHERE doctor_id = '$doc_id' AND appointment_date = '$date'");
    $count_data = mysqli_fetch_assoc($count_res);
    
    $booked_count = $count_data['total'];
    $available = $max_limit - $booked_count;

    echo $available; // လက်ကျန်အရေအတွက်ကို ပြန်ပို့ပေးမည်
}
?>