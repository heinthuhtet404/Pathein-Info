<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id = $user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

$success = "";
$error = "";

if (isset($_POST['save'])) {

    $grade = mysqli_real_escape_string($db, $_POST['grade']);
    $max_students = intval($_POST['max_students']);

    if (empty($grade) || empty($max_students)) {
        $error = "Please fill all fields!";
    } else {

        // Duplicate Grade Check
        $check = mysqli_query($db, "SELECT id FROM grade_capacity 
                                    WHERE school_id='$school_id' AND grade='$grade'");
        if (mysqli_num_rows($check) > 0) {
            $error = "This grade already exists!";
        } else {

            $insert = "INSERT INTO grade_capacity (school_id, grade, max_students)
                       VALUES ('$school_id', '$grade', '$max_students')";

            if (mysqli_query($db, $insert)) {
                $success = "Grade Capacity added successfully!";
            } else {
                $error = "Insert failed: " . mysqli_error($db);
            }
        }
    }
}
?>

<body>
    <?php include('adminHeader.php');?>
    <?php include('SideBarUpd.php');?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <b>Add Grade Capacity</b>
                    </div>

                    <div class="card-body">

                        <?php if ($success) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                        <?php } ?>

                        <?php if ($error) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php } ?>

                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label">Grade Name</label>
                                <input type="text" name="grade" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Maximum Students</label>
                                <input type="number" name="max_students" class="form-control" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" name="save" class="btn btn-primary px-4">
                                    Save Capacity
                                </button>
                                <button type="reset" class="btn btn-secondary px-4">
                                    Reset
                                </button>
                            </div>

                        </form>

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

    <?php if(isset($_GET['updated'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Updated!',
        text: 'Teacher updated successfully.',
        timer: 2000,
        showConfirmButton: false
    });
    </script>
    <?php endif; ?>


</body>