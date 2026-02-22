<?php
include 'db.php';

/* ===============================
   CHECK ID FIRST
=================================*/
if (!isset($_GET['id'])) {
    header("Location: select_teacher.php");
    exit;
}

$id = (int)$_GET['id'];

/* ===============================
   UPDATE PROCESS (ONLY ONE TIME)
=================================*/
if (isset($_POST['update'])) {

    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $qualification = mysqli_real_escape_string($db, $_POST['qualification']);
    $phone = mysqli_real_escape_string($db, $_POST['teacher_phone']);

    mysqli_query($db, "
        UPDATE teachers SET
        subject='$subject',
        qualification='$qualification',
        teacher_phone='$phone'
        WHERE teacher_id=$id
    ");

    header("Location: select_teacher.php?updated=1");
    exit;
}

/* ===============================
   GET TEACHER DATA
=================================*/
$result = mysqli_query($db, "SELECT * FROM teachers WHERE teacher_id=$id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Teacher not found!";
    exit;
}
?>

<?php include 'SideBarUpd.php'; ?>
<?php include 'adminHeader.php'; ?>


<style>
body {
    background: #f4f6f9;
}

.card {
    border-radius: 15px;
}
</style>
</head>

<body>
    <div class="container py-5">
        <div class="card shadow-lg col-md-6 mx-auto">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"> <i class="fa fa-edit me-2"></i>Edit Teacher </h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3"> <label class="form-label">Subject</label> <input type="text" name="subject"
                            class="form-control" value="<?= $row['subject'] ?>" required> </div>
                    <div class="mb-3"> <label class="form-label">Qualification</label> <input type="text"
                            name="qualification" class="form-control" value="<?= $row['qualification'] ?>" required>
                    </div>
                    <div class="mb-3"> <label class="form-label">Phone Number</label> <input type="text"
                            name="teacher_phone" class="form-control" value="<?= $row['teacher_phone'] ?>" required>
                    </div>
                    <div class="d-flex justify-content-between"> <a href="select_teacher.php" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back </a> <button type="submit" name="update"
                            class="btn btn-success"> <i class="fa fa-save"></i> Update </button> </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>