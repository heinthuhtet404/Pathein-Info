<?php
session_start();
include("Admin/db.php");

// --- AUTHENTICATION GUARD ---
if (!isset($_SESSION['customer_id'])) {
    $current_url = "bus_detail.php?bus_id=" . (isset($_GET['bus_id']) ? $_GET['bus_id'] : (isset($_GET['id']) ? $_GET['id'] : '')) . 
                   "&route_id=" . (isset($_GET['route_id']) ? $_GET['route_id'] : '');
    header("Location: buslogin.php?redirect=" . urlencode($current_url));
    exit();
}

// Get parameters - id ရော bus_id ရော လက်ခံအောင်လုပ်
$bus_id = isset($_GET['bus_id']) ? intval($_GET['bus_id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
$route_id = isset($_GET['route_id']) ? intval($_GET['route_id']) : 0;

$bus = null;
if ($bus_id > 0 && $route_id > 0) {
    // ONE BUS - ONE ROUTE: busline_id နဲ့ချိတ်အောင်ပြင်ဆင်
    $bus_query = "SELECT 
                    b.*, 
                    r.price, 
                    r.start_point, 
                    r.end_point, 
                    r.route_name,
                    r.time,
                    r.Date,
                    r.image as route_image,
                    r.id as route_id 
                  FROM bus_line b 
                  INNER JOIN bus_route r ON b.busline_id = r.busline_id 
                  WHERE b.busline_id = $bus_id AND r.id = $route_id AND b.status = 'active'
                  LIMIT 1";
    
    $bus_res = mysqli_query($db, $bus_query);
    
    if (!$bus_res) {
        die("Query Error: " . mysqli_error($db));
    }
    
    $bus = mysqli_fetch_assoc($bus_res);
}

if (!$bus) {
    // Debug information
    echo "<div class='container mt-5 text-center'>";
    echo "<h4>ဂိတ်အချက်အလက် ရှာမတွေ့ပါ။</h4>";
    echo "<p>Bus ID: " . $bus_id . "</p>";
    echo "<p>Route ID: " . $route_id . "</p>";
    echo "<a href='bus_routes.php?type=0' class='btn btn-primary mt-3'>ပြန်သွားရန်</a>";
    echo "</div>";
    exit();
}

// Get booked and pending seats
$booked_seats = []; 
$pending_seats = []; 

$booking_query = "SELECT seat_number, status FROM bus_booking WHERE bus_id = $bus_id AND route_id = $route_id AND status != 'cancelled'";
$booking_res = mysqli_query($db, $booking_query);

if ($booking_res) {
    while($row = mysqli_fetch_assoc($booking_res)) {
        $s_list = explode(',', $row['seat_number']);
        foreach($s_list as $s) {
            $seat_no = trim($s);
            if (!empty($seat_no)) {
                ($row['status'] == 'confirmed') ? $booked_seats[] = $seat_no : $pending_seats[] = $seat_no;
            }
        }
    }
}

// Use route image if available, otherwise use bus image
$display_image = !empty($bus['route_image']) ? $bus['route_image'] : ($bus['image'] ?? '');
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Booking - <?= htmlspecialchars($bus['busline_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Pyidaungsu:wght@400;700&display=swap');
        
        :root { 
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.4);
            --accent: #1e40af;
        }

        body { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
            background-size: cover; background-position: center; background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', 'Pyidaungsu', sans-serif;
            min-height: 100vh; margin: 0; display: flex; align-items: center; padding: 20px 0;
        }

        .main-wrapper {
            max-width: 1200px; margin: auto; width: 95%;
            background: var(--glass-bg); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border); border-radius: 40px;
            display: flex; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); overflow: hidden;
        }

        .side-panel { width: 260px; background: rgba(30, 41, 59, 0.95); color: white; display: flex; flex-direction: column; padding: 20px; }
        .bus-badge { background: var(--accent); color: white; padding: 15px; border-radius: 15px; text-align: center; margin-bottom: 20px; }
        .route-name { font-size: 0.8rem; opacity: 0.9; margin-top: 5px; }
        .qr-card { background: rgba(255,255,255,0.08); border-radius: 20px; padding: 12px; margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.1); }
        .qr-img { width: 70px; height: 70px; border-radius: 8px; filter: brightness(1.1); object-fit: cover; }

        .seat-panel { flex: 1; padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .bus-frame {
            background: #fff; padding: 25px; border-radius: 40px 40px 15px 15px;
            border: 5px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-height: 75vh; overflow-y: auto;
        }
        .seat-grid { display: grid; grid-template-columns: repeat(2, 38px) 30px repeat(2, 38px); gap: 10px; }
        .seat { 
            width: 38px; height: 40px; background: #e2e8f0; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
            font-size: 10px; font-weight: bold; transition: 0.3s; border-bottom: 3px solid #cbd5e1;
        }
        .seat.booked { background: #ef4444 !important; color: white !important; cursor: not-allowed; border-color: #b91c1c; }
        .seat.pending { background: #f59e0b !important; color: white !important; cursor: not-allowed; border-color: #b45309; }
        .seat.selected { background: #10b981 !important; color: white !important; border-color: #059669 !important; transform: scale(1.1); }

        .aisle { display: flex; align-items: center; justify-content: center; font-size: 11px; color: #94a3b8; font-weight: bold; }
        .form-panel { width: 360px; padding: 25px; display: flex; flex-direction: column; background: rgba(255,255,255,0.4); border-left: 1px solid var(--glass-border); overflow-y: auto; }
        .info-pill { background: white; border-radius: 18px; padding: 15px; margin-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-control { border-radius: 12px; border: 1px solid #d1d5db; padding: 8px 12px; background: rgba(255,255,255,0.9); font-size: 0.9rem; }
        .checkout-card { margin-top: 15px; background: #1e293b; color: white; padding: 20px; border-radius: 25px; }
        .btn-book { background: #2563eb; color: white; border: none; width: 100%; padding: 12px; border-radius: 15px; font-weight: bold; margin-top: 10px; transition: 0.3s; }
        .btn-book:hover { background: #1d4ed8; transform: translateY(-2px); }
        
        @media (max-width: 992px) {
            body { height: auto; }
            .main-wrapper { flex-direction: column; border-radius: 20px; }
            .side-panel, .form-panel { width: 100%; }
            .bus-frame { max-height: 50vh; }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Left Panel -->
    <div class="side-panel">
        <div class="bus-badge">
            <i class="fa fa-bus-alt mb-2 fa-2x"></i>
            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($bus['busline_name']) ?></h6>
            <?php if(!empty($bus['route_name'])): ?>
                <small class="route-name"><i class="fas fa-route me-1"></i><?= htmlspecialchars($bus['route_name']) ?></small>
            <?php endif; ?>
        </div>
        
        <div class="qr-section">
            <p class="text-center small opacity-75 mb-3">Scan to Pay</p>
            <div class="qr-card d-flex align-items-center gap-3">
                <img src="uploads/kpay_qr.png" class="qr-img" alt="KBZ Pay QR">
                <div><small class="d-block fw-bold">KBZ Pay</small><small class="opacity-75">09 *** ***181</small></div>
            </div>
            <div class="qr-card d-flex align-items-center gap-3">
                <img src="uploads/wave_qr.png" class="qr-img" alt="Wave Pay QR">
                <div><small class="d-block fw-bold">Wave Pay</small><small class="opacity-75">09 *** ***822</small></div>
            </div>
        </div>
        
        <div class="mt-auto text-center mt-3">
            <?php if(!empty($display_image)): ?>
                <img src="Admin/uploads/<?= htmlspecialchars($display_image) ?>" 
                     style="width:100%; border-radius:15px; border: 2px solid rgba(255,255,255,0.2);" 
                     alt="Bus Image">
            <?php else: ?>
                <div style="width:100%; height:100px; background: rgba(255,255,255,0.1); border-radius:15px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-bus fa-3x opacity-50"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Seat Selection Panel -->
    <div class="seat-panel">
        <div class="bus-frame">
            <div class="seat-grid">
                <div style="grid-column: 5; text-align: center;"><i class="fas fa-dharmachakra fa-2x text-secondary"></i></div>
                <?php 
                // Get total seats from bus_line table
                $total_seats = isset($bus['total_seat']) ? intval($bus['total_seat']) : 40;
                $rows = ceil($total_seats / 4); // 4 seats per row (A,B,C,D)
                
                for($r = 1; $r <= $rows; $r++) {
                    // Left side seats (A, B)
                    foreach(['A','B'] as $c) {
                        $no = $r.$c;
                        $cls = in_array($no, $booked_seats) ? 'booked' : (in_array($no, $pending_seats) ? 'pending' : 'available');
                        $click_attr = ($cls == 'available') ? "onclick='toggleSeat(this,\"$no\")'" : "";
                        echo "<div class='seat $cls' $click_attr>$no</div>";
                    }
                    
                    // Aisle with row number
                    echo "<div class='aisle'>$r</div>";
                    
                    // Right side seats (C, D)
                    foreach(['C','D'] as $c) {
                        $no = $r.$c;
                        $cls = in_array($no, $booked_seats) ? 'booked' : (in_array($no, $pending_seats) ? 'pending' : 'available');
                        $click_attr = ($cls == 'available') ? "onclick='toggleSeat(this,\"$no\")'" : "";
                        echo "<div class='seat $cls' $click_attr>$no</div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="d-flex gap-3 mt-3 small fw-bold">
            <div class="d-flex align-items-center gap-1"><span class="badge bg-danger p-2">&nbsp;</span> ရောင်းပြီး</div>
            <div class="d-flex align-items-center gap-1"><span class="badge bg-warning p-2">&nbsp;</span> စောင့်ဆိုင်း</div>
            <div class="d-flex align-items-center gap-1"><span class="badge bg-success p-2">&nbsp;</span> သင်ရွေးထား</div>
            <div class="d-flex align-items-center gap-1"><span class="badge bg-secondary p-2">&nbsp;</span> ရနိုင်သော</div>
        </div>
    </div>

    <!-- Booking Form Panel -->
    <div class="form-panel">
        <div class="info-pill">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-primary px-3 py-2"><?= htmlspecialchars($bus['start_point'] ?? 'N/A') ?></span>
                <i class="fa fa-long-arrow-right text-muted"></i>
                <span class="badge bg-primary px-3 py-2"><?= htmlspecialchars($bus['end_point'] ?? 'N/A') ?></span>
            </div>
            <?php if(!empty($bus['time'])): ?>
                <div class="text-center small text-muted">
                    <i class="far fa-clock me-1"></i> <?= htmlspecialchars($bus['time']) ?>
                    <?php if(!empty($bus['Date'])): ?>
                        | <i class="far fa-calendar me-1"></i> <?= date('d-m-Y', strtotime($bus['Date'])) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="text-center fw-bold text-primary mt-2 fs-5"><?= number_format($bus['price'] ?? 0) ?> Ks <small class="text-muted">/ ခုံ</small></div>
        </div>

        <form action="save_Busbooking.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <input type="hidden" name="user_id" value="<?= $bus['user_id'] ?? 0 ?>">
            <input type="hidden" name="bus_id" value="<?= $bus_id ?>">
            <input type="hidden" name="route_id" value="<?= $bus['route_id'] ?>">
            <input type="hidden" name="customer_id" value="<?= $_SESSION['customer_id'] ?>">

            <div class="mb-3">
                <label class="small fw-bold mb-1">ရွေးချယ်ထားသောခုံများ</label>
                <input type="text" name="seat_no" id="display_seat" class="form-control fw-bold" placeholder="ခုံရွေးပါ" readonly required>
                <small class="text-muted">ခုံနံပါတ်များကို နှိပ်၍ ရွေးချယ်ပါ</small>
            </div>
            
            <div class="mb-2">
                <label class="small fw-bold mb-1">ဝယ်ယူသူအမည်</label>
                <input type="text" name="customer_name" class="form-control" value="<?= htmlspecialchars($_SESSION['customer_name'] ?? '') ?>" required>
            </div>
            
            <div class="mb-2">
                <label class="small fw-bold mb-1">Email (အီးမေးလ်)</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['customer_email'] ?? '') ?>" required>
            </div>
            
            <div class="mb-2">
                <label class="small fw-bold mb-1">NRC (မှတ်ပုံတင်အမှတ်)</label>
                <input type="text" name="NRC" class="form-control" placeholder="ဥပမာ - ၁၂/မမန(၁)၁၂၃၄၅၆" required>
            </div>
            
            <div class="mb-2">
                <label class="small fw-bold mb-1">ဆက်သွယ်ရန်ဖုန်း</label>
                <input type="tel" name="phone" class="form-control" placeholder="09xxxxxxxx" required>
            </div>
            
            <div class="mb-2">
                <label class="small fw-bold mb-1">ငွေလွှဲပြေစာတင်ရန်</label>
                <input type="file" name="payment_slip" class="form-control" accept="image/*" required>
                <small class="text-muted">KBZ Pay သို့မဟုတ် Wave Pay ပြေစာ</small>
            </div>

            <div class="checkout-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small opacity-75">စုစုပေါင်း</span>
                    <span class="h4 mb-0 fw-bold" id="total_price_display">0 Ks</span>
                    <input type="hidden" name="total_price" id="total_price_input">
                </div>
                <button type="submit" class="btn btn-book" id="submitBtn">
                    <i class="fas fa-ticket-alt me-2"></i>ဘိုကင်တင်မည်
                </button>
            </div>
        </form>
        
        <div class="text-center mt-2">
            <a href="bus_routes.php?type=0" class="text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i>နောက်သို့
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let selectedSeats = [];
const unitPrice = <?= $bus['price'] ?? 0 ?>;

function toggleSeat(el, no) {
    if (el.classList.contains('booked') || el.classList.contains('pending')) {
        Swal.fire({
            icon: 'warning',
            title: 'ခုံနေရာ မရနိုင်ပါ',
            text: 'ဤခုံနေရာကို ရွေးချယ်၍မရပါ။',
            timer: 1500,
            showConfirmButton: false
        });
        return;
    }
    
    if (selectedSeats.includes(no)) {
        selectedSeats = selectedSeats.filter(s => s !== no);
        el.classList.remove('selected');
    } else {
        selectedSeats.push(no);
        el.classList.add('selected');
    }
    
    // Sort seats naturally (1A, 1B, 1C, 1D, 2A, etc.)
    selectedSeats.sort((a, b) => {
        const aNum = parseInt(a.slice(0, -1));
        const bNum = parseInt(b.slice(0, -1));
        if (aNum !== bNum) return aNum - bNum;
        return a.slice(-1).localeCompare(b.slice(-1));
    });
    
    document.getElementById('display_seat').value = selectedSeats.join(', ');
    const total = selectedSeats.length * unitPrice;
    document.getElementById('total_price_display').innerText = total.toLocaleString() + " Ks";
    document.getElementById('total_price_input').value = total;
}

function validateForm() {
    if (selectedSeats.length === 0) { 
        Swal.fire({ 
            icon: 'warning', 
            title: 'ခုံနေရာရွေးချယ်ပေးပါ', 
            text: 'ခရီးစဉ်အတွက် အနည်းဆုံး ခုံတစ်ခုံ ရွေးချယ်ရန် လိုအပ်ပါသည်။',
            confirmButtonColor: '#2563eb'
        });
        return false; 
    }
    
    // Check if NRC field is empty
    const nrc = document.querySelector('input[name="NRC"]').value.trim();
    if (!nrc) {
        Swal.fire({
            icon: 'warning',
            title: 'NRC ထည့်သွင်းပါ',
            text: 'မှတ်ပုံတင်အမှတ် ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            confirmButtonColor: '#2563eb'
        });
        return false;
    }
    
    // Check if phone field is empty
    const phone = document.querySelector('input[name="phone"]').value.trim();
    if (!phone) {
        Swal.fire({
            icon: 'warning',
            title: 'ဖုန်းနံပါတ် ထည့်သွင်းပါ',
            text: 'ဆက်သွယ်ရန်ဖုန်းနံပါတ် ထည့်သွင်းရန် လိုအပ်ပါသည်။',
            confirmButtonColor: '#2563eb'
        });
        return false;
    }
    
    // Check if payment slip is selected
    const slip = document.querySelector('input[name="payment_slip"]').value;
    if (!slip) {
        Swal.fire({
            icon: 'warning',
            title: 'ငွေလွှဲပြေစာတင်ပါ',
            text: 'ငွေလွှဲပြေစာပုံကို ရွေးချယ်တင်ပေးပါ။',
            confirmButtonColor: '#2563eb'
        });
        return false;
    }
    
    // Show loading
    Swal.fire({ 
        title: 'ဘိုကင်တင်နေပါသည်...', 
        html: 'ခဏစောင့်ပါ',
        allowOutsideClick: false, 
        didOpen: () => { 
            Swal.showLoading(); 
        }
    });
    return true;
}
</script>
</body>
</html>