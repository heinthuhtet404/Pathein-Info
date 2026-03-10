<?php
session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM users WHERE role_id = 1 LIMIT $start, $limit";
$result = $db->query($sql);

$total_result = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 1");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Super Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
                    User Management
                </span>
            </div>

            <!-- Right Side Navbar Items -->
            <div class="ms-auto d-flex align-items-center gap-3">
                <!-- Notification Icon -->
                <!-- <div class="notification-wrapper position-relative">
                    <i class="fa-solid fa-bell fs-5 text-secondary" onclick="showNotifications()"></i>
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
                            <a class="dropdown-item py-2 d-flex align-items-center" href="profile.php">
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
        <!-- Modern Header with Gradient -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-header p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="bi bi-people-fill fs-1 text-white"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold text-white mb-1">User Management</h2>
                                <p class="text-white-50 mb-0">Manage and monitor all registered users</p>
                            </div>
                        </div>
                        <a href="SuperAdminDashboard.php" class="btn btn-light px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-person-check fs-3 text-primary"></i>
                        </div>
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Total Users</span>
                            <h3 class="fw-bold mb-0"><?= $total_row['total'] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                        </div>
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Pending</span>
                            <h3 class="fw-bold mb-0">
                                <?php 
                                $pending = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 1 AND status='Pending'");
                                echo $pending->fetch_assoc()['total'];
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-person-check-fill fs-3 text-success"></i>
                        </div>
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Active</span>
                            <h3 class="fw-bold mb-0">
                                <?php 
                                $active = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 1 AND status='Accept'");
                                echo $active->fetch_assoc()['total'];
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="row">
            <div class="col-12">
                <div class="main-card bg-white rounded-4 shadow-lg overflow-hidden">
                    <!-- Card Header with Search and Filter -->
                    <div class="card-header bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="filter-tabs">
                                    <span class="filter-badge active px-4 py-2 rounded-pill">All Users</span>
                                    <!-- <span class="filter-badge px-4 py-2 rounded-pill" >Pending</span>
                                    <span class="filter-badge px-4 py-2 rounded-pill" >Active</span>
                                    <span class="filter-badge px-4 py-2 rounded-pill" >Rejected</span> -->
                                </div>
                            </div>
                            <!-- <div class="search-wrapper">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Search users..." style="width: 250px;">
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table custom-table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="py-3">User Info</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = $start + 1;
                                if(mysqli_num_rows($result) > 0){
                                    while($row = $result->fetch_assoc()){ 
                                ?>
                                <tr class="align-middle">
                                    <td class="px-4 fw-semibold text-muted">#<?= str_pad($no++, 3, '0', STR_PAD_LEFT); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar">
                                                <div class="avatar-circle">
                                                    <span class="avatar-text"><?= strtoupper(substr($row['name'], 0, 1)); ?></span>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-1"><?= htmlspecialchars($row['name']); ?></h6>
                                                <small class="text-muted">Registered User</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-envelope text-muted small"></i>
                                            <span><?= htmlspecialchars($row['email']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        if($row['status'] == 'Pending'){ ?>
                                            <span class="status-badge pending">
                                                <i class="bi bi-hourglass me-1"></i>Pending
                                            </span>
                                        <?php } elseif($row['status'] == 'Accept'){ ?>
                                            <span class="status-badge active">
                                                <i class="bi bi-check-circle me-1"></i>Active
                                            </span>
                                        <?php } elseif($row['status'] == 'Reject'){ ?>
                                            <span class="status-badge rejected">
                                                <i class="bi bi-x-circle me-1"></i>Rejected
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <?php if($row['status'] == 'Pending'){ ?>
                                        <div class="action-buttons">
                                            <a href="approve.php?id=<?= $row['user_id']; ?>" 
                                               class="action-btn approve"
                                               onclick="return confirm('Accept this user? A random password will be sent to their email.')"
                                               data-bs-toggle="tooltip" title="Approve User">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                            <a href="SuperAdminReject_User.php?id=<?= $row['user_id']; ?>" 
                                               class="action-btn reject"
                                               onclick="return confirm('Reject this user?')"
                                               data-bs-toggle="tooltip" title="Reject User">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                            <button class="action-btn view" data-bs-toggle="tooltip" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <?php } else { ?>
                                            <span class="completed-badge">
                                                <i class="bi bi-check-circle-fill me-1 text-success"></i>
                                                Completed
                                            </span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                } else { 
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="bi bi-people display-1 text-muted opacity-50"></i>
                                            <h5 class="mt-3 text-muted">No users found</h5>
                                            <p class="text-muted small">There are no registered users to display</p>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer with Pagination -->
                    <div class="card-footer bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="text-muted small">
                                Showing <?= $start + 1 ?> to <?= min($start + $limit, $total_row['total']) ?> of <?= $total_row['total'] ?> entries
                            </div>
                            <nav>
                                <ul class="pagination modern-pagination mb-0">
                                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $page-1; ?>" aria-label="Previous">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                    <?php for($i=1; $i <= $total_pages; $i++){ ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $page+1; ?>" aria-label="Next">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
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

/* Stats Cards */
.stats-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid rgba(0,0,0,0.05);
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

/* Main Card */
.main-card {
    border: 1px solid rgba(0,0,0,0.05);
}

/* Filter Tabs */
.filter-tabs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-badge {
    background: #f8f9fa;
    color: #6c757d;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s;
    border: 1px solid transparent;
}

.filter-badge:hover {
    background: #e9ecef;
    color: #495057;
}

.filter-badge.active {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(65, 88, 208, 0.3);
}

/* Search Input */
.search-wrapper .input-group {
    border-radius: 50px;
    overflow: hidden;
    border: 1px solid #dee2e6;
}

.search-wrapper .input-group:focus-within {
    border-color: #C850C0;
    box-shadow: 0 0 0 3px rgba(200, 80, 192, 0.1);
}

.search-wrapper .input-group-text {
    border: none;
    background: white;
}

.search-wrapper .form-control {
    border: none;
    box-shadow: none;
}

/* Custom Table */
.custom-table {
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table thead th {
    background: #f8fafd;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-bottom: 2px solid #e9ecef;
}

.custom-table tbody tr {
    transition: all 0.3s;
    border-bottom: 1px solid #f1f4f8;
}

.custom-table tbody tr:hover {
    background: #f8fafd;
}

/* User Avatar */
.avatar-circle {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(65, 88, 208, 0.2);
}

.avatar-text {
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
    text-transform: uppercase;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-badge.pending {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-badge.rejected {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Action Buttons */
.action-buttons {
    display: inline-flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    cursor: pointer;
    text-decoration: none;
}

.action-btn.approve {
    background: #e8f5e9;
    color: #2e7d32;
}

.action-btn.approve:hover {
    background: #2e7d32;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3);
}

.action-btn.reject {
    background: #ffebee;
    color: #c62828;
}

.action-btn.reject:hover {
    background: #c62828;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(198, 40, 40, 0.3);
}

.action-btn.view {
    background: #e3f2fd;
    color: #1565c0;
}

.action-btn.view:hover {
    background: #1565c0;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(21, 101, 192, 0.3);
}

.completed-badge {
    font-size: 0.9rem;
    color: #6c757d;
    background: #f8f9fa;
    padding: 6px 12px;
    border-radius: 50px;
}

/* Modern Pagination */
.modern-pagination {
    gap: 5px;
}

.modern-pagination .page-item .page-link {
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 10px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s;
    background: white;
    border: 1px solid #dee2e6;
}

.modern-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 15px rgba(65, 88, 208, 0.3);
}

.modern-pagination .page-item .page-link:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-2px);
}

.modern-pagination .page-item.active .page-link:hover {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px;
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
    
    .filter-tabs {
        flex-wrap: wrap;
    }
    
    .modern-pagination .page-item .page-link {
        width: 35px;
        height: 35px;
    }
}

/* Tooltip */
[data-bs-toggle="tooltip"] {
    position: relative;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Filter badges click handler
    document.querySelectorAll('.filter-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            document.querySelectorAll('.filter-badge').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Search functionality (placeholder)
    const searchInput = document.querySelector('.search-wrapper input');
    if(searchInput) {
        searchInput.addEventListener('input', function(e) {
            console.log('Searching for:', e.target.value);
        });
    }
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
</script>

</body>
</html>