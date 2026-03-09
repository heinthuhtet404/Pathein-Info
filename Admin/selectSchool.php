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

// Delete School
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = mysqli_prepare($db, "DELETE FROM schools WHERE school_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: selectSchool.php?msg=deleted");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Delete Failed: " . mysqli_error($db) . "</div>";
        }
    }
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_result = mysqli_query($db, "SELECT COUNT(*) AS total FROM schools");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

$data = mysqli_query($db, "SELECT * FROM schools ORDER BY school_id ASC LIMIT $offset,$limit");

// Get statistics
$total_schools = $total_row['total'];
$active_schools = mysqli_num_rows(mysqli_query($db, "SELECT * FROM schools WHERE status='active'"));
$inactive_schools = $total_schools - $active_schools;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School List | Super Admin</title>
    
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
                    School Management
                </span>
            </div>

            <!-- Right Side Navbar Items -->
            <div class="ms-auto d-flex align-items-center gap-3">
                <!-- Search Bar -->
                <div class="search-wrapper d-none d-md-block">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fa-solid fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search schools..." style="width: 200px;" id="searchInput">
                    </div>
                </div>

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
        <!-- Modern Header with Gradient -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-header p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="fa-solid fa-school fs-1 text-white"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold text-white mb-1">School Management</h2>
                                <p class="text-white-50 mb-0">Manage and monitor all registered schools</p>
                            </div>
                        </div>
                        <a href="superAdminDashboard.php" class="btn btn-light px-4 py-2 rounded-pill shadow-sm">
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
                            <i class="fa-solid fa-school fs-3 text-primary"></i>
                        </div>
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Total Schools</span>
                            <h3 class="fw-bold mb-0"><?= $total_schools ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-check-circle fs-3 text-success"></i>
                        </div>
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Active Schools</span>
                            <h3 class="fw-bold mb-0"><?= $active_schools ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card bg-white p-4 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-clock fs-3 text-warning"></i>
                        </div>
                        <div>
                            <span class="text-secondary text-uppercase small fw-semibold">Inactive Schools</span>
                            <h3 class="fw-bold mb-0"><?= $inactive_schools ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i>School has been deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Main Table Card -->
        <div class="row">
            <div class="col-12">
                <div class="main-card bg-white rounded-4 shadow-lg overflow-hidden">
                    <!-- Card Header with Actions -->
                    <div class="card-header bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <h5 class="fw-bold mb-0">
                                    <i class="fa-solid fa-list me-2 text-primary"></i>
                                    Schools List
                                </h5>
                                <span class="badge bg-primary rounded-pill"><?= $total_schools ?> entries</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary rounded-pill" onclick="exportTable()">
                                    <i class="fa-solid fa-download me-2"></i>Export
                                </button>
                                <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                                    <i class="fa-solid fa-plus me-2"></i>Add School
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table custom-table mb-0" id="schoolTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="py-3">Logo</th>
                                    <th class="py-3">School Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Ownership</th>
                                    <th class="py-3">Type</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($data) > 0) {
                                    $i = $offset + 1;
                                    while ($row = mysqli_fetch_assoc($data)) { ?>
                                        <tr class="align-middle">
                                            <td class="px-4 fw-semibold text-muted">#<?= str_pad($i++, 3, '0', STR_PAD_LEFT); ?></td>
                                            <td>
                                                <?php if (!empty($row['logo'])) { ?>
                                                    <div class="school-logo-wrapper">
                                                        <img src="uploads/<?= htmlspecialchars($row['logo']) ?>" 
                                                             class="school-logo" 
                                                             alt="School Logo">
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="school-logo-placeholder">
                                                        <i class="fa-solid fa-school"></i>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="fw-semibold mb-1"><?= htmlspecialchars($row['name']) ?></h6>
                                                        <small class="text-muted">ID: SCH-<?= str_pad($row['school_id'], 4, '0', STR_PAD_LEFT) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-envelope text-muted small"></i>
                                                    <span><?= htmlspecialchars($row['email']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="ownership-badge <?= strtolower($row['ownership']) ?>">
                                                    <?php 
                                                    $ownership = $row['ownership'] ?? 'private';
                                                    if ($ownership == 'public') echo '🏛️ Public';
                                                    elseif ($ownership == 'private') echo '🏫 Private';
                                                    else echo '📚 ' . ucfirst($ownership);
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="type-badge <?= strtolower($row['type']) ?>">
                                                    <?php 
                                                    $type = $row['type'] ?? 'school';
                                                    if ($type == 'school') echo '📚 School';
                                                    elseif ($type == 'college') echo '🎓 College';
                                                    elseif ($type == 'university') echo '🏛️ University';
                                                    else echo '📖 ' . ucfirst($type);
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-phone text-muted small"></i>
                                                    <span><?= htmlspecialchars($row['phone']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] == 'active'): ?>
                                                    <span class="status-badge active">
                                                        <i class="fa-solid fa-circle me-1" style="font-size: 0.5rem;"></i>
                                                        Active
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge inactive">
                                                        <i class="fa-solid fa-circle me-1" style="font-size: 0.5rem;"></i>
                                                        Inactive
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="action-buttons">
                                                    <button class="action-btn view" onclick="viewSchool(<?= $row['school_id'] ?>)" 
                                                            data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                    <button class="action-btn edit" onclick="editSchool(<?= $row['school_id'] ?>)" 
                                                            data-bs-toggle="tooltip" title="Edit School">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <a href="?delete=<?= $row['school_id'] ?>" 
                                                       class="action-btn delete" 
                                                       onclick="return confirm('Are you sure you want to delete this school? This action cannot be undone.')"
                                                       data-bs-toggle="tooltip" title="Delete School">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fa-solid fa-school-circle-exclamation fa-4x text-muted opacity-50 mb-3"></i>
                                                <h5 class="text-muted">No schools found</h5>
                                                <p class="text-muted small">Get started by adding your first school</p>
                                                <button class="btn btn-primary mt-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                                                    <i class="fa-solid fa-plus me-2"></i>Add School
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer with Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="card-footer bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="text-muted small">
                                Showing <?= $offset + 1 ?> to <?= min($offset + $limit, $total_schools) ?> of <?= $total_schools ?> entries
                            </div>
                            <nav>
                                <ul class="pagination modern-pagination mb-0">
                                    <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $page-1; ?>" aria-label="Previous">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </a>
                                    </li>
                                    <?php for ($p = 1; $p <= $total_pages; $p++) { ?>
                                        <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $page+1; ?>" aria-label="Next">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add School Modal (Placeholder) -->
<div class="modal fade" id="addSchoolModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-plus-circle me-2 text-primary"></i>
                    Add New School
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-0">School addition form will be implemented here.</p>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Add School</button>
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

/* Main Card */
.main-card {
    border: 1px solid rgba(0,0,0,0.05);
}

/* School Logo */
.school-logo-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #f0f0f0;
}

.school-logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.school-logo-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 1.5rem;
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

/* Ownership Badges */
.ownership-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
}

.ownership-badge.public {
    background: #e3f2fd;
    color: #0d6efd;
}

.ownership-badge.private {
    background: #e8f5e9;
    color: #28a745;
}

/* Type Badges */
.type-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
}

.type-badge.school {
    background: #fff3e0;
    color: #fd7e14;
}

.type-badge.college {
    background: #e0f2fe;
    color: #0dcaf0;
}

.type-badge.university {
    background: #f3e5f5;
    color: #6f42c1;
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

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.inactive {
    background: #f8d7da;
    color: #721c24;
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
    color: white;
}

.action-btn.view {
    background: #0dcaf0;
}

.action-btn.view:hover {
    background: #0baccc;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(13, 202, 240, 0.3);
}

.action-btn.edit {
    background: #fd7e14;
}

.action-btn.edit:hover {
    background: #dc6a0f;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(253, 126, 20, 0.3);
}

.action-btn.delete {
    background: #dc3545;
}

.action-btn.delete:hover {
    background: #bb2d3b;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
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
    
    .header-icon {
        margin: 0 auto;
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

// Search functionality
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#schoolTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Export table to CSV
function exportTable() {
    const table = document.getElementById('schoolTable');
    const rows = table.querySelectorAll('tr');
    const csv = [];
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];
        cols.forEach(col => {
            rowData.push('"' + col.innerText.replace(/"/g, '""') + '"');
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'schools_list.csv';
    a.click();
}

// Placeholder functions
function viewSchool(id) {
    alert('View school details for ID: ' + id);
}

function editSchool(id) {
    alert('Edit school for ID: ' + id);
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