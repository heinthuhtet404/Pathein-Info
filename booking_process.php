<?php
session_start();
include 'Admin/db.php';

if (isset($_POST['confirm_booking'])) {
    $u_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $clinic_id = mysqli_real_escape_string($db, $_POST['clinic_id']);
    $doc_id = mysqli_real_escape_string($db, $_POST['doctor_id']);
    $p_name = mysqli_real_escape_string($db, $_POST['patient_name']);
    $p_age = mysqli_real_escape_string($db, $_POST['patient_age']);
    $p_gender = $_POST['patient_gender'];
    $p_phone = mysqli_real_escape_string($db, $_POST['patient_phone']);
    $app_date = $_POST['appointment_date'];
    $app_time = $_POST['appointment_time'];
    $reason = mysqli_real_escape_string($db, $_POST['reason']);

    // ၁။ ဆရာဝန်ရဲ့ တစ်ရက်စာ လူနာကန့်သတ်ချက် (Booking Limit) ကို အရင်ယူမယ်
    $limit_res = mysqli_query($db, "SELECT booking_limit FROM doctors WHERE doctor_id = '$doc_id'");
    $limit_data = mysqli_fetch_assoc($limit_res);
    $max_limit = $limit_data['booking_limit'] ?? 20; // Default ၂၀ လို့ ထားထားပါတယ်

    // ၂။ ထိုနေ့အတွက် ဘိုကင်တင်ထားပြီးသား လူနာအရေအတွက်ကို စစ်ဆေးမယ်
    $check_count = mysqli_query($db, "SELECT COUNT(*) as total FROM appointments WHERE doctor_id = '$doc_id' AND appointment_date = '$app_date'");
    $count_data = mysqli_fetch_assoc($check_count);
    $current_total = $count_data['total'];

    if ($current_total >= $max_limit) {
        // Limit ပြည့်သွားရင် တားဆီးမယ်
        echo "<script>alert('စိတ်မရှိပါနဲ့၊ ရွေးချယ်ထားသောရက်မှာ လူနာဦးရေ ပြည့်သွားပါပြီ။ ကျေးဇူးပြု၍ တခြားရက်ကို ရွေးချယ်ပေးပါ။'); window.history.back();</script>";
        exit;
    }

    // ၃။ Token နံပါတ်အသစ် ထုတ်ပေးမယ် (နောက်ဆုံး Token + 1)
    $token_res = mysqli_query($db, "SELECT MAX(token_no) as last_token FROM appointments WHERE doctor_id = '$doc_id' AND appointment_date = '$app_date'");
    $token_data = mysqli_fetch_assoc($token_res);
    $new_token = ($token_data['last_token']) ? $token_data['last_token'] + 1 : 1;

    // ၄။ Database ထဲမှာ သိမ်းဆည်းမယ် (token_no ကိုပါ ထည့်သွင်းထားသည်)
    $query = "INSERT INTO appointments (user_id, clinics_id, doctor_id, patient_name, patient_age, patient_gender, patient_phone, appointment_date, appointment_time, reason, status, is_notified, token_no) 
              VALUES ('$u_id', '$clinic_id', '$doc_id', '$p_name', '$p_age', '$p_gender', '$p_phone', '$app_date', '$app_time', '$reason', 'pending', 0, '$new_token')";

    if (mysqli_query($db, $query)) {
        echo "<script>alert('ဘိုကင်တင်ခြင်း အောင်မြင်ပါသည်! သင်၏ Token နံပါတ်မှာ $new_token ဖြစ်ပါသည်။'); window.location='my_appointments.php';</script>";
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>