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

/* End school_id from database using user_id(to copy)*/
?>

<?php include('adminHeader.php');?>

<?php include('SideBarUpd.php');

// include 'db.php';

     // Delete Process
     if (isset($_GET['delete'])) {
     $id = (int)$_GET['delete'];
     mysqli_query($db, "DELETE FROM teachers WHERE teacher_id=$id");

     }

/* search by name*/

   $search = "";

if (isset($_GET['search']) && $_GET['search'] != "") {

    $search = mysqli_real_escape_string($db, $_GET['search']);

    $query = "SELECT t.*, s.name as school_name
              FROM teachers t
              JOIN schools s ON t.school_id = s.school_id
              WHERE t.school_id = $school_id
              AND (
                    t.teacher_name LIKE '%$search%'
                    OR t.subject LIKE '%$search%'
                    OR t.teacher_email LIKE '%$search%'
                  )
              ORDER BY t.teacher_id ASC";

} else {

    $query = "SELECT t.*, s.name as school_name
              FROM teachers t
              JOIN schools s ON t.school_id = s.school_id
              WHERE t.school_id = $school_id
              ORDER BY t.teacher_id ASC";
}

     $result = mysqli_query($db, $query);
     ?>





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
</style>
</head>

<body>

    <div class="container py-5">

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fa-solid fa-chalkboard-user me-2"></i>Teacher List</h5>
                <a href="add_teacher.php" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-plus"></i> Add Teacher
                </a>
            </div>

            <div class="card-body">

                <!-- Search Form -->
                <form method="get" class="row mb-4">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name, subject or email..." value="<?= $search ?>">
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
                                <th>Teacher Name</th>
                                <th>Subject</th>
                                <th>Qualification</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if(mysqli_num_rows($result) > 0): ?>

                            <?php       $i = 0;
                                     while($row = mysqli_fetch_assoc($result)): 
                                       $i=$i+1;
                                     
                                     ?>
                            <tr>
                                <td><?= $i ?></td>

                                <td><?= $row['teacher_name'] ?></td>
                                <td><?= $row['subject'] ?></td>
                                <td><?= $row['qualification'] ?></td>
                                <td><?= $row['teacher_phone'] ?></td>
                                <td><?= $row['teacher_email'] ?></td>
                                <td>
                                    <a href="edit_teacher.php?id=<?= $row['teacher_id'] ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="?delete=<?= $row['teacher_id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure to delete?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-muted">No teacher found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>




            <!-- End Content -->
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


</body>

</html>