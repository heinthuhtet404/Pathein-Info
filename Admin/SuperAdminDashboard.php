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
?>

<?php include('SuperAdminHeader.php');?>

<body>
    <?php include('SuperAdminSideBar.php');

    // Count Only This School Data
    $schools = mysqli_num_rows(mysqli_query($db, "SELECT * FROM schools"));
    ?>

    <div class="container-fluid py-4" >

        <h3 class="fw-bold mb-4">Super Admin Dashboard</h3>

        <div class="row g-4">

            <!-- Total Schools Card -->
            <div class="col-md-4">
                <div class="card shadow rounded-4 text-center p-3 bg-white border-0 service-card-bg" style="background: linear-gradient(135deg, #0d6efd, #20c997); color: #fff;">
                    <div class="card-body">
                        <h5 class="text-light mb-2">Total Schools</h5>
                        <h2 class="fw-bold"><?= $schools ?></h2>
                        <a href="selectSchool.php" class="btn btn-light btn-sm mt-3 fw-semibold">Manage Schools</a>
                    </div>
                </div>
            </div>

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