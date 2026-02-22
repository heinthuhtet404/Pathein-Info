<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="d-flex">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar text-white p-3">

        <h4 class="mb-4">School Admin</h4>

        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item">
                <a href="AdminDashboardUp.php" class="nav-link active">
                    <i class="fa-solid fa-list me-2"></i> Dashboard
                </a>
            </li>

            <!-- Dropdown -->
            <li>


                <!-- <div class="collapse ps-4" id="schoolMenu">
                        <ul class="nav flex-column">
                            <li>
                                <a href="#" class="nav-link text-white">
                                    <i class="fa-sharp-duotone fa-solid fa-house"></i>အခြေခံပညာကျောင်းများ
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-white">
                                    <i class="fa-sharp fa-solid fa-landmark"></i>တက္ကသိုလ်များ
                                </a>
                            </li>
                        </ul>
                    </div> -->
            </li>

            <li>
                <a href="select_teacher.php" class="nav-link">
                    <!-- <i class="fa-solid fa-truck-medical me-2"></i> ကျန်းမာရေး -->
                    <i class="fa-solid fa-truck-medical me-2"></i> Teacher
                </a>
            </li>

            <li>
                <a href="select_curriculum.php" class="nav-link">
                    <!-- <i class="fas fa-bus me-2"></i> သယ်ယူပို့ဆောင်ရေး -->
                    <i class="fas fa-bus me-2"></i> Curriculum
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <!-- <i class="fas fa-building me-2"></i> ဟိုတည်များ -->
                    <i class="fas fa-building me-2"></i> Activity
                </a>
            </li>

            <li>
                <a href="#" class="nav-link">
                    <!-- <i class="fas fa-building me-2"></i> ဟိုတည်များ -->
                    <i class="fas fa-building me-2"></i> Announcement
                </a>
            </li>
            <li>
                <a href="selectGradeCapacityList.php" class="nav-link">
                    <!-- <i class="fas fa-building me-2"></i> ဟိုတည်များ -->
                    <i class="fas fa-building me-2"></i> Grade Capacity
                </a>
            </li>
            <li>
                <a href="selectGradeFeeList.php" class="nav-link">
                    <!-- <i class="fas fa-building me-2"></i> ဟိုတည်များ -->
                    <i class="fas fa-building me-2"></i> Grade Fee
                </a>
            </li>


            <li>
                <a href="StudentAdminRegister.php" class="nav-link">
                    <!-- <i class="fas fa-building me-2"></i> ဟိုတည်များ -->
                    <i class="fas fa-building me-2"></i> Student Register
                </a>
            </li>

            <li>
                <a href="edit_school.php" class="nav-link">
                    <!-- <i class="fa-solid fa-truck-medical me-2"></i> ကျန်းမာရေး -->
                    <i class="fa-solid fa-truck-medical me-2"></i>School Profile
                </a>
            </li>
        </ul>

        <hr>

        <a href="#" class="nav-link text-white">
            <i class="fas fa-right-from-bracket me-2"></i> Logout
        </a>

    </div>

    <!-- Main Content -->
    <div class="content w-100">

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">

            <!-- Sidebar Toggle Button -->
            <button class="btn btn-primary mb-3" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>


            <!-- Right Side -->
            <div class="ms-auto d-flex align-items-center">

                <!-- Notification Icon -->
                <!-- <div class="me-3">
                        <i class="fas fa-bell fs-5"></i>
                    </div> -->

                <!-- User Dropdown -->
                <div class="dropdown">
                    <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">



                        <strong>


                            <?php echo $_SESSION['email']; ?>
                        </strong>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>