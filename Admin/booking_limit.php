<?php
/**
 * ဆရာဝန်တစ်ဦးချင်းစီ၏ ကျန်ရှိသော လူနာအရေအတွက် (Slots) ကို တွက်ချက်ပေးသည့် Function
 * * @param mysqli $db - Database Connection
 * @param int $doctor_id - ဆရာဝန် ID
 * @param int $booking_limit - ဆရာဝန်၏ တစ်ရက်စာ ကန့်သတ်ချက်
 * @param string $selected_date - ဘိုကင်တင်လိုသည့်ရက်စွဲ (Format: Y-m-d)
 */
function getRemainingSlots($db, $doctor_id, $booking_limit, $selected_date = null) {
    // ၁။ ရက်စွဲ မပါလာရင် ဒီနေ့ရက်စွဲ (Today) ကို အလိုအလျောက် ယူမယ်
    if ($selected_date == null || empty($selected_date)) {
        $selected_date = date('Y-m-d');
    }

    // ၂။ သတ်မှတ်ထားတဲ့ ရက်စွဲမှာ အဲ့ဒီဆရာဝန်နဲ့ တင်ထားပြီးသား လူနာအရေအတွက်ကို ရေတွက်မယ်
    // Status က 'cancelled' မဟုတ်တဲ့ လူနာတွေကိုပဲ ရေတွက်မှာဖြစ်ပါတယ်
    $query = "SELECT COUNT(*) as booked_total FROM appointments 
              WHERE doctor_id = '$doctor_id' 
              AND appointment_date = '$selected_date' 
              AND status != 'cancelled'";
    
    $result = mysqli_query($db, $query);
    
    if (!$result) {
        return $booking_limit; // Database error ဖြစ်ရင် မူရင်း limit ပဲ ပြန်ပေးမယ်
    }

    $row = mysqli_fetch_assoc($result);
    $booked_count = $row['booked_total'];

    // ၃။ ကျန်ရှိတဲ့ slots ကို တွက်မယ် (Limit ထဲကနေ လက်ရှိလူနာကို နှုတ်မယ်)
    $remaining = $booking_limit - $booked_count;

    // ၄။ အကယ်၍ နှုတ်လို့ ၀ အောက် ရောက်သွားရင် ၀ လို့ပဲ သတ်မှတ်မယ်
    return ($remaining > 0) ? $remaining : 0;
}
?>