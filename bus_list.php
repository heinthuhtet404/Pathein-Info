<?php
session_start(); // Session ကို အပေါ်ဆုံးမှာ စဖွင့်ပါ
include("Admin/db.php");

$type_id = isset($_GET['type']) ? intval($_GET['type']) : 0;
$titles = ['ကားလမ်းကြောင်းများ', 'ရေလမ်းကြောင်းများ', 'ရထားလမ်းကြောင်းများ'];
$current_title = isset($titles[$type_id]) ? $titles[$type_id] : 'လမ်းကြောင်းများ';

$from = isset($_GET['from']) ? mysqli_real_escape_string($db, $_GET['from']) : '';
$to = isset($_GET['to']) ? mysqli_real_escape_string($db, $_GET['to']) : '';
$time = isset($_GET['time']) ? mysqli_real_escape_string($db, $_GET['time']) : '';
$date = isset($_GET['date']) ? mysqli_real_escape_string($db, $_GET['date']) : '';

if($type_id == 0) {
    // ONE BUS - ONE ROUTE: user_id ကနေ busline_id ကိုပြောင်းပြီး ချိတ်ဆက်
    $query = "SELECT 
                b.busline_id, 
                b.busline_name, 
                b.phone, 
                b.address, 
                b.description,
                b.user_id,
                r.id as route_id, 
                r.route_name,
                r.start_point, 
                r.end_point, 
                r.price, 
                r.time, 
                r.Date, 
                r.image
              FROM bus_line b 
              INNER JOIN bus_route r ON b.busline_id = r.busline_id 
              WHERE b.status = 'active'";
    
    // Search filters များထည့်ခြင်း
    if (!empty($from)) {
        $query .= " AND r.start_point LIKE '%$from%'";
    }
    if (!empty($to)) {
        $query .= " AND r.end_point LIKE '%$to%'";
    }
    if (!empty($time)) {
        $query .= " AND r.time LIKE '%$time%'";
    }
    if (!empty($date)) {
        $query .= " AND DATE(r.Date) = '$date'";
    }
    
    $query .= " ORDER BY b.busline_id DESC, r.id DESC";
    $result = mysqli_query($db, $query);
    
    if (!$result) {
        // Query error ရှိရင် ပြသမယ် (development အတွက်)
        // die("Query Error: " . mysqli_error($db));
        $result = false;
    }
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body { 
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), 
                        url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Pyidaungsu', sans-serif;
            color: #333;
            min-height: 100vh;
        }

        /* ပုံသေကပ်နေစေမည့် အပိုင်း (Sticky Section) */
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(0, 78, 146, 0.2);
            backdrop-filter: blur(15px);
            padding-bottom: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, rgba(0, 78, 146, 0.9), rgba(0, 4, 40, 0.9));
            color: white;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        /* User Login Icon Styling */
        .user-icon-container {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 1100;
        }
        
        .user-icon {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }
        
        .user-icon:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
            border-color: rgba(255,255,255,0.5);
        }
        
        .user-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            min-width: 200px;
            display: none;
            overflow: hidden;
        }
        
        .user-dropdown.show {
            display: block;
        }
        
        .user-dropdown a {
            padding: 12px 20px;
            display: block;
            color: #333;
            text-decoration: none;
            transition: 0.2s;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .user-dropdown a:hover {
            background: #f8f9fa;
            color: #004e92;
        }
        
        .user-dropdown a:last-child {
            border-bottom: none;
        }
        
        .user-name {
            background: #004e92;
            color: white !important;
            font-weight: bold;
        }
        
        .user-name:hover {
            background: #003366 !important;
            color: white !important;
        }

        /* Unique Search Box Styling */
        .unique-search-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            padding: 15px 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            margin-top: -15px;
        }

        .input-custom-group {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            padding: 5px 15px;
            display: flex;
            align-items: center;
            transition: 0.3s;
            border: 2px solid transparent;
        }

        .input-custom-group:focus-within {
            border-color: #004e92;
            box-shadow: 0 0 15px rgba(0, 78, 146, 0.2);
        }

        .input-custom-group input,
        .input-custom-group input[type="date"],
        .input-custom-group input[type="time"] {
            border: none;
            background: transparent;
            padding: 8px 10px;
            width: 100%;
            outline: none;
            font-size: 0.9rem;
        }

        .input-custom-group i {
            width: 20px;
            text-align: center;
        }

        .search-btn {
            background: #004e92;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50% !important;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            color: white;
        }

        .search-btn:hover {
            background: #00d2ff;
            transform: rotate(90deg) scale(1.1);
        }

        /* Table Card Styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 30px;
            margin-top: 20px;
        }

        .bus-img-card {
            width: 100px; 
            height: 70px;
            object-fit: cover; 
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .route-badge { 
            background: #f0f7ff; 
            color: #004e92; 
            padding: 5px 15px; 
            border-radius: 50px; 
            font-weight: bold; 
            font-size: 0.85rem;
            display: inline-block;
        }
        
        .route-name-badge {
            background: #004e92;
            color: white;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            display: inline-block;
            margin-top: 3px;
        }
        
        /* Date input styling */
        input[type="date"] {
            font-family: 'Pyidaungsu', sans-serif;
        }
        
        /* Login မဝင်ရသေးသူများအတွက် alert styling */
        .login-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-left: 5px solid #004e92;
            border-radius: 50px;
            padding: 15px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: none;
        }
        
        .login-alert.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                top: -100px;
                opacity: 0;
            }
            to {
                top: 20px;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <!-- User Login Icon -->
    <div class="user-icon-container">
        <div class="user-icon" onclick="toggleUserMenu()">
            <i class="fas <?php echo isset($_SESSION['customer_id']) ? 'fa-user-circle' : 'fa-sign-in-alt'; ?>"></i>
        </div>
        <div class="user-dropdown" id="userDropdown">
            <?php if(isset($_SESSION['customer_id'])): ?>
                <a href="#" class="user-name">
                    <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'အသုံးပြုသူ'); ?>
                </a>
                <a href="bushistory.php"><i class="fas fa-ticket-alt me-2"></i>ကျွန်ုပ်၏လက်မှတ်များ</a>
                <a href="profile.php"><i class="fas fa-cog me-2"></i>ပရိုဖိုင်ပြင်ရန်</a>
                <a href="buslogout.php"><i class="fas fa-sign-out-alt me-2"></i>ထွက်မည်</a>
            <?php else: ?>
                <a href="buslogin.php<?php echo isset($_SERVER['REQUEST_URI']) ? '?redirect='.urlencode($_SERVER['REQUEST_URI']) : ''; ?>">
                    <i class="fas fa-sign-in-alt me-2"></i>အကောင့်ဝင်ရန်
                </a>
                <a href="busregister.php<?php echo isset($_SERVER['REQUEST_URI']) ? '?redirect='.urlencode($_SERVER['REQUEST_URI']) : ''; ?>">
                    <i class="fas fa-user-plus me-2"></i>အကောင့်အသစ်ဖွင့်ရန်
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Login Alert Message -->
    <div class="login-alert" id="loginAlert">
        <i class="fas fa-info-circle text-primary me-2"></i>
        <span>ဆက်လက်ဆောင်ရွက်ရန် အကောင့်ဝင်ရန် လိုအပ်ပါသည်။</span>
        <button class="btn btn-sm btn-primary ms-3" onclick="window.location.href='buslogin.php<?php echo '?redirect='.urlencode($_SERVER['REQUEST_URI']); ?>'">
            အကောင့်ဝင်ရန်
        </button>
    </div>

    <div class="sticky-top-container shadow-sm">
        <div class="page-header text-center">
            <div class="container">
                <h2 class="fw-bold m-0"><i class="fas fa-bus-alt me-2"></i><?php echo $current_title; ?></h2>
                <p class="opacity-75">စိတ်ချယုံကြည်စွာဖြင့် ခရီးစဉ်များကို ဤနေရာတွင် ရှာဖွေနိုင်ပါသည်</p>
            </div>
        </div>

        <div class="container">
            <div class="unique-search-box mt-3">
                <form action="" method="GET" class="row g-2 align-items-center">
                    <input type="hidden" name="type" value="<?php echo $type_id; ?>">
                    
                    <div class="col-md-3">
                        <div class="input-custom-group">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <input type="text" name="from" placeholder="ဘယ်ကထွက်မှာလဲ (From)" value="<?php echo htmlspecialchars($from); ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-custom-group">
                            <i class="fas fa-location-arrow text-success"></i>
                            <input type="text" name="to" placeholder="ဘယ်ကိုသွားမှာလဲ (To)" value="<?php echo htmlspecialchars($to); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="input-custom-group">
                            <i class="fas fa-calendar-alt text-info"></i>
                            <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" placeholder="ရက်စွဲ">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-custom-group">
                            <i class="fas fa-clock text-primary"></i>
                            <input type="time" name="time" value="<?php echo htmlspecialchars($time); ?>">
                        </div>
                    </div>

                    <div class="col-md-2 text-center">
                        <button class="btn search-btn shadow" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="glass-card shadow-lg">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold m-0"><i class="fas fa-calendar-check me-2 text-primary"></i> ရရှိနိုင်သော ခရီးစဉ်များ</h5>
                <a href="bus1.php" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm border">ပြန်ထွက်ရန်</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light opacity-75">
                        <tr class="small text-uppercase">
                            <th>ကားပုံများ/ကားအမည်</th>
                            <th>လမ်းကြောင်း/အချိန်/ရက်စွဲ</th>
                            <th>ဆက်သွယ်ရန်</th>
                            <th class="text-center">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($result && mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if(!empty($row['image'])): ?>
                                            <img src="Admin/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="bus-img-card" alt="Bus Image">
                                        <?php else: ?>
                                            <div class="bus-img-card bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-bus text-muted fa-2x"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['busline_name']); ?></div>
                                            <?php if(!empty($row['route_name'])): ?>
                                                <span class="route-name-badge">
                                                    <i class="fas fa-route me-1"></i><?php echo htmlspecialchars($row['route_name']); ?>
                                                </span>
                                            <?php endif; ?>
                                            <small class="text-muted d-block"><?php echo htmlspecialchars($row['description'] ?? ''); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-2">
                                        <span class="route-badge">
                                            <?php 
                                            $start = htmlspecialchars($row['start_point'] ?? 'N/A');
                                            $end = htmlspecialchars($row['end_point'] ?? 'N/A');
                                            echo $start . " → " . $end; 
                                            ?>
                                        </span>
                                    </div>
                                    <div class="d-flex gap-3 align-items-center flex-wrap">
                                        <span class="text-primary fw-bold small">
                                            <i class="far fa-clock me-1"></i><?php echo htmlspecialchars($row['time'] ?? 'N/A'); ?>
                                        </span>
                                        <span class="text-success fw-bold">
                                            <?php echo isset($row['price']) ? number_format($row['price']) : '0'; ?> Ks
                                        </span>
                                    </div>
                                    <div class="small text-muted mt-1">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?php 
                                        if(!empty($row['Date'])) {
                                            $timestamp = strtotime($row['Date']);
                                            if($timestamp) {
                                                echo date('d-M-Y', $timestamp);
                                            } else {
                                                echo htmlspecialchars($row['Date']);
                                            }
                                        } else {
                                            echo 'ရက်စွဲမသတ်မှတ်ရ';
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-bold">
                                        <i class="fas fa-phone-alt me-2 text-primary"></i>
                                        <?php echo htmlspecialchars($row['phone'] ?? 'ဖုန်းမရှိ'); ?>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="max-width: 180px;">
                                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                        <?php echo htmlspecialchars($row['address'] ?? 'လိပ်စာမရှိ'); ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <?php if(isset($_SESSION['customer_id'])): ?>
                                        <!-- Login ဝင်ထားရင် တိုက်ရိုက်သွားမယ် - bus_id နဲ့ပြောင်းထား -->
                                        <a href="bus_detail.php?bus_id=<?php echo $row['busline_id']; ?>&route_id=<?php echo $row['route_id']; ?>" 
                                           class="btn btn-primary rounded-pill px-4 shadow-sm btn-sm fw-bold">
                                            <i class="fas fa-ticket-alt me-1"></i>လက်မှတ်ဝယ်ယူရန်
                                        </a>
                                    <?php else: ?>
                                        <!-- Login မဝင်ရသေးရင် login page ကိုသွားပြီး ပြန်လည်ညွှန်းမယ် - bus_id နဲ့ပြောင်းထား -->
                                        <button onclick="redirectToLogin('<?php echo urlencode('bus_detail.php?bus_id='.$row['busline_id'].'&route_id='.$row['route_id']); ?>')" 
                                                class="btn btn-outline-primary rounded-pill px-4 shadow-sm btn-sm fw-bold">
                                            <i class="fas fa-sign-in-alt me-1"></i>ဝယ်ယူရန်/အကောင့်ဝင်ရန်
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                                    <p>ရှာဖွေမှုနှင့် ကိုက်ညီသော လမ်းကြောင်းများ မတွေ့ရှိပါ။</p>
                                    <p class="small">အခြားရက်စွဲ သို့မဟုတ် နေရာများဖြင့် ရှာဖွေကြည့်ပါ။</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    // User dropdown menu toggle
    function toggleUserMenu() {
        document.getElementById('userDropdown').classList.toggle('show');
    }
    
    // Click outside to close dropdown
    window.onclick = function(event) {
        if (!event.target.matches('.user-icon') && !event.target.matches('.user-icon *')) {
            var dropdowns = document.getElementsByClassName("user-dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    
    // Login Alert ပြသပြီး Login Page သို့ ညွှန်းရန် function
    function redirectToLogin(redirectUrl) {
        // Alert ကိုပြသမယ်
        var alert = document.getElementById('loginAlert');
        alert.classList.add('show');
        
        // 1 စက္ကန့်အကြာမှာ Login page ကိုသွားမယ် (alert ကိုမြင်ရအောင်)
        setTimeout(function() {
            window.location.href = 'buslogin.php?redirect=' + redirectUrl;
        }, 1000);
    }
    
    // Form validation for search (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const from = document.querySelector('input[name="from"]').value.trim();
                const to = document.querySelector('input[name="to"]').value.trim();
                
                if (from && to && from.toLowerCase() === to.toLowerCase()) {
                    e.preventDefault();
                    alert('စတင်ရာနေရာနှင့် သွားရောက်ရာနေရာသည် အတူတူမဖြစ်ရပါ။');
                }
            });
        }
    });
    </script>
</body>
</html>