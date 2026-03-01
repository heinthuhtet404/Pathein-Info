<?php
session_start();
include('db.php');
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Super Admin authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

/* ================= FETCH USER ================= */
$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
if (!$user) die("User not found.");

include('SuperAdminHeader.php');

/* ================= PHOTO PATH ================= */
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
$photo_path = (!empty($user['photo']) && file_exists($upload_dir . $user['photo']))
    ? $upload_dir . $user['photo']
    : "https://via.placeholder.com/200x200?text=No+Photo";

/* ================= PROFILE UPDATE ================= */
if (isset($_POST['update_profile'])) {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $checkStmt = mysqli_prepare($db, "SELECT user_id FROM users WHERE email = ? AND user_id != ?");
    mysqli_stmt_bind_param($checkStmt, "si", $email, $user_id);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        echo "<script>alert('Email already taken');</script>";
    } else {
        $query = "UPDATE users SET name=?, email=?, phone=?";
        $params = [$name, $email, $phone];
        $types = "sss";

        // Photo update
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
            $allowed_ext = ['jpg','jpeg','png','webp'];
            $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['profile_photo']['tmp_name']);
            finfo_close($finfo);

            $allowed_mime = ['image/jpeg','image/png','image/webp'];

            if (in_array($ext, $allowed_ext) && in_array($mime, $allowed_mime)) {
                $new_name = "user_" . $user_id . "_" . time() . "." . $ext;
                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_dir . $new_name)) {
                    if (!empty($user['photo']) && file_exists($upload_dir . $user['photo'])) {
                        unlink($upload_dir . $user['photo']);
                    }
                    $query .= ", photo=?";
                    $params[] = $new_name;
                    $types .= "s";
                }
            } else {
                echo "<script>alert('Invalid image type');</script>";
                exit;
            }
        }

        $query .= " WHERE user_id=?";
        $params[] = $user_id;
        $types .= "i";

        $updateStmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($updateStmt, $types, ...$params);

        if (mysqli_stmt_execute($updateStmt)) {
            echo "<script>alert('Profile updated successfully'); window.location.href=window.location.href;</script>";
            exit;
        } else {
            echo "Update Error: " . mysqli_error($db);
        }
    }
}

/* ================= AJAX OTP REQUEST ================= */
if (isset($_POST['ajax_request_otp'])) {
    $old_password     = trim($_POST['old_password']);
    $new_password     = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $message = '';

    if (!password_verify($old_password, $user['password'])) {
        $message = 'Old password is incorrect';
    } elseif ($new_password !== $confirm_password) {
        $message = 'New passwords do not match';
    } elseif (password_verify($new_password, $user['password'])) {
        $message = 'New password cannot be same as old password';
    } else {
        $otp = random_int(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expire'] = time() + 300; // 5 mins
        $_SESSION['new_password'] = password_hash($new_password, PASSWORD_DEFAULT);

        // Send OTP Email (PHPMailer)
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'heinthuhtet2004@gmail.com';
            $mail->Password   = 'djtepvqfoxsudsyc';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom('heinthuhtet2004@gmail.com', 'Admin');
            $mail->addAddress($user['email'], $user['name']);
            $mail->isHTML(true);
            $mail->Subject = 'Password Change OTP';
            $mail->Body    = "Hello {$user['name']},<br><br>Your OTP is: <strong>$otp</strong>. It expires in 5 minutes.";

            $mail->send();
            $message = 'OTP sent to your email.';
        } catch (Exception $e) {
            $message = "OTP could not be sent. Error: {$mail->ErrorInfo}";
        }
    }

    echo $message;
    exit; // important for AJAX
}

/* ================= VERIFY OTP & UPDATE PASSWORD ================= */
if (isset($_POST['verify_otp'])) {
    $input_otp = trim($_POST['otp']);

    if (!isset($_SESSION['otp']) || time() > $_SESSION['otp_expire']) {
        echo "<script>alert('OTP expired. Please request again.');</script>";
        unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['new_password']);
    } elseif ($input_otp != $_SESSION['otp']) {
        echo "<script>alert('Invalid OTP.');</script>";
    } else {
        // OTP valid -> update password
        $stmt = mysqli_prepare($db, "UPDATE users SET password=? WHERE user_id=?");
        mysqli_stmt_bind_param($stmt, "si", $_SESSION['new_password'], $user_id);
        if (mysqli_stmt_execute($stmt)) {
            unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['new_password']);
            echo "<script>alert('Password changed successfully'); window.location.href=window.location.href;</script>";
            exit;
        } else {
            echo "Password Update Error: " . mysqli_error($db);
        }
    }
}
?>

