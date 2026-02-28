<?php
session_start();
include('db.php');
include('SuperAdminHeader.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user
$result = mysqli_query($db, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($result);

// Photo path
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$photo_path = (!empty($user['photo']) && file_exists($upload_dir.$user['photo']))
    ? $upload_dir.$user['photo']
    : "https://via.placeholder.com/200x200?text=No+Photo";


// ================= UPDATE =================
if (isset($_POST['update'])) {

    $name  = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

    // Email unique check
    $check = mysqli_query($db, "SELECT user_id FROM users WHERE email='$email' AND user_id != $user_id");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already taken');</script>";
    } else {

        $query = "UPDATE users SET name='$name', email='$email', phone='$phone'";

        // Password update
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query .= ", password='$password'";
        }

        // Photo update
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {

            $allowed = ['jpg','jpeg','png','webp'];
            $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {

                $new_name = "user_".$user_id."_".time().".".$ext;

                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $upload_dir.$new_name)) {

                    // delete old photo
                    if (!empty($user['photo']) && file_exists($upload_dir.$user['photo'])) {
                        unlink($upload_dir.$user['photo']);
                    }

                    $query .= ", photo='$new_name'";
                }
            } else {
                echo "<script>alert('Only JPG, PNG, WEBP allowed');</script>";
            }
        }

        $query .= " WHERE user_id=$user_id";

        if (mysqli_query($db, $query)) {
            echo "<script>
                alert('Profile updated successfully');
                window.location.href = window.location.href;
            </script>";
            exit;
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }
}
?>

<body>
<?php include('SuperAdminSideBar.php'); ?>

<div class="container py-5" style="max-width: 850px;">
<div class="card shadow-lg rounded-4 border-0 overflow-hidden">

<form method="post" enctype="multipart/form-data">

<div class="row g-0">

<!-- LEFT SIDE -->
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


<!-- RIGHT SIDE -->
<div class="col-md-8 p-5">

<div class="row g-3">

<div class="col-12">
<label class="form-label fw-semibold">Name</label>
<input type="text" name="name"
       class="form-control form-control-lg rounded-3"
       value="<?= htmlspecialchars($user['name']); ?>" required>
</div>

<div class="col-12">
<label class="form-label fw-semibold">Email</label>
<input type="email" name="email"
       class="form-control form-control-lg rounded-3"
       value="<?= htmlspecialchars($user['email']); ?>" required>
</div>

<div class="col-12">
<label class="form-label fw-semibold">Phone</label>
<input type="text" name="phone"
       class="form-control form-control-lg rounded-3"
       value="<?= htmlspecialchars($user['phone']); ?>">
</div>

<div class="col-12">
<label class="form-label fw-semibold">
Password <small class="text-muted">(Leave blank to keep current)</small>
</label>
<div class="input-group">
<input type="password" name="password"
       id="password"
       class="form-control form-control-lg rounded-start-3">
<button type="button"
        class="btn btn-light border rounded-end-3"
        onclick="togglePassword()">
<i id="eyeIcon" class="bi bi-eye-slash"></i>
</button>
</div>
</div>

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

<!-- STYLE -->
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
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function togglePassword(){
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");
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