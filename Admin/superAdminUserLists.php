<?php
session_start();
include('db.php');
include('SuperAdminHeader.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM users WHERE role_id = 1 LIMIT $start, $limit";
$result = $db->query($sql);

$total_result = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 1");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
?>

<body>
    <?php include('SuperAdminSideBar.php'); ?>

    
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="margin-top: 20px;">
        <div class="d-flex align-items-center">
            <!-- <button id="toggleBtn" class="btn btn-dark me-3">☰</button> -->
        <div>
            <h3 class="fw-bold mb-0">👤 User Lists</h3>
            <p class="text-muted mb-0">Manage all registered users</p>
        </div>
    </div>

    <a href="SuperAdminDashboard.php" class="btn btn-primary shadow-sm">
        <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
    </a>
</div>

        <!-- Card/Table -->
        <div class="card shadow-sm rounded-4">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = $start + 1;
                            if(mysqli_num_rows($result) > 0){
                                while($row = $result->fetch_assoc()){ 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= $row['name']; ?></strong></td>
                                <td><?= $row['email']; ?></td>
                                <td>
                                    <?php 
                                    if($row['status'] == 'Pending'){ ?>
                                        <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                    <?php } elseif($row['status'] == 'Accept'){ ?>
                                        <span class="badge bg-success px-3 py-2">Accept</span>
                                    <?php } elseif($row['status'] == 'Reject'){ ?>
                                        <span class="badge bg-danger px-3 py-2">Reject</span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <a href="approve.php?id=<?= $row['user_id']; ?>" class="btn btn-sm btn-outline-success me-2"
                                        onclick="return confirm('Accept this user?')">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </a>
                                    <a href="SuperAdminReject_User.php?id=<?= $row['user_id']; ?>" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Reject this user?')">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else { 
                            ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center mt-4">
                        <?php for($i=1; $i <= $total_pages; $i++){ ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>

            </div>
        </div>

    
    <style>
/* Sidebar smooth animation */
.sidebar {
    width: 250px;
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #212529;
    transition: transform 0.3s ease-in-out;
}

.sidebar.hide {
    transform: translateX(-100%);
}

/* Main content shift */
.main-content {
    margin-left: 250px;
    transition: margin-left 0.3s ease-in-out;
}

.main-content.full {
    margin-left: 0;
}
</style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.getElementById("toggleBtn").addEventListener("click", function(){
    document.querySelector(".sidebar").classList.toggle("hide");
    document.querySelector(".main-content").classList.toggle("full");
});
</script>
</body>
</html>