<?php
session_start();
include 'db.php';

if (!isset($_SESSION['business_id'])) {
    header("Location: business_man_login.php");
    exit;
}

$user_id = $_SESSION['business_id'];

// လက်ရှိ ဆေးခန်း အချက်အလက် ဆွဲထုတ်ခြင်း
$query = "SELECT * FROM clinics WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($db, $query);
$clinic = mysqli_fetch_assoc($result);

if (isset($_POST['update_clinic'])) {
    $phone = mysqli_real_escape_string($db, $_POST['clinics_phone']);
    $address = mysqli_real_escape_string($db, $_POST['clinics_address']);
    $desc = mysqli_real_escape_string($db, $_POST['clinics_description']);

    // Logo update
    $logo_query = "";
    if (!empty($_FILES['clinics_logo']['name'])) {
        $logo_name = time() . "_" . basename($_FILES['clinics_logo']['name']);
        move_uploaded_file($_FILES['clinics_logo']['tmp_name'], "uploads/" . $logo_name);
        $logo_query = ", clinics_logo = '$logo_name'";
    }

    // Update clinics table
    $update_clinic_sql = "UPDATE clinics SET 
                            clinics_phone='$phone', 
                            clinics_address='$address', 
                            clinics_description='$desc'
                            $logo_query
                            WHERE user_id='$user_id'";

    if (!mysqli_query($db, $update_clinic_sql)) {
        echo "Error updating clinic: " . mysqli_error($db);
        exit;
    }

    // Password update (users table)
    // Password update for users table
$new_password = trim($_POST['new_password']);
if (!empty($new_password)) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_user_sql = "UPDATE users SET password='$hashed_password' WHERE user_id='$user_id'";
    if (!mysqli_query($db, $update_user_sql)) {
        echo "Error updating password: " . mysqli_error($db);
        exit;
    }
}

    echo "<script>alert('ဆေးခန်းအချက်အလက်ကို ပြင်ဆင်ပြီးပါပြီ!'); window.location.href='clinics_admindashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Clinic Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .preview-logo { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #ddd; }
        .form-control[readonly] { background-color: #e9ecef; cursor: not-allowed; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> ဆေးခန်းအချက်အလက် ပြင်ဆင်ရန်</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3 border-end">
                                <label class="form-label d-block fw-bold">Clinic Logo</label>
                                <?php if (!empty($clinic['clinics_logo'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($clinic['clinics_logo']); ?>" class="preview-logo mb-3">
                                <?php else: ?>
                                    <div class="bg-secondary text-white preview-logo d-flex align-items-center justify-content-center mx-auto mb-3">No Logo</div>
                                <?php endif; ?>
                                <input type="file" name="clinics_logo" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Clinic Name (ပြင်ဆင်၍မရပါ)</label>
                                    <input type="text" name="clinics_name" class="form-control" value="<?php echo htmlspecialchars($clinic['clinics_name']); ?>" readonly>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" name="clinics_email" class="form-control" value="<?php echo htmlspecialchars($clinic['clinics_email']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Phone</label>
                                        <input type="text" name="clinics_phone" class="form-control" value="<?php echo htmlspecialchars($clinic['clinics_phone']); ?>" required>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label fw-bold">New Password</label>
                                        <input type="password" name="new_password" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="clinics_address" class="form-control" rows="2" required><?php echo htmlspecialchars($clinic['clinics_address']); ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Clinic Description (အကျဉ်း)</label>
                            <textarea name="clinics_description" class="form-control" rows="4"><?php echo htmlspecialchars($clinic['clinics_description']); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="clinics_admindashboard.php" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> Back</a>
                            <button type="submit" name="update_clinic" class="btn btn-primary px-5">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>