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

    <?php
    // Delete School
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        if ($id > 0) {
            $stmt = mysqli_prepare($db, "DELETE FROM schools WHERE school_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: selectSchool.php?msg=deleted");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Delete Failed: " . mysqli_error($db) . "</div>";
            }
        }
    }

    // Pagination
    $limit = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $total_result = mysqli_query($db, "SELECT COUNT(*) AS total FROM schools");
    $total_row = mysqli_fetch_assoc($total_result);
    $total_pages = ceil($total_row['total'] / $limit);

    $data = mysqli_query($db, "SELECT * FROM schools ORDER BY school_id ASC LIMIT $offset,$limit");
    ?>

    <div class="container-fluid py-4">

        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div>
                <h3 class="fw-bold">🏫 School List</h3>
                <p class="text-muted mb-0">Manage all registered schools</p>
            </div>
            <a href="superAdminDashboard.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
            </a>
        </div>

        <!-- School Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-3">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ownership</th>
                                <th>Type</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($data) > 0) {
                                $i = $offset + 1;
                                while ($row = mysqli_fetch_assoc($data)) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <?php if (!empty($row['logo'])) { ?>
                                                <img src="uploads/<?= $row['logo'] ?>" class="rounded border" width="50" height="50" style="object-fit:cover;">
                                            <?php } else { ?>
                                                <span class="badge bg-secondary">No Image</span>
                                            <?php } ?>
                                        </td>
                                        <td class="fw-semibold"><?= $row['name'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td>
                                            <span class="badge bg-info text-dark"><?= ucfirst($row['ownership']) ?></span>
                                        </td>
                                        <td><?= ucfirst($row['type']) ?></td>
                                        <td><?= $row['phone'] ?></td>
                                        <td>
                                            <span class="badge <?= $row['status']=='active'?'bg-success':'bg-secondary' ?>"><?= ucfirst($row['status']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="?delete=<?= $row['school_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this school?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No schools found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($p = 1; $p <= $total_pages; $p++) { ?>
                    <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

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