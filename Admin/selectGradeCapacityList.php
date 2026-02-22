<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* 🔥 Get school_id from database using user_id */
$user_id = $_SESSION['user_id'];

$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id = $user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

/* 🔥 Delete Process */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($db, "DELETE FROM grade_capacity WHERE id=$id AND school_id=$school_id");
}

/* 🔥 Search */
$search = "";

if (isset($_GET['search']) && $_GET['search'] != "") {

    $search = mysqli_real_escape_string($db, $_GET['search']);

    $query = "SELECT * FROM grade_capacity
              WHERE school_id = $school_id
              AND grade LIKE '%$search%'
              ORDER BY id ASC";

} else {

    $query = "SELECT * FROM grade_capacity
              WHERE school_id = $school_id
              ORDER BY id ASC";
}

$result = mysqli_query($db, $query);
?>

<?php include('adminHeader.php');?>
<?php include('SideBarUpd.php');?>
<style>
body {
    background: #f4f6f9;
}

.card {
    border-radius: 15px;
}

.table thead {
    background: #198754;
    color: white;
}

.btn-success {
    background: #198754;
    border: none;
}

.btn-success:hover {
    background: #146c43;
}
</style>

<div class="container py-5">
    <div class="card shadow-lg">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-layer-group me-2"></i>Grade Capacity List
            </h5>
            <a href="add_grade_capacity.php" class="btn btn-light btn-sm">
                <i class="fa-solid fa-plus"></i> Add Grade
            </a>
        </div>

        <div class="card-body">

            <!-- 🔍 Search -->
            <form method="get" class="row mb-4">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Search by grade..."
                        value="<?= $search ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </form>

            <!-- 📋 Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Grade</th>
                            <th>Max Students</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php $i=0; while($row = mysqli_fetch_assoc($result)): $i++; ?>

                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['grade'] ?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?= $row['max_students'] ?>
                                </span>
                            </td>

                            <td>
                                <a href="edit_grade_capacity.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure to delete?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <?php endwhile; ?>
                        <?php else: ?>

                        <tr>
                            <td colspan="4" class="text-muted">No grade capacity found</td>
                        </tr>

                        <?php endif; ?>

                    </tbody>
                </table>
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