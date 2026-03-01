<?php
session_start();
include('db.php');

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

if (!$user) {
    die("User not found.");
}

include('SuperAdminHeader.php');

/* ================= PHOTO PATH ================= */
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$photo_path = (!empty($user['photo']) && file_exists($upload_dir . $user['photo']))
    ? $upload_dir . $user['photo']
    : "https://via.placeholder.com/200x200?text=No+Photo";


/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Email unique check
    $checkStmt = mysqli_prepare($db,
        "SELECT user_id FROM users WHERE email = ? AND user_id != ?");
    mysqli_stmt_bind_param($checkStmt, "si", $email, $user_id);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        echo "<script>alert('Email already taken');</script>";
    } else {

        $query = "UPDATE users SET name=?, email=?, phone=?";
        $params = [$name, $email, $phone];
        $types = "sss";

        /* ===== PASSWORD UPDATE ===== */
if (
    !empty($_POST['old_password']) &&
    !empty($_POST['new_password']) &&
    !empty($_POST['confirm_password'])
) {

   $old_password     = trim($_POST['old_password']);
$new_password     = trim($_POST['new_password']);
$confirm_password = trim($_POST['confirm_password']);

    // 1️⃣ Old password verify
    if (!password_verify($old_password, $user['password'])) {
        echo "<script>alert('Old password incorrect');</script>";
        exit;
    }

    // 2️⃣ Confirm match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match');</script>";
        exit;
    }

    // 3️⃣ Prevent same password reuse (optional but recommended)
    if (password_verify($new_password, $user['password'])) {
        echo "<script>alert('New password cannot be same as old password');</script>";
        exit;
    }

    // 4️⃣ Hash new password
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);

    $query .= ", password=?";
    $params[] = $hashed;
    $types .= "s";
}
elseif (
    !empty($_POST['old_password']) ||
    !empty($_POST['new_password']) ||
    !empty($_POST['confirm_password'])
) {
    // If user filled some but not all
    echo "<script>alert('Please fill all password fields to change password');</script>";
    exit;
}

        /* ===== PHOTO UPDATE ===== */
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
            echo "<script>
                alert('Profile updated successfully');
                window.location.href = window.location.href;
            </script>";
            exit;
        } else {
            echo "Update Error: " . mysqli_error($db);
        }
    }
}
?>

<body>

<?php include('SuperAdminSideBar.php'); ?>

<div class="container py-5" style="max-width: 900px;">
<div class="card shadow-lg rounded-4 border-0 overflow-hidden">

<form method="post" enctype="multipart/form-data">

<div class="row g-0">

<!-- ================= LEFT SIDE ================= -->
<div class="col-md-4 bg-light text-center p-4 d-flex flex-column justify-content-center">

<div class="position-relative mx-auto mb-3" style="width:200px;height:200px;">

<img id="previewImage"
     src="<?= htmlspecialchars($photo_path); ?>"
     class="rounded-circle shadow"
     style="width:200px;height:200px;object-fit:cover;">

<label for="profile_photo"
       class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-3 shadow"
       style="cursor:pointer;">
    <i class="bi bi-camera-fill"></i>
</label>

<input type="file"
       id="profile_photo"
       name="profile_photo"
       accept="image/*"
       class="d-none"
       onchange="previewImage(event)">

</div>

<h5 class="fw-bold"><?= htmlspecialchars($user['name']); ?></h5>
<p class="text-muted mb-0">Super Admin</p>

</div>

<!-- ================= RIGHT SIDE ================= -->
<div class="col-md-8 p-5">

<div class="row g-3">

<!-- NAME -->
<div class="col-12">
<label class="form-label fw-semibold">Name</label>
<input type="text" name="name"
       class="form-control form-control-lg rounded-3"
       value="<?= htmlspecialchars($user['name']); ?>" required>
</div>

<!-- EMAIL -->
<div class="col-12">
<label class="form-label fw-semibold">Email</label>
<input type="email" name="email"
       class="form-control form-control-lg rounded-3"
       value="<?= htmlspecialchars($user['email']); ?>" required>
</div>

<!-- PHONE -->
<div class="col-12">
<label class="form-label fw-semibold">Phone</label>
<input type="text" name="phone"
       class="form-control form-control-lg rounded-3"
       value="<?= htmlspecialchars($user['phone']); ?>">
</div>

<hr class="my-4">

<h6 class="fw-bold text-primary">Change Password</h6>

<!-- OLD PASSWORD -->
<div class="col-12">
<label class="form-label fw-semibold">Old Password</label>
<input type="password" name="old_password"
       class="form-control form-control-lg rounded-3"
       placeholder="Enter old password to change"
        autocomplete="new-password" required>
</div>

<!-- NEW PASSWORD -->
<div class="col-12">
<label class="form-label fw-semibold">New Password</label>
<div class="input-group">
<input type="password" name="new_password"
       id="new_password"
       class="form-control form-control-lg rounded-start-3" required>
<button type="button"
        class="btn btn-light border rounded-end-3"
        onclick="togglePassword('new_password','eye1')">
<i id="eye1" class="bi bi-eye-slash"></i>
</button>
</div>
</div>

<!-- CONFIRM PASSWORD -->
<div class="col-12">
<label class="form-label fw-semibold">Confirm New Password</label>
<div class="input-group">
<input type="password" name="confirm_password"
       id="confirm_password"
       class="form-control form-control-lg rounded-start-3" required>
<button type="button"
        class="btn btn-light border rounded-end-3"
        onclick="togglePassword('confirm_password','eye2')">
<i id="eye2" class="bi bi-eye-slash"></i>
</button>
</div>
</div>

<!-- SUBMIT -->
<div class="col-12 mt-4">
<button type="submit"
        name="update"
        class="btn btn-primary btn-lg w-100 rounded-3">
 Update Profile
</button>
</div>

</div>
</div>

</div>
</form>
</div>
</div>

<!-- ================= STYLE ================= -->
<style>
body { background:#f4f6fb; }

.btn-primary {
    background:#5a4de6;
    border:none;
}

.btn-primary:hover {
    background:#7b6eff;
}

input:focus {
    box-shadow:0 0 0 .2rem rgba(90,77,230,.25);
}

hr {
    opacity: 0.1;
}
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function togglePassword(fieldId, iconId){
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);

    if(input.type === "password"){
        input.type = "text";
        icon.classList.replace("bi-eye-slash","bi-eye");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye","bi-eye-slash");
    }
}

function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById("previewImage").src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>