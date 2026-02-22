<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$school_id = intval($_SESSION['school_id']);

if (!isset($_GET['id'])) {
    header("Location: curriculum_list.php");
    exit;
}

$id = intval($_GET['id']);

/* Fetch old data */
$result = mysqli_query($db, "SELECT * FROM curriculums WHERE curriculum_id=$id AND school_id=$school_id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Data not found!";
    exit;
}

/* Update Process */
if (isset($_POST['update'])) {

    $grade = mysqli_real_escape_string($db, $_POST['grade']);
    $subjects = mysqli_real_escape_string($db, $_POST['subjects']);

    $image = $row['image'];
    $file = $row['file_path'];

    // Image Upload
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . "_" . $_FILES['image']['name'];
        $image_path = "uploads/" . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        $image = $image_path;
    }

    // File Upload
    if (!empty($_FILES['file']['name'])) {
        $file_name = time() . "_" . $_FILES['file']['name'];
        $file_path = "uploads/" . $file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
        $file = $file_path;
    }

    mysqli_query($db, "UPDATE curriculums SET
        grade='$grade',
        subjects='$subjects',
        image='$image',
        file_path='$file'
        WHERE curriculum_id=$id AND school_id=$school_id
    ");

    header("Location: select_curriculum.php?updated=1");
    exit;
}
?>

<?php include('adminHeader.php'); ?>
<?php include('SideBarUpd.php'); ?>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5>Edit Curriculum</h5>
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Grade</label>
                    <input type="text" name="grade" class="form-control" value="<?= $row['grade'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Subject</label>
                    <input type="text" name="subjects" class="form-control" value="<?= $row['subjects'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Current Image</label><br>
                    <?php if(!empty($row['image'])){ ?>
                    <img src="<?= $row['image'] ?>" width="120" class="mb-2">
                    <?php } ?>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Current File</label><br>
                    <?php if(!empty($row['file_path'])){ ?>
                    <a href="<?= $row['file_path'] ?>" target="_blank">View Current File</a>
                    <?php } ?>
                    <input type="file" name="file" class="form-control">
                </div>

                <button type="submit" name="update" class="btn btn-primary">
                    Update
                </button>
                <a href="select_curriculum.php" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

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