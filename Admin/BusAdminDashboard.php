<?php
session_start();
include("db.php");

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ၂။ Profile Update Logic
if (isset($_POST['update_profile'])) {
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    
    // ပုံအသစ်တင်ခဲ့လျှင်
    if (!empty($_FILES['profile_image']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            // လက်ရှိ user info ဆွဲထုတ်
            $user_info_query = "SELECT image FROM bus_users WHERE user_id = $user_id LIMIT 1";
            $user_info_res = mysqli_query($db, $user_info_query);
            $user_info = mysqli_fetch_assoc($user_info_res);
            
            // ပုံအဟောင်းရှိရင် ဖျက်မည်
            if (!empty($user_info['image']) && file_exists("uploads/" . $user_info['image'])) {
                unlink("uploads/" . $user_info['image']);
            }
            
            $img_name = time() . '_' . uniqid() . '.' . $file_ext;
            $upload_path = "uploads/" . $img_name;
            
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                $update_query = "UPDATE bus_users SET phone='$phone', address='$address', image='$img_name' WHERE user_id=$user_id";
                mysqli_query($db, $update_query);
            }
        }
    } else {
        $update_query = "UPDATE bus_users SET phone='$phone', address='$address' WHERE user_id=$user_id";
        mysqli_query($db, $update_query);
    }
    
    header("Location: BusAdminDashboard.php?success=1");
    exit;
}

