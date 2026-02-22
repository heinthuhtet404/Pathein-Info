<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($db, "SELECT * FROM users WHERE user_id=$user_id");
$user = mysqli_fetch_assoc($result);

if ($user['role'] != 'schoolAdmin') {
    header("Location: login.php");
    exit;
}

if (empty($user['school_id'])) {
    header("Location: register_school.php");
    exit;
}
?>



<?php include('adminHeader.php');?>

<body>
    <?php include('SideBarUpd.php');


// Count Only This School Data
$teachers = mysqli_num_rows(mysqli_query($db, "SELECT * FROM teachers WHERE school_id=$school_id"));
$students = mysqli_num_rows(mysqli_query($db, "SELECT * FROM users WHERE school_id=$school_id AND role='student'"));
$curriculums = mysqli_num_rows(mysqli_query($db, "SELECT * FROM curriculums WHERE school_id=$school_id"));
?>

    <div class="container-fluid py-4">

        <h3 class="fw-bold mb-4">🏫 School Admin Dashboard</h3>

        <div class="row g-4">

            <!-- Teachers -->
            <div class="col-md-4">
                <div class="card shadow border-0 rounded-4 text-center p-3">
                    <div class="card-body">
                        <h5 class="text-muted">Total Teachers</h5>
                        <h2 class="fw-bold text-primary"><?= $teachers ?></h2>
                        <a href="teachers.php" class="btn btn-sm btn-outline-primary mt-2">Manage Teachers</a>
                    </div>
                </div>
            </div>

            <!-- Students -->
            <div class="col-md-4">
                <div class="card shadow border-0 rounded-4 text-center p-3">
                    <div class="card-body">
                        <h5 class="text-muted">Total Students</h5>
                        <h2 class="fw-bold text-success"><?= $students ?></h2>
                        <a href="students.php" class="btn btn-sm btn-outline-success mt-2">Manage Students</a>
                    </div>
                </div>
            </div>

            <!-- Curriculums -->
            <div class="col-md-4">
                <div class="card shadow border-0 rounded-4 text-center p-3">
                    <div class="card-body">
                        <h5 class="text-muted">Total Curriculums</h5>
                        <h2 class="fw-bold text-warning"><?= $curriculums ?></h2>
                        <a href="curriculums.php" class="btn btn-sm btn-outline-warning mt-2">Manage Curriculums</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Extra Info Section -->
        <div class="card shadow border-0 rounded-4 mt-5">
            <div class="card-header bg-dark text-white rounded-top-4">
                📌 Quick Actions
            </div>
            <div class="card-body">

                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="add_teacher.php" class="btn btn-primary w-100">➕ Add Teacher</a>
                    </div>

                    <div class="col-md-4">
                        <a href="add_student.php" class="btn btn-success w-100">➕ Add Student</a>
                    </div>

                    <div class="col-md-4">
                        <a href="add_curriculum.php" class="btn btn-warning w-100">➕ Add Curriculum</a>
                    </div>
                </div>

            </div>
        </div>

    </div>