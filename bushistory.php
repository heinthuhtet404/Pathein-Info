<?php
session_start();
include("Admin/db.php");

// --- AUTHENTICATION GUARD ---
if (!isset($_SESSION['customer_id'])) {
    header("Location: buslogin.php?redirect=" . urlencode("bushistory.php"));
    exit();
}

$customer_id = $_SESSION['customer_id'];
$customer_name = $_SESSION['customer_name'];

// ဘိုကင်မှတ်တမ်းများ ရယူခြင်း
$query = "SELECT b.*, 
                 bl.busline_name, 
                 bl.phone as bus_phone,
                 bl.address,
                 bl.user_id as bus_owner_id,
                 br.start_point, 
                 br.end_point, 
                 br.time, 
                 br.Date,
                 br.price as route_price
          FROM bus_booking b
          LEFT JOIN bus_line bl ON b.bus_id = bl.busline_id
          LEFT JOIN bus_route br ON b.route_id = br.id
          WHERE b.user_id = '$customer_id'
          ORDER BY b.booking_date DESC, b.booking_id DESC";

$result = mysqli_query($db, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($db));
}

$total_bookings = mysqli_num_rows($result);

// စာရင်းဇယားများ တွက်ချက်ခြင်း
$confirmed_count = 0;
$pending_count = 0;
$cancelled_count = 0;
$total_spent = 0;

