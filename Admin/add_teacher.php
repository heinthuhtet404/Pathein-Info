<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* 🔥 Get school_id from database using user_id */
$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id = $user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

$success = "";
$error = "";

/* Insert Process */
if (isset($_POST['save'])) {

    $teacher_name  = mysqli_real_escape_string($db, trim($_POST['teacher_name']));
    $subject       = mysqli_real_escape_string($db, trim($_POST['subject']));
    $qualification = mysqli_real_escape_string($db, trim($_POST['qualification']));
    $teacher_phone = mysqli_real_escape_string($db, trim($_POST['teacher_phone']));
    $teacher_email = mysqli_real_escape_string($db, trim($_POST['teacher_email']));

    if (empty($teacher_name) || empty($subject) || empty($teacher_phone)) {
        $error = "Please fill all required fields!";
    } else {

        /* Duplicate Email Check */
        if (!empty($teacher_email)) {
            $check = mysqli_query($db, "SELECT teacher_id FROM teachers WHERE teacher_email='$teacher_email'");
            if (mysqli_num_rows($check) > 0) {
                $error = "Teacher email already exists!";
            }
        }

        if (empty($error)) {

            $query = "INSERT INTO teachers
            (school_id, teacher_name, subject, qualification, teacher_phone, teacher_email)
            VALUES
            ('$school_id', '$teacher_name', '$subject', '$qualification', '$teacher_phone', '$teacher_email')";

            if (mysqli_query($db, $query)) {
                $success = "Teacher added successfully!";
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

                <div class="card shadow-lg form-card">
                    <div class="card-header text-center bg-primary text-white">
                        <i class="fa-solid fa-chalkboard-user me-2"></i>
                        <b>Add New Teacher</b>
                    </div>

                    <div class="card-body p-4">

                        <?php if ($success) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                        <?php } ?>

                        <?php if ($error) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php } ?>

                        <form method="post">
                            <!-- <input type="hidden" name="school_id" value="<?= $_SESSION['school_id'] ?>"> -->


                            <!-- Teacher Name -->
                            <div class="mb-3">
                                <label class="form-label">Teacher Name *</label>
                                <input type="text" name="teacher_name" class="form-control" required>
                            </div>

                            <!-- Subject + Qualification -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subject *</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Qualification</label>
                                    <input type="text" name="qualification" class="form-control">
                                </div>
                            </div>

                            <!-- Phone + Email -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone *</label>
                                    <input type="number" name="teacher_phone" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="teacher_email" class="form-control">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="text-center mt-3">
                                <button type="submit" name="save" class="btn btn-primary px-4">
                                    <i class="fa-solid fa-save me-2"></i> Save Teacher
                                </button>

                                <button type="reset" class="btn btn-secondary px-4">
                                    <i class="fa-solid fa-rotate me-2"></i> Reset
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS -->

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }
    </script>

</body>

</html>