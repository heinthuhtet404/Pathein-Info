<?php
session_start();
include("db.php");

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$result = mysqli_query($db, "SELECT * FROM users WHERE user_id=$user_id");
$user = mysqli_fetch_assoc($result);

// Count Statistics with Error Handling
$total_schools = 0;
$school_query = mysqli_query($db, "SELECT COUNT(*) as total FROM schools");
if ($school_query) {
    $total_schools = mysqli_fetch_assoc($school_query)['total'];
}

$total_users = 0;
$user_query = mysqli_query($db, "SELECT COUNT(*) as total FROM users WHERE role_id = 1");
if ($user_query) {
    $total_users = mysqli_fetch_assoc($user_query)['total'];
}

$pending_users = 0;
$pending_query = mysqli_query($db, "SELECT COUNT(*) as total FROM users WHERE role_id = 1 AND status='Pending'");
if ($pending_query) {
    $pending_users = mysqli_fetch_assoc($pending_query)['total'];
}

// Check if select_curriculum table exists
$total_hotels = 0;
$check_hotel_table = mysqli_query($db, "SHOW TABLES LIKE 'select_curriculum'");
if (mysqli_num_rows($check_hotel_table) > 0) {
    $hotel_query = mysqli_query($db, "SELECT COUNT(*) as total FROM select_curriculum");
    if ($hotel_query) {
        $total_hotels = mysqli_fetch_assoc($hotel_query)['total'];
    }
}

// Check if hospitals table exists (assuming table name)
$total_hospitals = 0;
$check_hospital_table = mysqli_query($db, "SHOW TABLES LIKE 'hospitals'");
if (mysqli_num_rows($check_hospital_table) > 0) {
    $hospital_query = mysqli_query($db, "SELECT COUNT(*) as total FROM hospitals");
    if ($hospital_query) {
        $total_hospitals = mysqli_fetch_assoc($hospital_query)['total'];
    }
}

// Check if transport table exists
$total_transport = 0;
$check_transport_table = mysqli_query($db, "SHOW TABLES LIKE 'edit_school'");
if (mysqli_num_rows($check_transport_table) > 0) {
    $transport_query = mysqli_query($db, "SELECT COUNT(*) as total FROM edit_school");
    if ($transport_query) {
        $total_transport = mysqli_fetch_assoc($transport_query)['total'];
    }
}

