<?php
session_start();
include('db.php');

/* ===============================
   CHECK ID FIRST
=================================*/
if (!isset($_GET['id'])) {
    header("Location: grade_capacity_list.php");
    exit;
}

$id = (int)$_GET['id'];

/* ===============================
   UPDATE PROCESS
=================================*/
if(isset($_POST['update'])){
    $grade = mysqli_real_escape_string($db, $_POST['grade']);
    $max_students = intval($_POST['max_students']);

    mysqli_query($db, "
        UPDATE grade_capacity 
        SET grade='$grade', max_students='$max_students'
        WHERE id=$id
    ");

    header("Location: selectGradeCapacityList.php?updated=1");
    exit;
}

/* ===============================
   GET DATA
=================================*/
$result = mysqli_query($db, "SELECT * FROM grade_capacity WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(!$row){
    echo "Record not found!";
    exit;
}
?>

<?php include('SideBarUpd.php'); ?>
<?php include('adminHeader.php'); ?>

<style>
body {
    background: #f4f6f9;
}

.card {
    border-radius: 15px;
}
</style>

<div class="container py-5">
    <div class="card shadow-lg col-md-6 mx-auto">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fa fa-edit me-2"></i> Edit Grade Capacity
            </h5>
        </div>

        <div class="card-body">
            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Grade</label>
                    <input type="text" name="grade" class="form-control" value="<?= $row['grade'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Max Students</label>
                    <input type="number" name="max_students" class="form-control" value="<?= $row['max_students'] ?>"
                        required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="selectGradeCapacityList.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>

                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>