<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="d-flex">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar bg-gradient-primary text-white vh-100">
        <h4 class="mb-4 text-center fw-bold">Super Admin</h4>

        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item mb-2">
                <a href="SuperAdminDashboard.php" class="nav-link active text-white rounded-3 shadow-sm d-flex align-items-center">
                    <i class="fa-solid fa-list me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="selectSchool.php" class="nav-link text-white rounded-3 shadow-sm d-flex align-items-center">
                    <i class="fa-solid fa-school me-2"></i> School Lists
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="select_curriculum.php" class="nav-link text-white rounded-3 shadow-sm d-flex align-items-center">
                    <i class="fas fa-hotel me-2"></i> Hotel Lists
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white rounded-3 shadow-sm d-flex align-items-center">
                    <i class="fas fa-hospital me-2"></i> Hospital Lists
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="edit_school.php" class="nav-link text-white rounded-3 shadow-sm d-flex align-items-center">
                    <i class="fas fa-truck me-2"></i> Transport Lists
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="superAdminUserLists.php" class="nav-link text-white rounded-3 shadow-sm d-flex align-items-center">
                    <i class="fas fa-users me-2"></i> User Lists
                </a>
            </li>

        </ul>
    </div>

    <!-- Main Content -->
    <div class="content w-100">

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">

            <!-- Sidebar Toggle Button -->
            <button class="btn btn-primary me-3" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Right Side -->
            <div class="ms-auto d-flex align-items-center">

                <!-- Notification Icon -->
                <div class="me-3 position-relative">
                    <i class="fas fa-bell fs-5 text-secondary"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <a class="text-dark d-flex align-items-center text-decoration-none dropdown-toggle" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong>
                        <img src="https://via.placeholder.com/35" alt="avatar" class="rounded-circle ms-2">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="login.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<style>
/* Sidebar gradient & hover */
.bg-gradient-primary {
    background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
}

/* Sidebar smooth toggle */
#sidebar {
    width: 250px;
    min-height: 100vh;
    transition: transform 0.3s ease-in-out;
}

#sidebar.hide {
    transform: translateX(-100%);
}

/* Nav link hover */
#sidebar .nav-link {
    transition: all 0.3s ease;
}

#sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.15);
    transform: translateX(5px);
}

/* Main content shift */
.content {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding: 20px;
    transition: margin-left 0.3s ease-in-out;
    margin-left: 250px;
}

.content.full {
    margin-left: 0;
}

/* Notification badge */
.position-relative span {
    width: 10px;
    height: 10px;
}

/* Rounded avatar */
img.rounded-circle {
    width: 35px;
    height: 35px;
    object-fit: cover;
}

.sidebar {
    width: 250px;
    padding: 20px; /* replaces p-3 */
    box-sizing: border-box; /* ensures padding does not increase width */
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #4e73df; /* your Super Admin blue gradient */
    background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
    transition: transform 0.3s ease-in-out;
}

.sidebar.hide {
    transform: translateX(-100%);
}

.main-content {
    margin-left: 250px;
    transition: margin-left 0.3s ease-in-out;
}
.main-content.full {
    margin-left: 0;
}
</style>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');

    sidebar.classList.toggle('hide');
    content.classList.toggle('full');
}
</script>