// Get recent activities (optional)
$recent_users = [];
$recent_users_query = mysqli_query($db, "SELECT name, created_at FROM users WHERE role_id = 1 ORDER BY user_id DESC LIMIT 3");
if ($recent_users_query) {
    while ($row = mysqli_fetch_assoc($recent_users_query)) {
        $recent_users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Super Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body style="background: #f4f7fb;">

<?php include('SuperAdminSideBar.php'); ?>

<!-- Main Content Wrapper -->
<div class="main-content">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
        <div class="container-fluid p-0">
            <div class="d-flex align-items-center gap-3">
                <!-- Modern Hamburger Toggle Button -->
                <button class="hamburger-btn" onclick="toggleSidebar()" id="toggleBtn">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <!-- Page Title -->
                <span class="page-title d-none d-md-block fw-semibold text-secondary">
                    Dashboard Overview
                </span>
            </div>

            <!-- Right Side Navbar Items -->
            <div class="ms-auto d-flex align-items-center gap-3">
                <!-- Search Bar -->
                <!-- <div class="search-wrapper d-none d-md-block">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fa-solid fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search..." style="width: 200px;">
                    </div>
                </div> -->

                <!-- Notification Icon -->
                <!-- <div class="notification-wrapper position-relative">
                    <i class="fa-solid fa-bell fs-5 text-secondary"></i>
                    <span class="notification-badge"></span>
                </div> -->

                <!-- User Dropdown -->
                <div class="dropdown">
                    <a class="text-dark d-flex align-items-center text-decoration-none dropdown-toggle" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-info text-end me-2 d-none d-md-block">
                            <div class="fw-semibold small"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                            <small class="text-muted">Super Admin</small>
                        </div>
                        <?php if(isset($_SESSION['profile_image']) && $_SESSION['profile_image'] != '') { ?>
                            <img src="<?= $_SESSION['profile_image'] ?>" alt="avatar" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                        <?php } else { ?>
                            <div class="user-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px; font-weight: bold;">
                                <?= strtoupper(substr($_SESSION['email'] ?? 'A', 0, 1)) ?>
                            </div>
                        <?php } ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="profile.php">
                                <i class="fa-solid fa-user me-2 text-primary"></i> Profile
                            </a>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="settings.php">
                                <i class="fa-solid fa-gear me-2 text-secondary"></i> Settings
                            </a>
                        </li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center text-danger" href="login.php">
                                <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container-fluid px-4 py-4">
        <!-- Modern Header with Greeting -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-header p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="fa-solid fa-chart-line fs-1 text-white"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold text-white mb-1">
                                    Welcome back, <?= htmlspecialchars($user['name'] ?? 'Super Admin'); ?>! 👋
                                </h2>
                                <p class="text-white-50 mb-0">Here's what's happening with your platform today.</p>
                            </div>
                        </div>
                        <div class="date-badge bg-white bg-opacity-20 px-4 py-2 rounded-pill">
                            <i class="fa-regular fa-calendar me-2"></i>
                            <?= date('l, F j, Y'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row 1 -->
        <div class="row g-4 mb-4">
            <!-- Total Schools Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Total Schools</span>
                            <h3 class="fw-bold mb-0 mt-2"><?= $total_schools ?></h3>
                            <a href="selectSchool.php" class="text-decoration-none small">
                                View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="stats-icon bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-school fs-2 text-primary"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Total Users</span>
                            <h3 class="fw-bold mb-0 mt-2"><?= $total_users ?></h3>
                            <a href="superAdminUserLists.php" class="text-decoration-none small">
                                View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="stats-icon bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-users fs-2 text-success"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <!-- Pending Users Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Pending Approval</span>
                            <h3 class="fw-bold mb-0 mt-2"><?= $pending_users ?></h3>
                            <a href="superAdminUserLists.php?filter=pending" class="text-decoration-none small">
                                Review Now <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="stats-icon bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-hourglass-half fs-2 text-warning"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 30%"></div>
                    </div>
                </div>
            </div>

            <!-- Total Hotels Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Total Hotels</span>
                            <h3 class="fw-bold mb-0 mt-2"><?= $total_hotels ?></h3>
                            <?php if ($total_hotels > 0): ?>
                                <a href="select_curriculum.php" class="text-decoration-none small">
                                    View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">No data yet</span>
                            <?php endif; ?>
                        </div>
                        <div class="stats-icon bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-hotel fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row 2 -->
        <div class="row g-4 mb-4">
            <!-- Hospitals Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Hospitals</span>
                            <h3 class="fw-bold mb-0 mt-2"><?= $total_hospitals ?></h3>
                            <?php if ($total_hospitals > 0): ?>
                                <a href="hospitals.php" class="text-decoration-none small">
                                    View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">Coming Soon</span>
                            <?php endif; ?>
                        </div>
                        <div class="stats-icon bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-hospital fs-2 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transport Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Transport</span>
                            <h3 class="fw-bold mb-0 mt-2"><?= $total_transport ?></h3>
                            <?php if ($total_transport > 0): ?>
                                <a href="edit_school.php" class="text-decoration-none small">
                                    View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">No data yet</span>
                            <?php endif; ?>
                        </div>
                        <div class="stats-icon bg-secondary bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-truck fs-2 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-xl-6">
                <div class="quick-actions-card bg-white p-4 rounded-4 shadow-sm">
                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="selectSchool.php" class="btn btn-outline-primary rounded-pill">
                            <i class="fa-solid fa-plus me-2"></i>Add School
                        </a>
                        <a href="superAdminUserLists.php" class="btn btn-outline-success rounded-pill">
                            <i class="fa-solid fa-user-plus me-2"></i>Manage Users
                        </a>
                        <?php if ($total_hotels > 0): ?>
                        <a href="select_curriculum.php" class="btn btn-outline-info rounded-pill">
                            <i class="fa-solid fa-hotel me-2"></i>Manage Hotels
                        </a>
                        <?php endif; ?>
                        <a href="profile.php" class="btn btn-outline-secondary rounded-pill">
                            <i class="fa-solid fa-gear me-2"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activity Row -->
        <div class="row g-4">
            <!-- Activity Chart -->
            <div class="col-xl-8">
                <div class="chart-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="fw-bold mb-1">Platform Activity</h6>
                            <small class="text-muted">User registrations and content updates</small>
                        </div>
                        <!-- <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                This Week
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->
                    </div>
                    <canvas id="activityChart" style="width:100%; max-height:300px;"></canvas>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-xl-4">
                <div class="recent-activities-card bg-white p-4 rounded-4 shadow-sm">
                    <h6 class="fw-bold mb-4">Recent User Registrations</h6>
                    
                    <?php if (!empty($recent_users)): ?>
                        <?php foreach ($recent_users as $recent): ?>
                        <div class="activity-item d-flex align-items-start gap-3 mb-3">
                            <div class="activity-icon bg-primary bg-opacity-10 p-2 rounded-3">
                                <i class="fa-solid fa-user-plus text-primary"></i>
                            </div>
                            <div>
                                <p class="mb-1 fw-semibold"><?= htmlspecialchars($recent['name']) ?> registered</p>
                                <!-- <small class="text-muted"><?= time_elapsed_string($recent['created_at']) ?></small> -->
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fa-solid fa-users-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent registrations</p>
                        </div>
                    <?php endif; ?>

                    <a href="superAdminUserLists.php" class="btn btn-light w-100 mt-4 rounded-pill">
                        View All Users <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Content Styles */
.main-content {
    margin-left: 280px;
    min-height: 100vh;
    background: #f4f7fb;
    transition: margin-left 0.3s ease-in-out;
}

.main-content.full {
    margin-left: 0;
}

/* Modern Header Gradient */
.modern-header {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    position: relative;
    overflow: hidden;
}

.modern-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 30s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.date-badge {
    background: rgba(255,255,255,0.2);
    /* color: white; */
    font-size: 0.9rem;
}

/* Stats Cards */
.stats-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.stats-icon {
    transition: all 0.3s;
}

.stats-card:hover .stats-icon {
    transform: scale(1.1);
}

/* Progress Bar */
.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

/* Quick Actions Card */
.quick-actions-card {
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}

.btn-outline-primary {
    border: 1px solid #4158D0;
    color: #4158D0;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-color: transparent;
    color: white;
}

.btn-outline-success {
    border: 1px solid #28a745;
    color: #28a745;
}

.btn-outline-success:hover {
    background: #28a745;
    color: white;
}

.btn-outline-info {
    border: 1px solid #17a2b8;
    color: #17a2b8;
}

.btn-outline-info:hover {
    background: #17a2b8;
    color: white;
}

/* Chart Card */
.chart-card {
    border: 1px solid rgba(0,0,0,0.05);
}

/* Recent Activities */
.recent-activities-card {
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}

.activity-item {
    padding: 10px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: #f8f9fa;
}

.activity-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Notification Badge */
.notification-wrapper {
    cursor: pointer;
    padding: 8px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.notification-wrapper:hover {
    background: #f0f2f5;
}

.notification-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 8px;
    height: 8px;
    background: #dc3545;
    border-radius: 50%;
    border: 2px solid white;
}

/* Search Wrapper */
.search-wrapper .input-group {
    border-radius: 50px;
    overflow: hidden;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
}

.search-wrapper .input-group:focus-within {
    border-color: #C850C0;
    box-shadow: 0 0 0 3px rgba(200, 80, 192, 0.1);
}

.search-wrapper .input-group-text,
.search-wrapper .form-control {
    border: none;
    background: white;
}

.search-wrapper .form-control:focus {
    box-shadow: none;
}

/* User Dropdown */
.dropdown-menu {
    border-radius: 15px;
    min-width: 220px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-item {
    border-radius: 10px;
    margin: 2px 5px;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, rgba(65, 88, 208, 0.05) 0%, rgba(200, 80, 192, 0.05) 100%);
    transform: translateX(5px);
}

/* Page Title */
.page-title {
    font-size: 1rem;
    background: #f0f2f5;
    padding: 6px 15px;
    border-radius: 30px;
}

/* Modern Hamburger Button */
.hamburger-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(65, 88, 208, 0.3);
}

.hamburger-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(65, 88, 208, 0.4);
}

.hamburger-line {
    width: 20px;
    height: 2px;
    background: white;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.hamburger-btn.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.hamburger-btn.active .hamburger-line:nth-child(2) {
    opacity: 0;
}

.hamburger-btn.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

/* User Avatar */
.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
    }
    
    .modern-header {
        text-align: center;
    }
    
    .date-badge {
        margin-top: 10px;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #3a4eb8 0%, #b048a8 100%);
}
</style>

<?php
// Helper function for time elapsed
function time_elapsed_string($datetime, $full = false) {
    if (!$datetime) return 'Unknown';
    
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

<script>
// Toggle sidebar function
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const hamburger = document.getElementById('toggleBtn');

    sidebar.classList.toggle('hide');
    mainContent.classList.toggle('full');
    hamburger.classList.toggle('active');
}

// Activity Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    // Sample data - replace with actual data from your database
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'User Registrations',
                data: [5, 8, 12, 7, 15, 10, 6],
                borderColor: '#4158D0',
                backgroundColor: 'rgba(65, 88, 208, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Content Updates',
                data: [3, 6, 9, 5, 11, 8, 4],
                borderColor: '#C850C0',
                backgroundColor: 'rgba(200, 80, 192, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});

// Auto close sidebar on mobile
function checkScreenSize() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const hamburger = document.getElementById('toggleBtn');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.add('hide');
        mainContent.classList.add('full');
        if(hamburger) hamburger.classList.add('active');
    } else {
        sidebar.classList.remove('hide');
        mainContent.classList.remove('full');
        if(hamburger) hamburger.classList.remove('active');
    }
}

// Check screen size on load and resize
window.addEventListener('load', checkScreenSize);
window.addEventListener('resize', checkScreenSize);

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>