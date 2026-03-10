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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Super Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body style="background: #f4f7fb;">

<?php include('SuperAdminSideBar.php'); ?>

<!-- Main Content Wrapper -->
<div class="main-content">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
        <div class="container-fluid p-0">
            <div class="d-flex align-items-center gap-3">
                <!-- Modern Hamburger Toggle Button -->
                <button class="hamburger-btn" onclick="toggleSidebar()" id="toggleBtn">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <!-- Page Title -->
                <span class="page-title d-none d-md-block fw-semibold text-secondary">
                    My Profile
                </span>
            </div>

            <!-- Right Side Navbar Items -->
            <div class="ms-auto d-flex align-items-center gap-3">
                <!-- Notification Icon -->
                <!-- <div class="notification-wrapper position-relative">
                    <i class="fa-solid fa-bell fs-5 text-secondary"></i>
                    <span class="notification-badge"></span>
                </div> -->

                <!-- User Dropdown -->
                <div class="dropdown">
                    <a class="text-dark d-flex align-items-center text-decoration-none dropdown-toggle" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-info text-end me-2 d-none d-md-block">
                            <div class="fw-semibold small"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                            <small class="text-muted">Super Admin</small>
                        </div>
                        <?php if(isset($_SESSION['profile_image']) && $_SESSION['profile_image'] != '') { ?>
                            <img src="<?= $_SESSION['profile_image'] ?>" alt="avatar" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                        <?php } else { ?>
                            <div class="user-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px; font-weight: bold;">
                                <?= strtoupper(substr($_SESSION['email'] ?? 'A', 0, 1)) ?>
                            </div>
                        <?php } ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="profile.php">
                                <i class="fa-solid fa-user me-2 text-primary"></i> Profile
                            </a>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="settings.php">
                                <i class="fa-solid fa-gear me-2 text-secondary"></i> Settings
                            </a>
                        </li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center text-danger" href="login.php">
                                <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container-fluid px-4 py-4">
        <!-- Modern Header with Gradient -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-header p-4 rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="fa-solid fa-user-shield fs-1 text-white"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold text-white mb-1">My Profile</h2>
                                <p class="text-white-50 mb-0">Manage your personal information and security settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="row">
            <div class="col-12">
                <div class="profile-main-card bg-white rounded-4 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        <!-- LEFT SIDE - Profile Photo -->
                        <div class="col-md-4 profile-left p-5 text-center">
                            <div class="profile-photo-wrapper mb-4">
                                <div class="position-relative d-inline-block">
                                    <img id="previewImage" src="<?= htmlspecialchars($photo_path); ?>" 
                                         class="profile-photo rounded-4 shadow" 
                                         style="width: 200px; height: 200px; object-fit: cover; border: 4px solid white;">
                                    <label for="profile_photo" class="photo-upload-label">
                                        <i class="fa-solid fa-camera"></i>
                                    </label>
                                </div>
                            </div>
                            <h4 class="fw-bold mb-1"><?= htmlspecialchars($user['name']); ?></h4>
                            <p class="text-muted mb-3">
                                <i class="fa-solid fa-crown me-1" style="color: #FFD700;"></i>
                                Super Administrator
                            </p>
                            <div class="user-stats mt-4 pt-4 border-top">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="stat-item">
                                            <i class="fa-solid fa-calendar text-primary mb-2"></i>
                                            <small class="d-block text-muted">Member Since</small>
                                            <strong><?= date('M Y', strtotime($user['created_at'] ?? 'now')); ?></strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-item">
                                            <i class="fa-solid fa-clock text-success mb-2"></i>
                                            <small class="d-block text-muted">Last Active</small>
                                            <strong>Today</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT SIDE - Profile Forms -->
                        <div class="col-md-8 profile-right p-5">
                            <!-- Profile Update Form -->
                            <form method="post" enctype="multipart/form-data" class="profile-form">
                                <h5 class="fw-bold mb-4">
                                    <i class="fa-solid fa-user-edit me-2 text-primary"></i>
                                    Personal Information
                                </h5>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-user text-muted"></i>
                                            </span>
                                            <input type="text" name="name" class="form-control border-start-0" 
                                                   value="<?= htmlspecialchars($user['name']); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-envelope text-muted"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control border-start-0" 
                                                   value="<?= htmlspecialchars($user['email']); ?>" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-phone text-muted"></i>
                                            </span>
                                            <input type="text" name="phone" class="form-control border-start-0" 
                                                   value="<?= htmlspecialchars($user['phone']); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="d-none" onchange="previewImage(event)">
                                        <button type="submit" name="update_profile" class="btn btn-primary w-100 py-3">
                                            <i class="fa-solid fa-save me-2"></i>Update Profile
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-5">

                            <!-- Password Change Form -->
                            <h5 class="fw-bold mb-4">
                                <i class="fa-solid fa-lock me-2 text-primary"></i>
                                Security Settings
                            </h5>

                            <!-- OTP Request Form -->
                            <form id="passwordForm" class="password-form mb-4">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Current Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-key text-muted"></i>
                                            </span>
                                            <input type="password" name="old_password" class="form-control border-start-0" 
                                                   placeholder="Enter current password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-lock text-muted"></i>
                                            </span>
                                            <input type="password" name="new_password" class="form-control border-start-0" 
                                                   placeholder="Enter new password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-lock text-muted"></i>
                                            </span>
                                            <input type="password" name="confirm_password" class="form-control border-start-0" 
                                                   placeholder="Confirm new password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="button" id="requestOtpBtn" class="btn btn-outline-primary w-100 py-3">
                                            <i class="fa-solid fa-paper-plane me-2"></i>Request OTP
                                        </button>
                                        <div id="otpMessage" class="alert alert-info mt-3 d-none"></div>
                                    </div>
                                </div>
                            </form>

                            <!-- OTP Verification Form -->
                            <form method="post" class="otp-verify-form">
                                <div class="row g-4">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Enter OTP Code</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-shield text-muted"></i>
                                            </span>
                                            <input type="text" name="otp" class="form-control border-start-0" 
                                                   placeholder="6-digit OTP" maxlength="6" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" name="verify_otp" class="btn btn-success w-100 py-3">
                                            <i class="fa-solid fa-check-circle me-2"></i>Verify
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Security Tips -->
                            <div class="security-tips mt-5 p-4 bg-light rounded-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <i class="fa-solid fa-shield-halved fa-2x text-primary"></i>
                                    <h6 class="fw-bold mb-0">Security Tips</h6>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i> Use at least 8 characters with mix of letters, numbers & symbols</li>
                                    <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i> Don't reuse passwords from other websites</li>
                                    <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i> Change your password regularly</li>
                                    <li><i class="fa-solid fa-circle-check text-success me-2"></i> Never share your OTP with anyone</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Content Styles */