<body>
<?php include('SuperAdminSideBar.php'); ?>

<div class="container py-5" style="max-width: 900px;">
<div class="card shadow-lg rounded-4 border-0 overflow-hidden">
<div class="row g-0">

<!-- LEFT SIDE -->
<div class="col-md-4 bg-light text-center p-4 d-flex flex-column justify-content-center">
    <div class="position-relative mx-auto mb-3" style="width:200px;height:200px;">
        <img id="previewImage" src="<?= htmlspecialchars($photo_path); ?>" class="rounded-circle shadow" style="width:200px;height:200px;object-fit:cover;">
        <label for="profile_photo" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-3 shadow" style="cursor:pointer;">
            <i class="bi bi-camera-fill"></i>
        </label>
    </div>
    <h5 class="fw-bold"><?= htmlspecialchars($user['name']); ?></h5>
    <p class="text-muted mb-0">Super Admin</p>
</div>

<!-- RIGHT SIDE -->
<div class="col-md-8 p-5">

    <!-- PROFILE FORM -->
    <form method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" class="form-control form-control-lg rounded-3" value="<?= htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control form-control-lg rounded-3" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" class="form-control form-control-lg rounded-3" value="<?= htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="col-12 mt-3">
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="d-none" onchange="previewImage(event)">
                <button type="submit" name="update_profile" class="btn btn-primary w-100">Update Profile</button>
            </div>
        </div>
    </form>

    <hr class="my-4">

    <!-- PASSWORD CHANGE REQUEST FORM -->
    <form id="passwordForm">
        <h6 class="fw-bold text-primary">Change Password (OTP Required)</h6>
        <div class="col-12 mb-3">
            <label class="form-label fw-semibold">Old Password</label>
            <input type="password" name="old_password" class="form-control form-control-lg rounded-3" required>
        </div>
        <div class="col-12 mb-3">
            <label class="form-label fw-semibold">New Password</label>
            <input type="password" name="new_password" class="form-control form-control-lg rounded-3" required>
        </div>
        <div class="col-12 mb-3">
            <label class="form-label fw-semibold">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control form-control-lg rounded-3" required>
        </div>
        <div class="col-12 mt-3">
            <button type="button" id="requestOtpBtn" class="btn btn-primary w-100">Request OTP</button>
        </div>
        <div class="col-12 mt-2">
            <div id="otpMessage" class="text-success fw-semibold"></div>
        </div>
    </form>

    <!-- VERIFY OTP FORM -->
    <form method="post" class="mt-3">
        <div class="col-12 mb-3">
            <label class="form-label fw-semibold">Enter OTP</label>
            <input type="text" name="otp" class="form-control form-control-lg rounded-3" required>
        </div>
        <div class="col-12 mt-3">
            <button type="submit" name="verify_otp" class="btn btn-success w-100">Verify OTP & Update Password</button>
        </div>
    </form>

</div>
</div>
</div>
</div>

<style>
body { background:#f4f6fb; }
.btn-primary { background:#5a4de6; border:none; }
.btn-primary:hover { background:#7b6eff; }
.btn-success { background:#28a745; border:none; }
.btn-success:hover { background:#45c45d; }
input:focus { box-shadow:0 0 0 .2rem rgba(90,77,230,.25); }
hr { opacity: 0.1; }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){ document.getElementById("previewImage").src = reader.result; }
    reader.readAsDataURL(event.target.files[0]);
}

// AJAX OTP Request
document.getElementById('requestOtpBtn').addEventListener('click', function(){
    const form = document.getElementById('passwordForm');
    const data = new URLSearchParams();
    data.append('ajax_request_otp', '1');
    data.append('old_password', form.old_password.value);
    data.append('new_password', form.new_password.value);
    data.append('confirm_password', form.confirm_password.value);

    fetch(window.location.href, { method:'POST', body: data })
        .then(response => response.text())
        .then(msg => { 
            document.getElementById('otpMessage').innerHTML = msg; 
        })
        .catch(err => { 
            document.getElementById('otpMessage').innerHTML = "Something went wrong!"; 
            console.error(err); 
        });
});
</script>

</body>
</html>