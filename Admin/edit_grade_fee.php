<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_GET['id'];

$result = mysqli_query($db,"SELECT * FROM grade_fee WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $grade    = $_POST['grade'];
    $general  = $_POST['general_fee'];
    $document = $_POST['document_fee'];
    $uniform  = $_POST['uniform_fee'];

    mysqli_query($db,"UPDATE grade_fee SET
        grade='$grade',
        general_fee='$general',
        document_fee='$document',
        uniform_fee='$uniform'
        WHERE id=$id");

    header("Location: selectGradeFeeList.php?updated=1");
    exit;
}
?>

<?php include('adminHeader.php');?>
<?php include('SideBarUpd.php');?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-lg">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-edit me-2"></i>
                        Edit Grade Fee
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form method="post">

                        <!-- Grade -->
                        <div class="mb-3">
                            <label class="form-label">Grade</label>
                            <input type="text" name="grade" class="form-control" value="<?= $row['grade'] ?>" required>
                        </div>

                        <!-- General Fee -->
                        <div class="mb-3">
                            <label class="form-label">အထွေထွေကြေး</label>
                            <input type="number" step="0.01" name="general_fee" class="form-control fee"
                                value="<?= $row['general_fee'] ?>">
                        </div>

                        <!-- Document Fee -->
                        <div class="mb-3">
                            <label class="form-label">စာရွက်စာတမ်းကြေး</label>
                            <input type="number" step="0.01" name="document_fee" class="form-control fee"
                                value="<?= $row['document_fee'] ?>">
                        </div>

                        <!-- Uniform Fee -->
                        <div class="mb-3">
                            <label class="form-label">ဝတ်စုံကြေး</label>
                            <input type="number" step="0.01" name="uniform_fee" class="form-control fee"
                                value="<?= $row['uniform_fee'] ?>">
                        </div>

                        <!-- Total Display -->
                        <div class="mb-3 text-center">
                            <strong>Total Fee: </strong>
                            <span id="total" class="text-success fw-bold"></span>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">

                            <a href="selectGradeFeeList.php" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Back
                            </a>

                            <button type="submit" name="update" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i> Update
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.fee').forEach(function(input) {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('total').innerText = total.toLocaleString() + " MMK";
}

document.querySelectorAll('.fee').forEach(function(input) {
    input.addEventListener('input', calculateTotal);
});

calculateTotal();
</script>