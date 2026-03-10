<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Sidebar -->
<div id="sidebar" class="sidebar bg-gradient-primary text-white vh-100">
    <!-- Sidebar Header with Logo -->
    <div class="sidebar-header mb-4">
        <div class="logo-wrapper d-flex align-items-center gap-3">
            <div class="logo-icon">
                <i class="fa-solid fa-shield-halved fa-2x"></i>
            </div>
            <div class="logo-text">
                <h4 class="mb-0 fw-bold">Super Admin</h4>
                <small class="text-white-50">Management Panel</small>
            </div>
        </div>
    </div>

    <!-- Admin Profile Card -->
    <div class="profile-card mb-4 p-3 rounded-4" style="background: rgba(255,255,255,0.1);">
        <div class="d-flex align-items-center gap-3">
            <div class="profile-image">
                <?php if(isset($_SESSION['profile_image']) && $_SESSION['profile_image'] != '') { ?>
                    <img src="<?= $_SESSION['profile_image'] ?>" alt="Profile" class="rounded-circle" width="45" height="45" style="object-fit: cover;">
                <?php } else { ?>
                    <div class="profile-initials rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" 
                         style="width: 45px; height: 45px; font-weight: bold; font-size: 1.2rem;">
                        <?= strtoupper(substr($_SESSION['name'] ?? $_SESSION['email'] ?? 'A', 0, 1)) ?>
                    </div>
                <?php } ?>
            </div>
            <div class="profile-info">
                <h6 class="mb-0 fw-bold text-white"><?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?></h6>
                <small class="text-white-50">
                    <i class="fa-solid fa-crown me-1"></i>Super Admin
                </small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="SuperAdminDashboard.php" 
               class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'SuperAdminDashboard.php' ? 'active' : 'text-white' ?> rounded-3 d-flex align-items-center">
                <i class="fa-solid fa-chart-pie me-3"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="selectSchool.php" 
               class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'selectSchool.php' ? 'active' : 'text-white' ?> rounded-3 d-flex align-items-center">
                <i class="fa-solid fa-school me-3"></i>
                <span>School Lists</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="select_curriculum.php" 
               class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'select_curriculum.php' ? 'active' : 'text-white' ?> rounded-3 d-flex align-items-center">
                <i class="fa-solid fa-hotel me-3"></i>
                <span>Hotel Lists</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="selectClinics.php" 
               class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'selectClinics.php' ? 'active' : 'text-white' ?> rounded-3 d-flex align-items-center">
                <i class="fa-solid fa-hospital me-3"></i>
                <span>Clinics Lists</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="edit_school.php" 
               class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'edit_school.php' ? 'active' : 'text-white' ?> rounded-3 d-flex align-items-center">
                <i class="fa-solid fa-truck me-3"></i>
                <span>Transport Lists</span>
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="superAdminUserLists.php" 
               class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'superAdminUserLists.php' ? 'active' : 'text-white' ?> rounded-3 d-flex align-items-center">
                <i class="fa-solid fa-users me-3"></i>
                <span>User Lists</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer mt-auto pt-4">
        <div class="d-grid">
            <a href="profile.php" class="btn btn-outline-light btn-sm rounded-3">
                <i class="fa-solid fa-gear me-2"></i>Settings
            </a>
        </div>
    </div>
</div>

<style>
/* Sidebar Gradient */
.bg-gradient-primary {
    background: linear-gradient(180deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
}

/* Sidebar Styles */
.sidebar {
    width: 280px;
    padding: 25px 20px;
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    transition: transform 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    z-index: 1000;
    box-shadow: 4px 0 20px rgba(0,0,0,0.1);
}

.sidebar.hide {
    transform: translateX(-100%);
}

/* Navigation Links */
.sidebar .nav-link {
    padding: 12px 15px;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 12px;
    margin-bottom: 5px;
}

.sidebar .nav-link:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background: rgba(255,255,255,0.25);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.sidebar .nav-link i {
    font-size: 1.1rem;
    width: 24px;
}

/* Profile Card */
.profile-card {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
}

.profile-initials {
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Sidebar Footer */
.sidebar-footer {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 20px;
    margin-top: auto;
}

.sidebar-footer .btn-outline-light {
    border-color: rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.sidebar-footer .btn-outline-light:hover {
    background: white;
    color: #4158D0 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

/* Custom Scrollbar for Sidebar */
.sidebar::-webkit-scrollbar {
    width: 4px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 4px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}
</style>