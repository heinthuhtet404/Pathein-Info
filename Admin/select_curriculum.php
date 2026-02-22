<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/*Get school_id from database using user_id */
$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id = $user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

/* ================= DELETE (Secure) ================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    mysqli_query($db,
        "DELETE FROM curriculums 
         WHERE curriculum_id = $id 
         AND school_id = $school_id"
    );

    header("Location: select_curriculum.php");
    exit;
}

/* ================= SEARCH ================= */
$search = "";
$where = "WHERE c.school_id = $school_id";

if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $where .= " AND (
                    c.grade LIKE '%$search%' OR
                    c.subjects LIKE '%$search%'
                )";
}

/* ================= PAGINATION ================= */
$limit = 5; // rows per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

/* Count total rows */
$countQuery = "SELECT COUNT(*) as total
               FROM curriculums c
               $where";

$countResult = mysqli_query($db, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRows = $countRow['total'];
$totalPages = ceil($totalRows / $limit);

/* Main Query */
$query = "SELECT c.*, s.name as school_name
          FROM curriculums c
          JOIN schools s ON c.school_id = s.school_id
          $where
          ORDER BY c.curriculum_id ASC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($db, $query);
?>

<?php include('adminHeader.php'); ?>
<?php include('SideBarUpd.php'); ?>

<style>
body {
    background: #f4f6f9;
}

.card {
    border-radius: 15px;
}

.table thead {
    background: #1e73be;
    color: white;
}

.btn-primary {
    background: #1e73be;
    border: none;
}

.btn-primary:hover {
    background: #155a96;
}

#sidebar {
    width: 250px;
    transition: all 0.3s;
}

#sidebar.collapsed {
    margin-left: -250px;
}

#content {
    transition: all 0.3s;
    margin-left: 250px;
}

#content.expanded {
    margin-left: 0;
}
</style>


<div class="container py-5">

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-chalkboard-user me-2"></i>
                Curriculum List
            </h5>
            <a href="add_curriculum.php" class="btn btn-light btn-sm">
                <i class="fa-solid fa-plus"></i> Add Curriculum
            </a>
        </div>

        <div class="card-body">

            <!-- Search -->
            <form method="get" class="row mb-4">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Search by grade, subject..."
                        value="<?= $search ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>School Name</th>
                            <th>Grade</th>
                            <th>Subject</th>
                            <th>Image</th>
                            <th>File</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php $i = $offset + 1; ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row['school_name'] ?></td>
                            <td><?= $row['grade'] ?></td>
                            <td><?= $row['subjects'] ?></td>

                            <td>
                                <?php if(!empty($row['image'])): ?>
                                <img src="<?= $row['image']; ?>" width="80" height="80"
                                    style="object-fit:cover;border-radius:6px;">
                                <?php else: ?>
                                <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(!empty($row['file_path'])): ?>
                                <a href="<?= $row['file_path']; ?>" target="_blank" class="btn btn-sm btn-primary">
                                    View File
                                </a>
                                <?php else: ?>
                                <span class="text-muted">No File</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="edit_curriculum.php?id=<?= $row['curriculum_id'] ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="?delete=<?= $row['curriculum_id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure to delete?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-muted">No Curriculum found</td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
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


        </div>
    </div>

    <!-- Pagination -->
    <?php if($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">

            <?php for($p = 1; $p <= $totalPages; $p++): ?>
            <li class="page-item <?= ($page == $p) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $p ?>&search=<?= urlencode($search) ?>">
                    <?= $p ?>
                </a>
            </li>
            <?php endfor; ?>

        </ul>
    </nav>
    <?php endif; ?>

</div>


</body>

</html>