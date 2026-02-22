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


/* Insert Process */
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $grade    = trim($_POST["grade"]);
    $subjects = trim($_POST["subjects"]);

    if (empty($grade)) {
        $errors[] = "Grade is required.";
    }

    /* ================= IMAGE UPLOAD ================= */
    $image_path = "";

    if (!empty($_FILES["image"]["name"])) {

        $allowed_img = ["jpg", "jpeg", "png"];
        $img_name = $_FILES["image"]["name"];
        $img_tmp  = $_FILES["image"]["tmp_name"];
        $img_size = $_FILES["image"]["size"];
        $img_ext  = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        if (!in_array($img_ext, $allowed_img)) {
            $errors[] = "Image must be JPG, JPEG, or PNG.";
        }

        if ($img_size > 2 * 1024 * 1024) {
            $errors[] = "Image must be less than 2MB.";
        }

        if (empty($errors)) {
            $new_img_name = time() . "_" . $img_name;
            $image_path = "uploads/" . $new_img_name;
            move_uploaded_file($img_tmp, $image_path);
        }
    }

    /* ================= PDF UPLOAD ================= */
    $pdf_path = "";

    if (!empty($_FILES["pdf"]["name"])) {

        $allowed_pdf = ["pdf"];
        $pdf_name = $_FILES["pdf"]["name"];
        $pdf_tmp  = $_FILES["pdf"]["tmp_name"];
        $pdf_size = $_FILES["pdf"]["size"];
        $pdf_ext  = strtolower(pathinfo($pdf_name, PATHINFO_EXTENSION));

        if (!in_array($pdf_ext, $allowed_pdf)) {
            $errors[] = "File must be PDF format.";
        }

        if ($pdf_size > 10 * 1024 * 1024) {
            $errors[] = "PDF must be less than 10MB.";
        }

        if (empty($errors)) {
            $new_pdf_name = time() . "_" . $pdf_name;
            $pdf_path = "uploads/" . $new_pdf_name;
            move_uploaded_file($pdf_tmp, $pdf_path);
        }
    }

    /* ================= INSERT DATABASE ================= */

    if (empty($errors)) {

        $stmt = mysqli_prepare($db,
            "INSERT INTO curriculums (school_id, grade, subjects, image, file_path)
             VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "issss",
            $school_id, $grade, $subjects, $image_path, $pdf_path
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: curriculum_list.php?success=1");
            exit;
        } else {
            $errors[] = "Database error!";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<?php include('adminHeader.php'); ?>
<?php include('SideBarUpd.php'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Add Curriculum</h4>
                </div>

                <div class="card-body">

                    <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Grade *</label>
                            <input type="text" name="grade" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subjects</label>
                            <textarea name="subjects" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image (JPG, PNG, Max 2MB)</label>
                            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">PDF File (Max 10MB)</label>
                            <input type="file" name="pdf" class="form-control" accept=".pdf">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Save Curriculum
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