$bookings = [];
while($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
    if($row['status'] == 'confirmed') {
        $confirmed_count++;
        $total_spent += $row['price'];
    } elseif($row['status'] == 'pending') {
        $pending_count++;
    } elseif($row['status'] == 'cancelled') {
        $cancelled_count++;
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus History - ခရီးစဉ်မှတ်တမ်း</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Pyidaungsu', sans-serif;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .history-header {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: 0.3s;
            height: 100%;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
        }
        
        .history-table {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: bold;
            display: inline-block;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .filter-btn {
            border-radius: 50px;
            padding: 8px 20px;
            margin: 0 5px 5px 0;
            border: 1px solid #dee2e6;
            background: white;
            transition: 0.3s;
            cursor: pointer;
        }
        
        .filter-btn.active {
            background: #004e92;
            color: white;
            border-color: #004e92;
        }
        
        .filter-btn:hover {
            background: #004e92;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        
        .btn-action {
            background: #004e92;
            color: white;
            border-radius: 50px;
            padding: 5px 15px;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
            border: none;
            transition: 0.3s;
            cursor: pointer;
        }
        
        .btn-action:hover {
            background: #003366;
            color: white;
        }
        
        .btn-danger-custom {
            background: #dc3545;
        }
        
        .btn-danger-custom:hover {
            background: #c82333;
        }
        
        .seat-badge {
            background: #e9ecef;
            color: #495057;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.85rem;
            margin: 2px;
            display: inline-block;
        }
        
        .booking-card {
            display: none;
        }
        
        .refresh-indicator {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            font-size: 0.85rem;
            z-index: 9999;
            display: none;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                display: none;
            }
            .booking-card {
                display: block;
            }
            .card-item {
                background: white;
                border-radius: 15px;
                padding: 15px;
                margin-bottom: 15px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
                padding: 0;
            }
            .history-header, .history-table {
                background: white;
                box-shadow: none;
                border: 1px solid #ddd;
                border-radius: 10px;
            }
        }
    </style>
</head>
<body>

<div class="refresh-indicator" id="refreshIndicator">
    <i class="fas fa-sync-alt fa-spin me-2"></i>
    <span>အချက်အလက်များ ပြန်လည်စစ်ဆေးနေသည်...</span>
</div>

<div class="main-container">
    <!-- History Header -->
    <div class="history-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3 class="fw-bold mb-2">
                    <i class="fas fa-history me-2 text-primary"></i>
                    <?php echo htmlspecialchars($customer_name); ?> ၏ ခရီးစဉ်မှတ်တမ်း
                </h3>
                <p class="text-muted mb-0">
                    <i class="fas fa-ticket-alt me-2"></i>
                    စုစုပေါင်းဘိုကင်: <strong><?php echo $total_bookings; ?></strong> ခု
                </p>
            </div>
            <div class="mt-3 mt-md-0 no-print">
                <a href="bus_list.php?type=0" class="btn btn-outline-primary rounded-pill px-4 me-2">
                    <i class="fas fa-arrow-left me-2"></i>နောက်သို့
                </a>
                <button onclick="window.location.reload()" class="btn btn-outline-success rounded-pill px-4 me-2">
                    <i class="fas fa-sync-alt me-2"></i>ပြန်လည်စစ်ဆေးရန်
                </button>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4 g-3 no-print">
        <div class="col-md-3 col-6">
            <div class="stats-card">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h4 class="fw-bold mb-1"><?php echo $total_bookings; ?></h4>
                <p class="text-muted mb-0 small">စုစုပေါင်းဘိုကင်</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stats-card">
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4 class="fw-bold mb-1"><?php echo $confirmed_count; ?></h4>
                <p class="text-muted mb-0 small">အတည်ပြုပြီး</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stats-card">
                <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <h4 class="fw-bold mb-1"><?php echo $pending_count; ?></h4>
                <p class="text-muted mb-0 small">စောင့်ဆိုင်းဆဲ</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stats-card">
                <div class="stats-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h4 class="fw-bold mb-1"><?php echo number_format($total_spent); ?> Ks</h4>
                <p class="text-muted mb-0 small">စုစုပေါင်းသုံးစွဲမှု</p>
            </div>
        </div>
    </div>
    
    <!-- Filter Buttons -->
    <div class="row mb-4 no-print g-2">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                <button class="filter-btn active" onclick="filterBookings('all')">
                    <i class="fas fa-list me-2"></i>အားလုံး (<?php echo $total_bookings; ?>)
                </button>
                <button class="filter-btn" onclick="filterBookings('confirmed')">
                    <i class="fas fa-check-circle me-2"></i>အတည်ပြုပြီး (<?php echo $confirmed_count; ?>)
                </button>
                <button class="filter-btn" onclick="filterBookings('pending')">
                    <i class="fas fa-clock me-2"></i>စောင့်ဆိုင်းဆဲ (<?php echo $pending_count; ?>)
                </button>
                <button class="filter-btn" onclick="filterBookings('cancelled')">
                    <i class="fas fa-times-circle me-2"></i>ပယ်ဖျက်ထား (<?php echo $cancelled_count; ?>)
                </button>
            </div>
        </div>
    </div>
    
    <!-- History Table -->
    <div class="history-table">
        <?php if($total_bookings > 0): ?>
            <!-- Desktop Table View -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="bookingTable">
                    <thead class="table-light">
                        <tr>
                            <th>စဉ်</th>
                            <th>ကားလိုင်း</th>
                            <th>ခရီးစဉ်</th>
                            <th>ထွက်ခွာမည့်ရက်/အချိန်</th>
                            <th>ခုံအမှတ်</th>
                            <th>ငွေပမာဏ</th>
                            <th>ဘိုကင်ရက်စွဲ</th>
                            <th>အခြေအနေ</th>
                            <th class="no-print">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($bookings as $booking): 
                        ?>
                        <tr class="booking-row" data-status="<?php echo $booking['status']; ?>">
                            <td><?php echo $no++; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($booking['busline_name'] ?? 'N/A'); ?></strong>
                            </td>
                            <td>
                                <?php 
                                $start = $booking['start_point'] ?? 'N/A';
                                $end = $booking['end_point'] ?? 'N/A';
                                echo htmlspecialchars($start . ' → ' . $end); 
                                ?>
                            </td>
                            <td>
                                <?php 
                                if($booking['Date']) {
                                    echo date('d-m-Y', strtotime($booking['Date']));
                                } else {
                                    echo 'N/A';
                                }
                                ?><br>
                                <small class="text-muted">
                                    <?php 
                                    if($booking['time']) {
                                        echo date('h:i A', strtotime($booking['time']));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </small>
                            </td>
                            <td>
                                <?php 
                                $seats = explode(',', $booking['seat_number']);
                                foreach($seats as $seat):
                                ?>
                                <span class="seat-badge"><?php echo trim($seat); ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <strong class="text-primary"><?php echo number_format($booking['price']); ?> Ks</strong>
                            </td>
                            <td>
                                <?php echo date('d-m-Y', strtotime($booking['booking_date'])); ?>
                            </td>
                            <td>
                                <?php
                                $status_class = '';
                                $status_text = '';
                                if($booking['status'] == 'confirmed') {
                                    $status_class = 'status-confirmed';
                                    $status_text = 'အတည်ပြုပြီး';
                                } elseif($booking['status'] == 'pending') {
                                    $status_class = 'status-pending';
                                    $status_text = 'စောင့်ဆိုင်းဆဲ';
                                } elseif($booking['status'] == 'cancelled') {
                                    $status_class = 'status-cancelled';
                                    $status_text = 'ပယ်ဖျက်ထား';
                                }
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </td>
                            <td class="no-print">
                                <div class="d-flex flex-column gap-1">
                                    <a href="busbooking_detail.php?id=<?php echo $booking['booking_id']; ?>" class="btn-action text-center" title="အသေးစိတ်ကြည့်ရန်">
                                        <i class="fas fa-eye me-1"></i>အသေးစိတ်
                                    </a>
                                    <?php if($booking['status'] == 'pending'): ?>
                                        <a href="buscancel_booking.php?id=<?php echo $booking['booking_id']; ?>" 
                                           class="btn-action btn-danger-custom text-center" 
                                           title="ပယ်ဖျက်ရန်" 
                                           onclick="return confirm('ဤဘိုကင်ကို ပယ်ဖျက်လိုပါသလား?\nပယ်ဖျက်ပြီးပါက ပြန်လည်ပြင်ဆင်၍ မရနိုင်ပါ။');">
                                            <i class="fas fa-times me-1"></i>ပယ်ဖျက်
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div class="booking-card">
                <?php 
                foreach($bookings as $booking): 
                ?>
                <div class="card-item booking-row" data-status="<?php echo $booking['status']; ?>">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($booking['busline_name'] ?? 'N/A'); ?></h5>
                        <?php
                        $status_class = '';
                        $status_text = '';
                        if($booking['status'] == 'confirmed') {
                            $status_class = 'status-confirmed';
                            $status_text = 'အတည်ပြုပြီး';
                        } elseif($booking['status'] == 'pending') {
                            $status_class = 'status-pending';
                            $status_text = 'စောင့်ဆိုင်းဆဲ';
                        } elseif($booking['status'] == 'cancelled') {
                            $status_class = 'status-cancelled';
                            $status_text = 'ပယ်ဖျက်ထား';
                        }
                        ?>
                        <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                    </div>
                    
                    <p class="mb-1">
                        <i class="fas fa-route text-primary me-2"></i>
                        <?php echo htmlspecialchars(($booking['start_point'] ?? 'N/A') . ' → ' . ($booking['end_point'] ?? 'N/A')); ?>
                    </p>
                    
                    <p class="mb-1">
                        <i class="fas fa-calendar-alt text-success me-2"></i>
                        <?php 
                        if($booking['Date']) {
                            echo date('d-m-Y', strtotime($booking['Date']));
                        } else {
                            echo 'N/A';
                        }
                        ?> 
                        <i class="fas fa-clock text-info ms-3 me-2"></i>
                        <?php 
                        if($booking['time']) {
                            echo date('h:i A', strtotime($booking['time']));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </p>
                    
                    <p class="mb-1">
                        <i class="fas fa-chair text-warning me-2"></i>
                        <?php 
                        $seats = explode(',', $booking['seat_number']);
                        foreach($seats as $seat):
                        ?>
                        <span class="seat-badge"><?php echo trim($seat); ?></span>
                        <?php endforeach; ?>
                    </p>
                    
                    <p class="mb-2">
                        <i class="fas fa-money-bill-wave text-danger me-2"></i>
                        <strong class="text-primary"><?php echo number_format($booking['price']); ?> Ks</strong>
                    </p>
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="booking_detail.php?id=<?php echo $booking['booking_id']; ?>" class="btn-action">
                            <i class="fas fa-eye me-1"></i>အသေးစိတ်
                        </a>
                        <?php if($booking['status'] == 'pending'): ?>
                            <a href="buscancel_booking.php?id=<?php echo $booking['booking_id']; ?>" 
                               class="btn-action btn-danger-custom" 
                               onclick="return confirm('ဤဘိုကင်ကို ပယ်ဖျက်လိုပါသလား?');">
                                <i class="fas fa-times me-1"></i>ပယ်ဖျက်
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <h5 class="mt-3">ခရီးစဉ်မှတ်တမ်း မရှိသေးပါ</h5>
                <p class="text-muted mb-4">သင်သည် လက်မှတ်များ ဝယ်ယူခြင်း မရှိသေးပါ။</p>
                <a href="bus_list.php?type=0" class="btn btn-primary rounded-pill px-5 py-3">
                    <i class="fas fa-bus me-2"></i>ခရီးစဉ်များကြည့်ရန်
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Filter function
function filterBookings(status) {
    var rows = document.getElementsByClassName('booking-row');
    var buttons = document.getElementsByClassName('filter-btn');
    
    for(var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('active');
    }
    event.target.classList.add('active');
    
    for(var i = 0; i < rows.length; i++) {
        if(status == 'all') {
            rows[i].style.display = '';
        } else {
            if(rows[i].getAttribute('data-status') == status) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}

// Auto Refresh every 30 seconds
function startAutoRefresh() {
    setInterval(function() {
        document.getElementById('refreshIndicator').style.display = 'block';
        window.location.reload();
    }, 30000);
}

window.onload = function() {
    startAutoRefresh();
};

// Check for session messages
<?php if(isset($_SESSION['success_message'])): ?>
    Swal.fire({
        icon: 'success',
        title: 'အောင်မြင်ပါသည်',
        text: '<?php echo $_SESSION['success_message']; ?>',
        confirmButtonColor: '#004e92'
    });
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error_message'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'မှားယွင်းမှုဖြစ်ပေါ်ခဲ့ပါသည်',
        text: '<?php echo $_SESSION['error_message']; ?>',
        confirmButtonColor: '#dc3545'
    });
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>