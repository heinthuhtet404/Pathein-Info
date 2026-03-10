<?php
session_start();
include("Admin/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ၁။ Form Data များ လက်ခံခြင်း
    $busline_id = isset($_POST['bus_id']) ? intval($_POST['bus_id']) : 0;
    $route_id = isset($_POST['route_id']) ? intval($_POST['route_id']) : 0;
    $customer_id = $_SESSION['customer_id']; 
    
    $seat_no = mysqli_real_escape_string($db, $_POST['seat_no']);
    $customer_name = mysqli_real_escape_string($db, $_POST['customer_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $nrc = mysqli_real_escape_string($db, $_POST['NRC']); 
    $customer_phone = mysqli_real_escape_string($db, $_POST['phone']);
    $total_price = isset($_POST['total_price']) ? intval($_POST['total_price']) : 0;
    $booking_date = date("Y-m-d"); 

    // ၂။ ခုံနံပါတ် ရှိပြီးသားလား စစ်ဆေးခြင်း (Double booking ကာကွယ်ရန်)
    $check_sql = "SELECT * FROM bus_booking WHERE bus_id = '$busline_id' AND route_id = '$route_id' AND seat_number = '$seat_no' AND status != 'cancelled'";
    $check_result = mysqli_query($db, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        // ခုံနေရာ ရှိပြီးသားဖြစ်နေရင်
        echo "<!DOCTYPE html>
        <html lang='my'>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
                body { font-family: 'Pyidaungsu', sans-serif; background: #0f172a; }
            </style>
        </head>
        <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'ခုံနေရာ ယူပြီးသားဖြစ်နေပါသည်',
                text: 'ရွေးချယ်ထားသော ခုံနေရာကို အခြားသူတစ်ဦးက ကြိုတင်ဘိုကင်ထားပါသည်။',
                confirmButtonColor: '#f59e0b',
                confirmButtonText: 'ပြန်ရွေးချယ်မည်'
            }).then(() => { 
                window.history.back(); 
            });
        </script>
        </body>
        </html>";
        exit();
    }

    // ၃။ ပုံတင်ခြင်း Logic
    $payment_slip_name = NULL; 
    if (isset($_FILES['payment_slip']) && $_FILES['payment_slip']['error'] == 0) {
        $target_dir = "Admin/uploads/"; 
        
        // folder ရှိမရှိစစ်ပြီး မရှိရင် အသစ်ဆောက်မယ်
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // ပုံအမျိုးအစားစစ်ဆေးခြင်း
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['payment_slip']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_ext = pathinfo($_FILES["payment_slip"]["name"], PATHINFO_EXTENSION);
            $payment_slip_name = "slip_" . time() . "_" . rand(1000, 9999) . "." . $file_ext;
            
            if (!move_uploaded_file($_FILES["payment_slip"]["tmp_name"], $target_dir . $payment_slip_name)) {
                $payment_slip_name = NULL;
                $upload_error = true;
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'ပုံအမျိုးအစား မှားယွင်းနေပါသည်',
                    text: 'JPG, JPEG, PNG သို့မဟုတ် GIF ပုံများသာ တင်နိုင်ပါသည်။',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'ပြန်ကြိုးစားမည်'
                }).then(() => { window.history.back(); });
            </script>";
            exit();
        }
    }

    // ၄။ Database Query
    $sql = "INSERT INTO bus_booking (user_id, bus_id, route_id, customer_name, email, NRC, seat_number, booking_date, price, phone, payment_slip, status) 
            VALUES ('$customer_id', '$busline_id', '$route_id', '$customer_name', '$email', '$nrc', '$seat_no', '$booking_date', '$total_price', '$customer_phone', '$payment_slip_name', 'pending')";

    echo "<!DOCTYPE html>
    <html lang='my'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
            body { font-family: 'Pyidaungsu', sans-serif; background: #0f172a; margin:0; padding:20px; display:flex; justify-content:center; align-items:center; min-height:100vh; }
        </style>
    </head>
    <body>";

    if (mysqli_query($db, $sql)) {
        $booking_id = mysqli_insert_id($db);
        $formatted_price = number_format($total_price) . " Ks";
        
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'ဘိုကင်တင်ခြင်း အောင်မြင်ပါသည်',
                html: `
                    <div style='text-align:center; margin-bottom:15px;'>
                        <span style='background:#10b981; color:white; padding:5px 15px; border-radius:20px; font-size:14px;'>ဘိုကင်နံပါတ်: #{$booking_id}</span>
                    </div>
                    <div style='text-align:center; margin-bottom:10px; color:#64748b;'>ဂိတ်မှ အတည်ပြုချက်ကို စောင့်ဆိုင်းပေးပါ။</div>
                    <table style='width:100%; border-collapse:collapse; margin-top:10px; text-align:left; background:#f8fafc; border-radius:10px; padding:10px;'>
                        <tr><td style='padding:8px; font-weight:bold; color:#475569;'>အမည်:</td><td style='padding:8px;'>{$customer_name}</td></tr>
                        <tr><td style='padding:8px; font-weight:bold; color:#475569;'>ဖုန်း:</td><td style='padding:8px;'>{$customer_phone}</td></tr>
                        <tr><td style='padding:8px; font-weight:bold; color:#475569;'>ခုံနံပါတ်:</td><td style='padding:8px;'><b style='color:#2563eb; background:#dbeafe; padding:3px 10px; border-radius:15px;'>{$seat_no}</b></td></tr>
                        <tr><td style='padding:8px; font-weight:bold; color:#475569;'>ငွေပမာဏ:</td><td style='padding:8px;'><b style='color:#10b981; font-size:18px;'>{$formatted_price}</b></td></tr>
                    </table>
                `,
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'မှတ်တမ်းများသို့ သွားမည်',
                allowOutsideClick: false,
                showCancelButton: true,
                cancelButtonColor: '#64748b',
                cancelButtonText: 'နောက်ထပ်ဘိုကင်ထပ်မည်'
            }).then((result) => { 
                if (result.isConfirmed) {
                    window.location.href = 'bushistory.php'; 
                } else {
                    window.location.href = 'bus_list.php'; 
                }
            });
        </script>";
    } else {
        $error_msg = mysqli_error($db);
        echo "
        <script>
            Swal.fire({
                icon: 'error', 
                title: 'မှားယွင်းမှု ဖြစ်ပေါ်ခဲ့ပါသည်', 
                html: `
                    <div style='color:#dc2626; margin-bottom:10px;'>ဒေတာသိမ်းဆည်း၍ မရပါ</div>
                    <div style='background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; font-size:14px;'>${error_msg}</div>
                `,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'ပြန်ကြိုးစားမည်'
            }).then(() => { 
                window.history.back(); 
            });
        </script>";
    }
    echo "</body></html>";
} else {
    // POST method မဟုတ်ရင် bus_list ကို ပြန်ပို့မယ်
    header("Location: bus_list.php");
    exit();
}
?>