.main-content {
    margin-left: 280px;
    min-height: 100vh;
    background: #f4f7fb;
    transition: margin-left 0.3s ease-in-out;
}

.main-content.full {
    margin-left: 0;
}

/* Modern Header Gradient */
.modern-header {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    position: relative;
    overflow: hidden;
}

.modern-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 30s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

/* Profile Main Card */
.profile-main-card {
    border: 1px solid rgba(0,0,0,0.05);
}

/* Profile Left Side */
.profile-left {
    background: linear-gradient(145deg, #f8fafd 0%, #ffffff 100%);
    border-right: 1px solid rgba(0,0,0,0.05);
}

.profile-photo-wrapper {
    position: relative;
    display: inline-block;
}

.photo-upload-label {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(65, 88, 208, 0.3);
}

.photo-upload-label:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 15px rgba(65, 88, 208, 0.4);
}

.stat-item {
    padding: 15px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.02);
}

/* Profile Right Side */
.profile-right {
    background: white;
}

/* Form Styles */
.input-group {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
}

.input-group:focus-within {
    border-color: #C850C0;
    box-shadow: 0 0 0 3px rgba(200, 80, 192, 0.1);
}

.input-group-text {
    border: none;
    background: #f8f9fa;
}

.form-control {
    border: none;
    padding: 12px 15px;
    font-size: 0.95rem;
}

.form-control:focus {
    box-shadow: none;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(65, 88, 208, 0.4);
}

.btn-outline-primary {
    border: 2px solid #4158D0;
    color: #4158D0;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(65, 88, 208, 0.3);
}

.btn-success {
    background: #28a745;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: #34ce57;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(52, 206, 87, 0.3);
}

/* Alert Message */
.alert-info {
    background: linear-gradient(135deg, rgba(65, 88, 208, 0.05) 0%, rgba(200, 80, 192, 0.05) 100%);
    border: 1px solid rgba(65, 88, 208, 0.2);
    border-radius: 12px;
    color: #4158D0;
}