// ၃။ လုပ်ဆောင်ချက်များ (Delete, Confirm, Reject Logic)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    $type = $_GET['type'] ?? '';

    if ($action == 'delete') {
        if ($type == 'bus') {
            // Bus Line ကိုဖျက်ရင် ဆက်စပ်ပုံကိုပါ ဖျက်မည်
            $bus_img_query = "SELECT image FROM bus_line WHERE busline_id=$id AND user_id=$user_id";
            $bus_img_res = mysqli_query($db, $bus_img_query);
            if ($bus_img_row = mysqli_fetch_assoc($bus_img_res)) {
                if (!empty($bus_img_row['image']) && file_exists($bus_img_row['image'])) {
                    unlink($bus_img_row['image']);
                }
            }
            
            mysqli_query($db, "DELETE FROM bus_route WHERE busline_id=$id AND user_id=$user_id");
            mysqli_query($db, "DELETE FROM bus_line WHERE busline_id=$id AND user_id=$user_id");
        }
        if ($type == 'route') {
            // Route ဖျက်ရင် ဆက်စပ်ပုံကိုပါ ဖျက်မည်
            $route_img_query = "SELECT image FROM bus_route WHERE id=$id AND user_id=$user_id";
            $route_img_res = mysqli_query($db, $route_img_query);
            if ($route_img_row = mysqli_fetch_assoc($route_img_res)) {
                if (!empty($route_img_row['image']) && file_exists($route_img_row['image'])) {
                    unlink($route_img_row['image']);
                }
            }
            
            mysqli_query($db, "DELETE FROM bus_route WHERE id=$id AND user_id=$user_id");
        }
        if ($type == 'booking') {
            // Booking ဖျက်ရင် payment slip ကိုပါ ဖျက်မည်
            $slip_query = "SELECT bk.payment_slip 
                          FROM bus_booking bk
                          LEFT JOIN bus_line bl ON bk.bus_id = bl.busline_id
                          WHERE bk.booking_id=$id AND bl.user_id=$user_id";
            $slip_res = mysqli_query($db, $slip_query);
            if ($slip_row = mysqli_fetch_assoc($slip_res)) {
                if (!empty($slip_row['payment_slip']) && file_exists($slip_row['payment_slip'])) {
                    unlink($slip_row['payment_slip']);
                }
            }
            
            mysqli_query($db, "DELETE bk FROM bus_booking bk
                              LEFT JOIN bus_line bl ON bk.bus_id = bl.busline_id
                              WHERE bk.booking_id=$id AND bl.user_id=$user_id");
        }
    } 
    elseif ($action == 'confirm_booking') {
        mysqli_query($db, "UPDATE bus_booking bk
                          LEFT JOIN bus_line bl ON bk.bus_id = bl.busline_id
                          SET bk.status='confirmed' 
                          WHERE bk.booking_id=$id AND bl.user_id=$user_id");
    }
    elseif ($action == 'reject_booking') {
        mysqli_query($db, "UPDATE bus_booking bk
                          LEFT JOIN bus_line bl ON bk.bus_id = bl.busline_id
                          SET bk.status='cancelled' 
                          WHERE bk.booking_id=$id AND bl.user_id=$user_id");
    }
    
    header("Location: BusAdminDashboard.php");
    exit;
}

// ၄။ Admin အချက်အလက်များကို ဆွဲထုတ်ခြင်း
$user_info_query = "SELECT u.name as login_name, u.email, bu.cargate_name, bu.owner_name, bu.image as profile_pic, bu.phone, bu.address 
                    FROM users u 
                    LEFT JOIN bus_users bu ON u.user_id = bu.user_id 
                    WHERE u.user_id = $user_id LIMIT 1";
$user_info_res = mysqli_query($db, $user_info_query);
$user_info = mysqli_fetch_assoc($user_info_res);

$display_name = !empty($user_info['owner_name']) ? $user_info['owner_name'] : ($user_info['login_name'] ?? "Admin");
$gate_name = !empty($user_info['cargate_name']) ? $user_info['cargate_name'] : "ဂိတ်အမည်မရှိသေးပါ";
$profile_pic = !empty($user_info['profile_pic']) ? 'uploads/'.$user_info['profile_pic'] : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';

// ၅။ Dashboard Statistics & Data Tables

// Bus Lines
$bus_query = "SELECT busline_id, busline_name, phone, email, address, description, total_seat, Car_color, image, routes, status, created_at 
              FROM bus_line WHERE user_id=$user_id ORDER BY busline_id DESC";
$bus_res = mysqli_query($db, $bus_query);

// Routes
$route_query = "SELECT br.*, bl.busline_name 
                FROM bus_route br
                LEFT JOIN bus_line bl ON br.busline_id = bl.busline_id AND bl.user_id = br.user_id
                WHERE br.user_id = $user_id 
                ORDER BY br.id DESC";
$route_res = mysqli_query($db, $route_query);

// Bookings - FIXED: Get all booking data with correct paths
$booking_query = "SELECT bk.*, 
                         bl.busline_name, bl.image as bus_image,
                         br.start_point, br.end_point, br.route_name
                  FROM bus_booking bk
                  LEFT JOIN bus_line bl ON bk.bus_id = bl.busline_id
                  LEFT JOIN bus_route br ON bk.route_id = br.id
                  WHERE bl.user_id = $user_id OR br.user_id = $user_id
                  ORDER BY bk.booking_id DESC";
$booking_res = mysqli_query($db, $booking_query);

// Bookings Count
$bookings_count_query = "SELECT COUNT(*) as total 
                         FROM bus_booking bk
                         LEFT JOIN bus_line bl ON bk.bus_id = bl.busline_id
                         WHERE bl.user_id = $user_id";
$bookings_count_res = mysqli_query($db, $bookings_count_query);
$bookings_count_row = mysqli_fetch_assoc($bookings_count_res);
$bookings_count = $bookings_count_row['total'];

// Buses Count
$buses_count = mysqli_num_rows($bus_res);

// Routes Count
$routes_count = mysqli_num_rows($route_res);

// Color Helper Function
function formatColor($color) {
    if (empty($color)) return '#6c757d'; // Default gray
    
    // အကယ်၍ color က # နဲ့စပြီးသားဆိုရင် (ဥပမာ - #007bff)
    if (strlen($color) == 7 && $color[0] == '#') {
        return $color;
    }
    
    // အကယ်၍ color က hex ဖြစ်ပေမယ့် # မပါရင် (ဥပမာ - 007bff)
    if (strlen($color) == 6 && ctype_xdigit($color)) {
        return '#' . $color;
    }
    
    // အကယ်၍ color က 3 digit hex ဖြစ်ရင် (ဥပမာ - fff)
    if (strlen($color) == 3 && ctype_xdigit($color)) {
        return '#' . $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
    }
    
    return $color; // မူလအတိုင်းပြန်
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body { 
            font-family: 'Pyidaungsu', sans-serif;
            background: linear-gradient(rgba(0, 15, 30, 0.7), rgba(0, 15, 30, 0.85)), 
                        url('https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            min-height: 100vh;
        }

        .sidebar { 
            width: 280px; 
            height: 100vh; 
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            position: fixed; 
            transition: 0.3s; 
            z-index: 1000;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar.collapsed { margin-left: -280px; }

        .content { 
            margin-left: 280px; 
            padding: 25px; 
            transition: 0.3s; 
            width: calc(100% - 280px); 
        }
        .content.expanded { margin-left: 0; width: 100%; }

        .glass-card {
            background: rgba(255, 255, 255, 0.07) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            color: white;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
        }

        .admin-profile-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #00d2ff;
            margin-bottom: 10px;
        }

        .table { --bs-table-bg: transparent !important; color: white !important; }
        .table thead th { background: rgba(0, 0, 0, 0.2) !important; color: white !important; border-bottom: 2px solid rgba(255,255,255,0.1); }
        .table tbody tr td { color: white !important; border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }

        .nav-link { 
            color: rgba(255,255,255,0.8);
            margin: 5px 20px; 
            padding: 12px 20px;
            border-radius: 12px; 
            transition: 0.3s;
            cursor: pointer;
        }
        .nav-link:hover, .nav-link.active { background: rgba(0, 210, 255, 0.2); color: white; }
        .nav-link.active { background: #00d2ff !important; box-shadow: 0 4px 15px rgba(0, 210, 255, 0.4); }

        .bus-thumb { 
            width: 75px; 
            height: 48px; 
            object-fit: cover; 
            border-radius: 8px; 
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(0,0,0,0.2);
        }
        
        .badge-pending { background: #f39c12; }
        .badge-confirmed { background: #2ecc71; }
        .badge-cancelled { background: #e74c3c; }

        .btn-action { border-radius: 8px; width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; }
        
        .modal-content.glass-card { background: rgba(30, 30, 40, 0.95) !important; }
        .form-control, .form-control-plaintext { 
            background: rgba(255,255,255,0.1); 
            border: 1px solid rgba(255,255,255,0.2); 
            color: white; 
        }
        .form-control:focus { 
            background: rgba(255,255,255,0.15); 
            color: white; 
            border-color: #00d2ff; 
            box-shadow: none; 
        }
        .form-control[readonly] {
            background: rgba(255,255,255,0.05);
            color: #aaa;
            cursor: not-allowed;
        }
        
        /* Color preview styling */
        .color-preview {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid white;
            vertical-align: middle;
            margin-right: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        
        .color-value {
            background: rgba(0,0,0,0.3);
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-family: monospace;
            display: inline-block;
        }
        
        .status-badge { font-size: 0.75rem; padding: 4px 10px; }
        .empty-state { text-align: center; padding: 40px 20px; opacity: 0.7; }
        
        .route-badge {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
            background: rgba(0, 210, 255, 0.15);
            border: 1px solid rgba(0, 210, 255, 0.4);
            color: #00d2ff;
        }
        
        .no-route-badge {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
            background: rgba(108, 117, 125, 0.2);
            border: 1px solid rgba(108, 117, 125, 0.4);
            color: #adb5bd;
        }
        
        .add-route-btn {
            font-size: 0.7rem;
            padding: 3px 10px;
            margin-top: 5px;
        }
        
        .one-bus-notice {
            background: rgba(0, 210, 255, 0.1);
            border-left: 4px solid #00d2ff;
            padding: 10px 15px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }
        
        .profile-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #00d2ff;
        }
        
        /* Payment slip thumbnail */
        .slip-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.3);
            cursor: pointer;
            transition: 0.3s;
        }
        .slip-thumb:hover {
            transform: scale(1.1);
            border-color: #00d2ff;
        }
        
        .btn-view-slip {
            background: rgba(0, 210, 255, 0.2);
            border: 1px solid #00d2ff;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-view-slip:hover {
            background: #00d2ff;
            color: white;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-4 text-center border-bottom border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
            <img src="<?= htmlspecialchars($profile_pic) ?>" class="admin-profile-img shadow" alt="Admin">
            <h6 class="fw-bold mb-0 text-white"><?= htmlspecialchars($display_name) ?></h6>
            <small class="text-info"><?= htmlspecialchars($gate_name) ?></small>
            <div class="mt-3">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fa fa-edit me-1"></i> edit profile
                </button>
            </div>
        </div>
        
        <div class="nav flex-column mt-4">
            <button class="nav-link active border-0 text-start" data-bs-toggle="pill" data-bs-target="#tab-dash">
                <i class="fa-solid fa-gauge me-3"></i> Dashboard
            </button>
            <button class="nav-link border-0 text-start" data-bs-toggle="pill" data-bs-target="#tab-bus">
                <i class="fa-solid fa-bus-simple me-3"></i> Bus Lines
            </button>
            <button class="nav-link border-0 text-start" data-bs-toggle="pill" data-bs-target="#tab-route">
                <i class="fa-solid fa-route me-3"></i> Routes
            </button>
            <button class="nav-link border-0 text-start" data-bs-toggle="pill" data-bs-target="#tab-book">
                <i class="fa-solid fa-ticket me-3"></i> Bookings
            </button>
            <a href="business_man_login.php" class="nav-link text-danger mt-5">
                <i class="fa-solid fa-right-from-bracket me-3"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <nav class="d-flex justify-content-between align-items-center mb-4 glass-card p-3 px-4">
            <button class="btn btn-outline-light border-0" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h5 class="fw-bold mb-0">Admin Panel</h5>
            <div class="small fw-bold">
                <i class="far fa-calendar-alt me-1"></i> <?= date('D, d M Y') ?>
            </div>
        </nav>

        <div class="tab-content">
            <!-- Dashboard Tab -->
            <div class="tab-pane fade show active" id="tab-dash">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="glass-card p-4 text-center border-bottom border-primary border-4">
                            <i class="fa fa-bus-alt fa-2x mb-2 text-primary"></i>
                            <div class="small">ကားလိုင်းများ</div>
                            <h2 class="fw-bold mt-1"><?= $buses_count ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card p-4 text-center border-bottom border-info border-4">
                            <i class="fa fa-map-marked-alt fa-2x mb-2 text-info"></i>
                            <div class="small">လမ်းကြောင်းများ</div>
                            <h2 class="fw-bold mt-1"><?= $routes_count ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card p-4 text-center border-bottom border-warning border-4">
                            <i class="fa fa-ticket-alt fa-2x mb-2 text-warning"></i>
                            <div class="small">ဘိုကင်များ</div>
                            <h2 class="fw-bold mt-1"><?= $bookings_count ?></h2>
                        </div>
                    </div>
                </div>
                <div class="glass-card p-4">
                    <h5 class="fw-bold"><i class="fa fa-bullhorn me-2"></i> မင်္ဂလာပါ, <?= htmlspecialchars($display_name) ?>! 👋</h5>
                    <p class="mb-0 opacity-75">
                        လုပ်ငန်းဆောင်တာများကို ဘယ်ဘက် Menu များတွင် စီမံခန့်ခွဲနိုင်ပါသည်။<br>
                        <small class="text-info">💡 တစ်ကားလိုင်းလျှင် တစ်လမ်းကြောင်းသာ သတ်မှတ်နိုင်ပါသည် (One Bus One Route)</small>
                    </p>
                </div>
            </div>

            <!-- Bus Lines Tab -->
            <div class="tab-pane fade" id="tab-bus">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">My Bus Lines</h5>
                        <a href="insert_bus.php" class="btn btn-primary btn-sm rounded-pill px-4">
                            <i class="fas fa-plus me-1"></i> Add New
                        </a>
                    </div>
                    
                    <?php if ($buses_count > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ကားနံပါတ်/ဂိတ်</th>
                                    <th>ခုံအရေအတွက်</th>
                                    <th>အရောင်</th>
                                    <th>ဖုန်း</th>
                                    <th>ဆက်စပ်လမ်းကြောင်း</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                mysqli_data_seek($bus_res, 0); 
                                while($b = mysqli_fetch_assoc($bus_res)): 
                                    $colorHex = formatColor($b['Car_color']);
                                    
                                    // Check for linked route
                                    $route_check = mysqli_query($db, "SELECT id, route_name, start_point, end_point, price 
                                                                      FROM bus_route 
                                                                      WHERE busline_id = {$b['busline_id']} AND user_id = $user_id 
                                                                      LIMIT 1");
                                    $linked_route = mysqli_fetch_assoc($route_check);
                                ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($b['busline_name']) ?></td>
                                    <td><span class="badge bg-dark border border-secondary"><?= htmlspecialchars($b['total_seat']) ?></span></td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="color-preview" style="background: <?= $colorHex ?>;"></span>
                                            <span class="color-value"><?= $colorHex ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="small"><?= htmlspecialchars($b['phone'] ?? '-') ?></td>
                                    
                                    <td>
                                        <?php if($linked_route): ?>
                                            <div class="route-badge">
                                                <i class="fas fa-route me-1"></i>
                                                <?= htmlspecialchars($linked_route['route_name']) ?>
                                            </div>
                                            <div class="small opacity-75 mt-1">
                                                <?= htmlspecialchars($linked_route['start_point']) ?> 
                                                <i class="fa fa-arrow-right mx-1"></i> 
                                                <?= htmlspecialchars($linked_route['end_point']) ?>
                                            </div>
                                            <div class="small mt-1">
                                                <span class="badge bg-success"><?= number_format($linked_route['price']) ?> Ks</span>
                                            </div>
                                        <?php else: ?>
                                            <span class="no-route-badge">
                                                <i class="fas fa-minus me-1"></i> မရှိသေးပါ
                                            </span>
                                            <br>
                                            <a href="insert_route.php?bus_id=<?= $b['busline_id'] ?>" class="btn btn-sm btn-outline-info add-route-btn">
                                                + Route ထည့်မည်
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="edit_bus.php?id=<?= $b['busline_id'] ?>" class="btn btn-info btn-action text-white" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button onclick="confirmAction('delete', 'bus', <?= $b['busline_id'] ?>)" class="btn btn-danger btn-action" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-bus fa-3x mb-3 opacity-50"></i>
                            <p class="mb-3">ကားလိုင်းမရှိသေးပါ</p>
                            <a href="insert_bus.php" class="btn btn-primary btn-sm">+ ကားလိုင်းအသစ်ထည့်မည်</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Routes Tab -->
            <div class="tab-pane fade" id="tab-route">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">My Routes</h5>
                        <a href="insert_route.php" class="btn btn-info btn-sm rounded-pill px-4 text-white">
                            <i class="fas fa-plus me-1"></i> Add New
                        </a>
                    </div>
                    
                    <?php if ($routes_count > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ပုံ</th>
                                    <th>ဆက်စပ်ကားလိုင်း</th>
                                    <th>ခရီးစဉ်အမည်</th>
                                    <th>လမ်းကြောင်း</th>
                                    <th>အချိန်/ရက်</th>
                                    <th>ဈေးနှုန်း</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                mysqli_data_seek($route_res, 0); 
                                while($r = mysqli_fetch_assoc($route_res)): 
                                ?>
                                <tr>
                                    <td>
                                        <?php 
                                        // Check if image exists and display correctly
                                        if(!empty($r['image'])): 
                                            if(file_exists($r['image'])): ?>
                                                <img src="<?= htmlspecialchars($r['image']) ?>" class="bus-thumb" alt="Route Image">
                                            <?php elseif(file_exists("uploads/" . $r['image'])): ?>
                                                <img src="uploads/<?= htmlspecialchars($r['image']) ?>" class="bus-thumb" alt="Route Image">
                                            <?php else: ?>
                                                <img src="https://placehold.co/80x50/2c3e50/ffffff?text=Route" class="bus-thumb" alt="No Image">
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <img src="https://placehold.co/80x50/2c3e50/ffffff?text=Route" class="bus-thumb" alt="No Image">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?= htmlspecialchars($r['busline_name'] ?? 'N/A') ?></span>
                                    </td>
                                    <td>
                                        <div class="fw-bold small"><?= htmlspecialchars($r['route_name'] ?? 'N/A') ?></div>
                                        <small class="opacity-75"><i class="far fa-clock me-1"></i><?= htmlspecialchars($r['time']) ?></small>
                                    </td>
                                    <td class="small">
                                        <?= htmlspecialchars($r['start_point']) ?> 
                                        <i class="fa fa-long-arrow-right mx-1 opacity-50"></i> 
                                        <?= htmlspecialchars($r['end_point']) ?>
                                    </td>
                                    <td>
                                        <?php if($r['Date'] && $r['Date'] != '0000-00-00'): ?>
                                            <span class="badge bg-light text-dark"><?= date('d M Y', strtotime($r['Date'])) ?></span>
                                        <?php else: ?>
                                            <small class="opacity-50">-</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold"><?= number_format((int)$r['price']) ?> Ks</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="edit_route.php?id=<?= $r['id'] ?>" class="btn btn-info btn-action text-white" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button onclick="confirmAction('delete', 'route', <?= $r['id'] ?>)" class="btn btn-danger btn-action" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-route fa-3x mb-3 opacity-50"></i>
                            <p class="mb-3">လမ်းကြောင်းမရှိသေးပါ</p>
                            <a href="insert_route.php" class="btn btn-info btn-sm text-white">+ လမ်းကြောင်းအသစ်ထည့်မည်</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bookings Tab - FIXED: Payment slip display -->
            <div class="tab-pane fade" id="tab-book">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">Customer Bookings</h5>
                        <span class="badge bg-warning text-dark"><?= $bookings_count ?> Total</span>
                    </div>
                    
                    <?php if ($bookings_count > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>NRC</th>
                                    <th>Booking Details</th>
                                    <th>Payment Slip</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                mysqli_data_seek($booking_res, 0); 
                                while($row = mysqli_fetch_assoc($booking_res)): 
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold small"><?= htmlspecialchars($row['customer_name']) ?></div>
                                        <small class="text-info d-block"><?= htmlspecialchars($row['phone']) ?></small>
                                        <small class="opacity-75"><?= htmlspecialchars($row['email'] ?? 'No Email') ?></small>
                                    </td>
                                    <td>
                                        <span class="small fw-bold text-light"><?= htmlspecialchars($row['NRC'] ?? 'N/A') ?></span>
                                    </td>
                                    <td>
                                        <div class="small fw-bold">
                                            <?= htmlspecialchars($row['busline_name'] ?? 'N/A') ?>
                                        </div>
                                        <div class="small opacity-75">
                                            <?= htmlspecialchars($row['start_point'] ?? '') ?> → <?= htmlspecialchars($row['end_point'] ?? '') ?>
                                        </div>
                                        <div class="mt-1">
                                            <span class="badge bg-dark border border-secondary">Seat: <?= htmlspecialchars($row['seat_number']) ?></span>
                                            <span class="small ms-2"><?= number_format($row['price']) ?> Ks</span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        // FIXED: Check payment slip in multiple possible locations
                                        $slip_displayed = false;
                                        
                                        if(!empty($row['payment_slip'])) {
                                            // Check if it's a full path
                                            if(file_exists($row['payment_slip'])) {
                                                echo '<img src="'.htmlspecialchars($row['payment_slip']).'" class="slip-thumb" onclick="viewSlip(\''.htmlspecialchars($row['payment_slip']).'\')" title="Click to view full image">';
                                                $slip_displayed = true;
                                            }
                                            // Check in uploads folder
                                            elseif(file_exists("uploads/" . $row['payment_slip'])) {
                                                echo '<img src="uploads/'.htmlspecialchars($row['payment_slip']).'" class="slip-thumb" onclick="viewSlip(\'uploads/'.htmlspecialchars($row['payment_slip']).'\')" title="Click to view full image">';
                                                $slip_displayed = true;
                                            }
                                            // Check in uploads/bus_images folder
                                            elseif(file_exists("uploads/bus_images/" . $row['payment_slip'])) {
                                                echo '<img src="uploads/bus_images/'.htmlspecialchars($row['payment_slip']).'" class="slip-thumb" onclick="viewSlip(\'uploads/bus_images/'.htmlspecialchars($row['payment_slip']).'\')" title="Click to view full image">';
                                                $slip_displayed = true;
                                            }
                                            // Check in uploads/payments folder (create this folder if needed)
                                            elseif(file_exists("uploads/payments/" . $row['payment_slip'])) {
                                                echo '<img src="uploads/payments/'.htmlspecialchars($row['payment_slip']).'" class="slip-thumb" onclick="viewSlip(\'uploads/payments/'.htmlspecialchars($row['payment_slip']).'\')" title="Click to view full image">';
                                                $slip_displayed = true;
                                            }
                                        }
                                        
                                        if(!$slip_displayed) {
                                            if(!empty($row['payment_slip'])) {
                                                // Show filename but no image
                                                echo '<div>';
                                                echo '<span class="small text-warning">📄 '.htmlspecialchars(basename($row['payment_slip'])).'</span><br>';
                                                echo '<button class="btn-view-slip mt-1" onclick="alert(\'ပုံဖိုင် မတွေ့ပါ: '.htmlspecialchars($row['payment_slip']).'\')">File not found</button>';
                                                echo '</div>';
                                            } else {
                                                echo '<small class="opacity-50">No Slip</small>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge status-badge <?= $row['status'] == 'pending' ? 'badge-pending' : ($row['status'] == 'confirmed' ? 'badge-confirmed' : 'badge-cancelled') ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <?php if($row['status'] == 'pending'): ?>
                                                <button onclick="confirmAction('confirm_booking', 'booking', <?= $row['booking_id'] ?>)" class="btn btn-success btn-action text-white" title="Confirm">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button onclick="confirmAction('reject_booking', 'booking', <?= $row['booking_id'] ?>)" class="btn btn-warning btn-action text-white" title="Cancel">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="confirmAction('delete', 'booking', <?= $row['booking_id'] ?>)" class="btn btn-outline-danger btn-action" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-ticket-alt fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">ဘိုကင်မရှိသေးပါ</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-bottom border-secondary">
                    <h6 class="modal-title fw-bold">Edit Admin Profile</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="<?= htmlspecialchars($profile_pic) ?>" id="previewImg" class="profile-preview" alt="Preview">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Profile Photo</label>
                        <input type="file" name="profile_image" class="form-control" onchange="previewFile(this)">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Car Gate Name</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($gate_name) ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Owner Name</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($display_name) ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user_info['email'] ?? '') ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user_info['phone'] ?? '') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user_info['address'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_profile" class="btn btn-sm btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Slip View Modal - FIXED: Better image display -->
<div class="modal fade" id="slipModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card p-3">
            <div class="text-center">
                <img src="" id="slipImage" class="img-fluid rounded" style="max-height: 70vh; max-width: 100%;" alt="Payment Slip">
                <div class="mt-3">
                    <button class="btn btn-sm btn-primary" onclick="downloadSlip()">
                        <i class="fas fa-download me-1"></i> Download
                    </button>
                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert -->
<?php if(isset($_GET['success'])): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div class="toast show bg-success text-white" role="alert">
        <div class="toast-body">
            <i class="fa fa-check me-2"></i> ပြောင်းလဲမှုများ သိမ်းဆည်းပြီးပါပြီ
        </div>
    </div>
</div>
<script>
    setTimeout(() => {
        document.querySelector('.toast')?.remove();
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }, 3000);
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle Sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('expanded');
    }
    
    // Confirm Action
    function confirmAction(action, type, id) {
        const messages = {
            'delete': 'ဤဒေတာကို ဖျက်မည်။ ဖျက်ပြီးပါက ပြန်မရနိုင်ပါ။',
            'confirm_booking': 'ဤဘိုကင်ကို အတည်ပြုမည်။',
            'reject_booking': 'ဤဘိုကင်ကို ပယ်ဖျက်မည်။'
        };
        
        if(confirm('⚠️ ' + (messages[action] || 'ဤလုပ်ဆောင်ချက်ကို လုပ်ဆောင်ရန် သေချာပါသလား?'))) {
            window.location.href = `BusAdminDashboard.php?action=${action}&type=${type}&id=${id}`;
        }
    }
    
    // View Payment Slip - FIXED
    function viewSlip(imgUrl) {
        const slipImage = document.getElementById('slipImage');
        slipImage.src = imgUrl;
        
        // Add error handling
        slipImage.onerror = function() {
            alert('ပုံဖိုင်ကိုဖွင့်မရပါ။ ဖိုင်ပျက်နေနိုင်သည် သို့မဟုတ် ဖျက်လိုက်မိနိုင်ပါသည်။');
            slipImage.src = 'https://placehold.co/600x400/2c3e50/ffffff?text=Image+Not+Found';
        };
        
        new bootstrap.Modal(document.getElementById('slipModal')).show();
    }
    
    // Download slip function
    function downloadSlip() {
        const imgUrl = document.getElementById('slipImage').src;
        if(imgUrl && imgUrl !== 'https://placehold.co/600x400/2c3e50/ffffff?text=Image+Not+Found') {
            const link = document.createElement('a');
            link.href = imgUrl;
            link.download = 'payment_slip_' + Date.now() + '.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else {
            alert('ဒေါင်းလုတ်လုပ်ရန် ပုံမရှိပါ။');
        }
    }
    
    // Preview Profile Image
    function previewFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Auto-hide alert
    document.addEventListener('DOMContentLoaded', function() {
        const toastEl = document.querySelector('.toast');
        if(toastEl) {
            setTimeout(() => {
                toastEl.style.display = 'none';
            }, 3000);
        }
    });
</script>
</body>
</html>