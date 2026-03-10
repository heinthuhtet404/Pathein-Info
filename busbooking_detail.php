<?php
session_start();
include("Admin/db.php");

// Authentication check
if (!isset($_SESSION['customer_id'])) {
    header("Location: buslogin.php?redirect=" . urlencode("bushistory.php"));
    exit();
}

$customer_id = $_SESSION['customer_id'];
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($booking_id == 0) {
    $_SESSION['error_message'] = "မှားယွင်းသော ဘိုကင်နံပါတ်";
    header("Location: bushistory.php");
    exit();
}

// Get booking details
$query = "SELECT b.*, 
                 bl.busline_name, 
                 bl.phone as bus_phone,
                 bl.address,
                 bl.description as bus_description,
                 br.start_point, 
                 br.end_point, 
                 br.time, 
                 br.Date,
                 br.price as route_price,
                 br.route_name
          FROM bus_booking b
          LEFT JOIN bus_line bl ON b.bus_id = bl.busline_id
          LEFT JOIN bus_route br ON b.route_id = br.id
          WHERE b.booking_id = $booking_id AND b.user_id = $customer_id
          LIMIT 1";

$result = mysqli_query($db, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['error_message'] = "ဘိုကင်အချက်အလက် ရှာမတွေ့ပါ။";
    header("Location: bushistory.php");
    exit();
}

$booking = mysqli_fetch_assoc($result);

// Check if admin just confirmed
if (isset($_GET['confirmed']) && $_GET['confirmed'] == 1) {
    $show_confirmed_alert = true;
} else {
    $show_confirmed_alert = false;
}

// Format data
$seats = explode(',', $booking['seat_number']);
$seat_list = implode(', ', array_map('trim', $seats));
$total_amount = number_format($booking['price']) . " Ks";
$booking_date = date('d-m-Y', strtotime($booking['booking_date']));
$travel_date = $booking['Date'] ? date('d-m-Y', strtotime($booking['Date'])) : 'N/A';
$travel_time = $booking['time'] ? date('h:i A', strtotime($booking['time'])) : 'N/A';