/* Security Tips */
.security-tips {
    border: 1px solid rgba(65, 88, 208, 0.1);
}

.security-tips i {
    font-size: 1rem;
}

/* Notification Badge */
.notification-wrapper {
    cursor: pointer;
    padding: 8px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.notification-wrapper:hover {
    background: #f0f2f5;
}

.notification-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 8px;
    height: 8px;
    background: #dc3545;
    border-radius: 50%;
    border: 2px solid white;
}

/* User Dropdown */
.dropdown-menu {
    border-radius: 15px;
    min-width: 220px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-item {
    border-radius: 10px;
    margin: 2px 5px;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, rgba(65, 88, 208, 0.05) 0%, rgba(200, 80, 192, 0.05) 100%);
    transform: translateX(5px);
}

/* Page Title */
.page-title {
    font-size: 1rem;
    background: #f0f2f5;
    padding: 6px 15px;
    border-radius: 30px;
}

/* Modern Hamburger Button */
.hamburger-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(65, 88, 208, 0.3);
}

.hamburger-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(65, 88, 208, 0.4);
}

.hamburger-line {
    width: 20px;
    height: 2px;
    background: white;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.hamburger-btn.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.hamburger-btn.active .hamburger-line:nth-child(2) {
    opacity: 0;
}

.hamburger-btn.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

/* User Avatar */
.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
    }
    
    .profile-left {
        border-right: none;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .profile-photo {
        width: 150px !important;
        height: 150px !important;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #3a4eb8 0%, #b048a8 100%);
}

/* Divider */
hr {
    opacity: 0.1;
    margin: 2rem 0;
}
</style>

<script>
// Preview image before upload
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){ 
        document.getElementById("previewImage").src = reader.result; 
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Toggle sidebar function
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const hamburger = document.getElementById('toggleBtn');

    sidebar.classList.toggle('hide');
    mainContent.classList.toggle('full');
    hamburger.classList.toggle('active');
}

// AJAX OTP Request
document.getElementById('requestOtpBtn').addEventListener('click', function(){
    const form = document.getElementById('passwordForm');
    const otpMessage = document.getElementById('otpMessage');
    
    // Validate form
    if(!form.old_password.value || !form.new_password.value || !form.confirm_password.value) {
        otpMessage.innerHTML = '<i class="fa-solid fa-exclamation-circle me-2"></i>Please fill in all password fields';
        otpMessage.className = 'alert alert-danger mt-3';
        otpMessage.classList.remove('d-none');
        return;
    }
    
    const data = new URLSearchParams();
    data.append('ajax_request_otp', '1');
    data.append('old_password', form.old_password.value);
    data.append('new_password', form.new_password.value);
    data.append('confirm_password', form.confirm_password.value);

    // Show loading
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Sending OTP...';
    this.disabled = true;

    fetch(window.location.href, { method:'POST', body: data })
        .then(response => response.text())
        .then(msg => { 
            otpMessage.innerHTML = '<i class="fa-solid fa-info-circle me-2"></i>' + msg;
            otpMessage.className = msg.includes('sent') ? 'alert alert-success mt-3' : 'alert alert-danger mt-3';
            otpMessage.classList.remove('d-none');
            
            // Reset button
            document.getElementById('requestOtpBtn').innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i>Request OTP';
            document.getElementById('requestOtpBtn').disabled = false;
        })
        .catch(err => { 
            otpMessage.innerHTML = '<i class="fa-solid fa-exclamation-triangle me-2"></i>Something went wrong!'; 
            otpMessage.className = 'alert alert-danger mt-3';
            otpMessage.classList.remove('d-none');
            
            // Reset button
            document.getElementById('requestOtpBtn').innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i>Request OTP';
            document.getElementById('requestOtpBtn').disabled = false;
            console.error(err); 
        });
});

// Auto close sidebar on mobile
function checkScreenSize() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const hamburger = document.getElementById('toggleBtn');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.add('hide');
        mainContent.classList.add('full');
        if(hamburger) hamburger.classList.add('active');
    } else {
        sidebar.classList.remove('hide');
        mainContent.classList.remove('full');
        if(hamburger) hamburger.classList.remove('active');
    }
}

// Check screen size on load and resize
window.addEventListener('load', checkScreenSize);
window.addEventListener('resize', checkScreenSize);

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>