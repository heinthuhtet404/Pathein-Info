<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id=$user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

/* 🔥 Delete */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($db, "DELETE FROM grade_fee WHERE id=$id AND school_id=$school_id");
}

/* 🔍 Search */
$search = "";
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $query = "SELECT *,
              (general_fee+document_fee+uniform_fee) AS total_fee
              FROM grade_fee
              WHERE school_id=$school_id
              AND grade LIKE '%$search%'
              ORDER BY id ASC";
} else {
    $query = "SELECT *,
              (general_fee+document_fee+uniform_fee) AS total_fee
              FROM grade_fee
              WHERE school_id=$school_id
              ORDER BY id ASC";
}

$result = mysqli_query($db, $query);
?>

<?php include('adminHeader.php');?>
<?php include('SideBarUpd.php');?>
<div class="container py-5">
    <div class="card shadow-lg">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-money-bill-wave me-2"></i>Grade Fee List
            </h5>
            <a href="add_grade_fee.php" class="btn btn-light btn-sm">
                <i class="fa-solid fa-plus"></i> Add Grade Fee
            </a>
        </div>

        <div class="card-body">

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

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">

                    <thead class="table-primary">
                        <tr>
                            <th>နံပါတ်</th>
                            <th>Grade</th>
                            <th>အထွေထွေကြေး</th>
                            <th>စာရွက်စာတမ်းကြေး</th>
                            <th>ဝတ်စုံကြေး</th>
                            <th>စုစုပေါင်း</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if(mysqli_num_rows($result)>0): ?>
                        <?php $i=0; while($row=mysqli_fetch_assoc($result)): $i++; ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['grade'] ?></td>
                            <td><?= number_format($row['general_fee']) ?></td>
                            <td><?= number_format($row['document_fee']) ?></td>
                            <td><?= number_format($row['uniform_fee']) ?></td>

                            <td>
                                <span class="badge bg-success">
                                    <?= number_format($row['total_fee']) ?>
                                </span>
                            </td>

                            <td>
                                <a href="edit_grade_fee.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this grade fee?')"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7">No data found</td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>