// Status text
if ($booking['status'] == 'confirmed') {
    $status_text = 'အတည်ပြုပြီး';
    $status_color = '#28a745';
} elseif ($booking['status'] == 'pending') {
    $status_text = 'စောင့်ဆိုင်းဆဲ';
    $status_color = '#ffc107';
} else {
    $status_text = 'ပယ်ဖျက်ထား';
    $status_color = '#dc3545';
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ဘိုကင်အသေးစိတ်</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        body {
            font-family: 'Pyidaungsu', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="hidden" id="bookingData"
     data-busname="<?php echo htmlspecialchars($booking['busline_name'] ?? 'N/A'); ?>"
     data-customer="<?php echo htmlspecialchars($booking['customer_name']); ?>"
     data-phone="<?php echo htmlspecialchars($booking['phone']); ?>"
     data-email="<?php echo htmlspecialchars($booking['email']); ?>"
     data-nrc="<?php echo htmlspecialchars($booking['NRC']); ?>"
     data-route="<?php echo htmlspecialchars(($booking['start_point'] ?? 'N/A') . ' → ' . ($booking['end_point'] ?? 'N/A')); ?>"
     data-route-name="<?php echo htmlspecialchars($booking['route_name'] ?? 'N/A'); ?>"
     data-travel-date="<?php echo $travel_date; ?>"
     data-travel-time="<?php echo $travel_time; ?>"
     data-seats="<?php echo htmlspecialchars($seat_list); ?>"
     data-price="<?php echo $total_amount; ?>"
     data-booking-date="<?php echo $booking_date; ?>"
     data-booking-id="<?php echo $booking_id; ?>"
     data-status="<?php echo $status_text; ?>"
     data-status-color="<?php echo $status_color; ?>"
     data-payment-slip="<?php echo !empty($booking['payment_slip']) ? 'Admin/uploads/' . $booking['payment_slip'] : ''; ?>"
     data-show-confirmed="<?php echo $show_confirmed_alert ? '1' : '0'; ?>">
</div>

<script>
// Get data from hidden div
const dataDiv = document.getElementById('bookingData');
const busName = dataDiv.dataset.busname;
const customerName = dataDiv.dataset.customer;
const phone = dataDiv.dataset.phone;
const email = dataDiv.dataset.email;
const nrc = dataDiv.dataset.nrc;
const route = dataDiv.dataset.route;
const routeName = dataDiv.dataset.routeName;
const travelDate = dataDiv.dataset.travelDate;
const travelTime = dataDiv.dataset.travelTime;
const seats = dataDiv.dataset.seats;
const price = dataDiv.dataset.price;
const bookingDate = dataDiv.dataset.bookingDate;
const bookingId = dataDiv.dataset.bookingId;
const status = dataDiv.dataset.status;
const statusColor = dataDiv.dataset.statusColor;
const paymentSlip = dataDiv.dataset.paymentSlip;
const showConfirmed = dataDiv.dataset.showConfirmed;

// Show confirmed alert if needed
if (showConfirmed === '1') {
    Swal.fire({
        icon: 'success',
        title: 'အတည်ပြုပြီးပါပြီ',
        text: 'သင်၏ဘိုကင်ကို ဂိတ်မှ အတည်ပြုပေးလိုက်ပါပြီ။',
        confirmButtonColor: '#28a745',
        confirmButtonText: 'အိုကေပါပြီ',
        timer: 3000,
        timerProgressBar: true
    });
}

// Create HTML content for SweetAlert
let htmlContent = `
    <div style="text-align: left; font-family: 'Pyidaungsu', sans-serif; max-height: 70vh; overflow-y: auto; padding: 10px;">
        <div style="background: ${statusColor}; color: white; padding: 8px 15px; border-radius: 50px; display: inline-block; margin-bottom: 15px; font-weight: bold;">
            ${status}
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr style="background: #f8f9fa;">
                <td colspan="2" style="padding: 10px; font-weight: bold; color: #004e92; border-bottom: 2px solid #004e92;">
                    <i class="fas fa-bus"></i> ကားလိုင်း: ${busName}
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057; width: 40%;"><i class="fas fa-user"></i> ခရီးသည်အမည်:</td>
                <td style="padding: 8px;">${customerName}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-phone"></i> ဖုန်းနံပါတ်:</td>
                <td style="padding: 8px;">${phone}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-envelope"></i> အီးမေးလ်:</td>
                <td style="padding: 8px;">${email}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-id-card"></i> NRC:</td>
                <td style="padding: 8px;">${nrc}</td>
            </tr>
            <tr style="background: #f8f9fa;">
                <td colspan="2" style="padding: 10px; font-weight: bold; color: #004e92; border-bottom: 2px solid #004e92; border-top: 2px solid #dee2e6;">
                    <i class="fas fa-route"></i> ခရီးစဉ်အချက်အလက်
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-map-marker-alt"></i> လမ်းကြောင်း:</td>
                <td style="padding: 8px;">${route}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-tag"></i> ခရီးစဉ်အမည်:</td>
                <td style="padding: 8px;">${routeName}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-calendar-alt"></i> ခရီးစဉ်ရက်စွဲ:</td>
                <td style="padding: 8px;">${travelDate}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-clock"></i> ထွက်ခွာချိန်:</td>
                <td style="padding: 8px;">${travelTime}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-chair"></i> ခုံအမှတ်များ:</td>
                <td style="padding: 8px;"><span style="background: #004e92; color: white; padding: 3px 10px; border-radius: 20px;">${seats}</span></td>
            </tr>
            <tr style="background: #f8f9fa;">
                <td colspan="2" style="padding: 10px; font-weight: bold; color: #004e92; border-bottom: 2px solid #004e92; border-top: 2px solid #dee2e6;">
                    <i class="fas fa-money-bill-wave"></i> ငွေပေးချေမှုအချက်အလက်
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-money-bill"></i> စုစုပေါင်းငွေပမာဏ:</td>
                <td style="padding: 8px;"><span style="background: #28a745; color: white; padding: 3px 15px; border-radius: 20px; font-weight: bold;">${price}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-calendar-check"></i> ဘိုကင်တင်ရက်စွဲ:</td>
                <td style="padding: 8px;">${bookingDate}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-hashtag"></i> ဘိုကင်နံပါတ်:</td>
                <td style="padding: 8px;"><span style="background: #6c757d; color: white; padding: 3px 10px; border-radius: 20px;">#${bookingId}</span></td>
            </tr>
`;

// Add payment slip if exists
if (paymentSlip) {
    htmlContent += `
            <tr>
                <td style="padding: 8px; font-weight: bold; color: #495057;"><i class="fas fa-image"></i> ငွေလွှဲပြေစာ:</td>
                <td style="padding: 8px;">
                    <img src="${paymentSlip}" style="max-width: 200px; max-height: 150px; border-radius: 10px; cursor: pointer;" onclick="window.open('${paymentSlip}', '_blank')">
                </td>
            </tr>
    `;
}

htmlContent += `
        </table>
    </div>
`;

// Show SweetAlert
Swal.fire({
    title: 'ဘိုကင်အသေးစိတ်',
    html: htmlContent,
    icon: 'info',
    width: '600px',
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonColor: '#004e92',
    cancelButtonColor: '#6c757d',
    confirmButtonText: '<i class="fas fa-print"></i> ပုံနှိပ်ရန်',
    cancelButtonText: '<i class="fas fa-arrow-left"></i> နောက်သို့',
    showCloseButton: true,
    allowOutsideClick: false
}).then((result) => {
    if (result.isConfirmed) {
        // Print function
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>ဘိုကင်အသေးစိတ် - #${bookingId}</title>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
                    body { font-family: 'Pyidaungsu', sans-serif; padding: 30px; }
                    .print-header { text-align: center; margin-bottom: 30px; }
                    .print-title { color: #004e92; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    td { padding: 10px; border-bottom: 1px solid #ddd; }
                    .label { font-weight: bold; color: #495057; width: 40%; }
                    .value { color: #000; }
                    .status { background: ${statusColor}; color: white; padding: 5px 15px; border-radius: 50px; display: inline-block; }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h2 class="print-title">ဘိုကင်အသေးစိတ်</h2>
                    <div class="status">${status}</div>
                </div>
                <table>
                    <tr><td class="label">ကားလိုင်း:</td><td class="value">${busName}</td></tr>
                    <tr><td class="label">ခရီးသည်အမည်:</td><td class="value">${customerName}</td></tr>
                    <tr><td class="label">ဖုန်းနံပါတ်:</td><td class="value">${phone}</td></tr>
                    <tr><td class="label">အီးမေးလ်:</td><td class="value">${email}</td></tr>
                    <tr><td class="label">NRC:</td><td class="value">${nrc}</td></tr>
                    <tr><td class="label">လမ်းကြောင်း:</td><td class="value">${route}</td></tr>
                    <tr><td class="label">ခရီးစဉ်ရက်စွဲ:</td><td class="value">${travelDate}</td></tr>
                    <tr><td class="label">ထွက်ခွာချိန်:</td><td class="value">${travelTime}</td></tr>
                    <tr><td class="label">ခုံအမှတ်များ:</td><td class="value">${seats}</td></tr>
                    <tr><td class="label">စုစုပေါင်းငွေပမာဏ:</td><td class="value">${price}</td></tr>
                    <tr><td class="label">ဘိုကင်တင်ရက်စွဲ:</td><td class="value">${bookingDate}</td></tr>
                    <tr><td class="label">ဘိုကင်နံပါတ်:</td><td class="value">#${bookingId}</td></tr>
                </table>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    } else {
        window.location.href = 'bushistory.php';
    }
});
</script>
</body>
</html>