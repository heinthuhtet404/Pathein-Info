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


// Role check
// if ($user['role'] != 1) {
// header("Location: login.php");
// exit;
// }

// School check
// if (empty($user['school_id'])) {
// header("Location: register_school.php");
// exit;
// }

// $school_id = $user['school_id']; // 🔥 Important
?>



<?php include('SuperAdminHeader.php');?>

<body>
    <?php include('SuperAdminSideBar.php');


// Count Only This School Data
$schools = mysqli_num_rows(mysqli_query($db, "SELECT * FROM schools"));
// $teachers = mysqli_num_rows(mysqli_query($db, "SELECT * FROM teachers WHERE school_id=$school_id"));
//  $students = mysqli_num_rows(mysqli_query($db, "SELECT * FROM users WHERE school_id=$school_id"));

 //$curriculums = mysqli_num_rows(mysqli_query($db, "SELECT * FROM curriculums WHERE school_id=$school_id"));
?>

    <div class="container-fluid py-4">

        <h3 class="fw-bold mb-4">Super Admin Dashboard</h3>

        <div class="row g-4">

            <!-- Teachers -->
            <div class="col-md-4">
                <div class="card shadow border-0 rounded-4 text-center p-3 bg-body-tertiary">
                    <div class="card-body">
                        <h5 class="text-muted">Total Schools</h5>
                        <h2 class="fw-bold text-dark"><?= $schools ?></h2>
                        <a href="selectSchool.php" class="btn btn-sm btn-outline-dark mt-2">Manage Schools</a>
                    </div>
                </div>
            </div>


            <!-- Curriculums -->





            <!-- Toggle Button -->



            <!-- <button class="btn btn-primary mb-3" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button> -->



            <!-- <h2>Dashboard Content</h2>
            <p>Your content goes here...</p> -->


            <!-- End Content -->
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }
    </script>

</body>

</html>