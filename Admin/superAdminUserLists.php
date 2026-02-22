<?php
include ("db.php");


$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM users WHERE role_id = 1 LIMIT $start, $limit";
$result = $db->query($sql);

$total_result = $db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 1");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
?>
<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background: #f4f6f9;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        object-fit: cover;
    }

    .card {
        border: none;
        border-radius: 15px;
    }
    </style>
</head>

<body>

    <div class="container mt-5">

        <!-- Header -->
        <div class="d-flex justify-content-center align-items-center mb-4">

            <div>
                <h3 class="fw-bold">👤 User Lists</h3>
                <!-- <p class="text-muted justify-content-center mb-0">Manage all users</p> -->
            </div>
            <!-- <a href="addSchool.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add School
        </a> -->
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
$no = $start + 1;
while($row = $result->fetch_assoc()){ 
?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <strong><?= $row['name']; ?></strong>
                                </td>
                                <td><?= $row['email']; ?></td>

                                <td>
                                    <?php if($row['status'] == 'Pending'){ ?>
                                    <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                    <?php } elseif($row['status'] == 'Accept'){ ?>
                                    <span class="badge bg-success px-3 py-2">Accept</span>
                                    <?php } elseif($row['status'] == 'Reject'){ ?>
                                    <span class="badge bg-danger px-3 py-2">Reject</span>
                                    <?php } ?>
                                </td>

                                <td>

                                    <a href="approve.php?id=<?= $row['user_id']; ?>"
                                        class="btn btn-sm btn-outline-success me-2"
                                        onclick="return confirm('Accept this user?')">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </a>

                                    <a href="SuperAdminReject_User.php?id=<?= $row['user_id']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Reject this user?')">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>

                                </td>

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
                <a href="SuperAdminDashboard.php" class="btn btn-dark shadow-lg position-fixed"
                    style="bottom: 25px; right: 25px; border-radius: 50px; padding: 10px 20px; z-index: 999;">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Home
                </a>





            </div>
        </div>
    </div>

</body>

</html>