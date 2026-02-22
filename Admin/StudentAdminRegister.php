<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Get school_id */
$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id = $user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

/* Fetch Students */
$result = mysqli_query($db,"
SELECT * FROM studentregisters
WHERE school_id = $school_id
ORDER BY register_id DESC
");


/* ================= PAGINATION ================= */
$limit = 5; // per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

/* Count total rows */
$countQuery = "
SELECT COUNT(*) as total
FROM studentregisters
WHERE school_id = $school_id
";

$countResult = mysqli_query($db, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRows = $countRow['total'];
$totalPages = ceil($totalRows / $limit);

/* Main Query with LIMIT */
$result = mysqli_query($db,"
SELECT * FROM studentregisters
WHERE school_id = $school_id
ORDER BY register_id ASC
LIMIT $limit OFFSET $offset
");

?>

<?php include('adminHeader.php'); ?>
<?php include('SideBarUpd.php'); ?>

<div class="container py-5">

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fa-solid fa-user-graduate me-2"></i>
                Student Registration List
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Grade</th>
                            <th>Fee</th>
                            <th>payment</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['register_id'] ?></td>
                            <td><?= $row['student_name'] ?></td>
                            <td><?= $row['grade'] ?></td>
                            <td><?= number_format($row['fee']) ?></td>
                            <!-- <td>
                                <span class="badge bg-info text-dark">
                                    <?= $row['payment'] ?>
                                </span>
                            </td> -->

                            <!-- Screenshot Zoom -->
                            <td>
                                <?php if(!empty($row['payment_screenshot'])): ?>
                                <img src="../uploads/payments/<?= $row['payment_screenshot'] ?>" width="45" height="60"
                                    style="object-fit:cover;border-radius:6px;cursor:pointer"
                                    onclick="showImage(this.src)">
                                <?php else: ?>
                                <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>


                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif($row['status'] == 'accepted'): ?>
                                <span class="badge bg-success">Accepted</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                <a href="StudentAdminRegisterPaymentStatus.php?id=<?= $row['register_id'] ?>&status=accepted"
                                    class="btn btn-success btn-sm">
                                    Accept
                                </a>

                                <a href="StudentAdminRegisterPaymentStatus.php?id=<?= $row['register_id'] ?>&status=rejected"
                                    class="btn btn-danger btn-sm">
                                    Reject
                                </a>
                                <?php else: ?>
                                <span class="text-muted">No Action</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-muted">
                                No Registration Found
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
            <?php if($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">

                    <?php for($p = 1; $p <= $totalPages; $p++): ?>
                    <li class="page-item <?= ($page == $p) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $p ?>">
                            <?= $p ?>
                        </a>
                    </li>
                    <?php endfor; ?>

                </ul>
            </nav>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- Screenshot Modal -->
<div id="imgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.8); text-align:center; z-index:9999;">

    <span onclick="closeModal()"
        style="color:white;font-size:35px;cursor:pointer;position:absolute;top:20px;right:40px;">
        &times;
    </span>

    <img id="modalImg" style="margin-top:60px; max-width:80%; max-height:80%; border-radius:10px;">
</div>

<script>
function showImage(src) {
    document.getElementById('imgModal').style.display = 'block';
    document.getElementById('modalImg').src = src;
}

function closeModal() {
    document.getElementById('imgModal').style.display = 'none';
}
</script>

</body>

</html>