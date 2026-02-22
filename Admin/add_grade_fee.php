<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* 🔥 Get school_id */
$getSchool = mysqli_query($db, "SELECT school_id FROM schools WHERE user_id = $user_id");
$schoolRow = mysqli_fetch_assoc($getSchool);

if (!$schoolRow) {
    header("Location: register_school.php");
    exit;
}

$school_id = $schoolRow['school_id'];

$success = "";
$error = "";

if (isset($_POST['save'])) {

    $grade        = mysqli_real_escape_string($db, $_POST['grade']);
    $general_fee  = floatval($_POST['general_fee']);
    $document_fee = floatval($_POST['document_fee']);
    $uniform_fee  = floatval($_POST['uniform_fee']);

    if (empty($grade)) {
        $error = "Please fill Grade!";
    } else {

        // Duplicate Grade Check
        $check = mysqli_query($db, "SELECT id FROM grade_fee 
                                    WHERE school_id='$school_id' AND grade='$grade'");

        if (mysqli_num_rows($check) > 0) {
            $error = "This grade already exists!";
        } else {

            $query = "INSERT INTO grade_fee
                     (school_id, grade, general_fee, document_fee, uniform_fee)
                     VALUES
                     ('$school_id', '$grade', '$general_fee', '$document_fee', '$uniform_fee')";

            if (mysqli_query($db, $query)) {
                $success = "Grade Fee added successfully!";
            } else {
                $error = "Insert failed: " . mysqli_error($db);
            }
        }
    }
}
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

.card-header {
    background: #0d6efd;
    color: white;
}

.total-box {
    font-size: 20px;
    font-weight: bold;
    color: #198754;
}
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg">

                <div class="card-header text-center">
                    <i class="fa-solid fa-money-bill-wave me-2"></i>
                    <b>Add Grade Fee</b>
                </div>

                <div class="card-body p-4">

                    <?php if ($success) { ?>
                    <div class="alert alert-success"><?= $success ?></div>
                    <?php } ?>

                    <?php if ($error) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                    <?php } ?>

                    <form method="post">

                        <!-- Grade -->
                        <div class="mb-3">
                            <label class="form-label">Grade *</label>
                            <input type="text" name="grade" class="form-control" required>
                        </div>

                        <!-- Fees -->
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">အထွေထွေကြေး</label>
                                <input type="number" step="0.01" name="general_fee" class="form-control fee" value="0">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">စာရွက်စာတမ်းကြေး</label>
                                <input type="number" step="0.01" name="document_fee" class="form-control fee" value="0">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">ဝတ်စုံကြေး</label>
                                <input type="number" step="0.01" name="uniform_fee" class="form-control fee" value="0">
                            </div>

                        </div>

                        <!-- Total -->
                        <div class="mb-3 text-center total-box">
                            Total Fee: <span id="total">0</span> MMK
                        </div>

                        <!-- Buttons -->
                        <div class="text-center">
                            <button type="submit" name="save" class="btn btn-primary px-4">
                                <i class="fa-solid fa-save me-2"></i> Save
                            </button>

                            <button type="reset" class="btn btn-secondary px-4">
                                <i class="fa-solid fa-rotate me-2"></i> Reset
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
    document.getElementById('total').innerText = total.toLocaleString();
}

document.querySelectorAll('.fee').forEach(function(input) {
    input.addEventListener('input', calculateTotal);
});

calculateTotal();
</script>