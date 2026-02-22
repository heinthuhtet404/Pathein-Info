<?php
session_start();
include('db.php');
include('SuperAdminHeader.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$result = mysqli_query($db, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($result);

// Handle Update
if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

    // Check email uniqueness
    $check = mysqli_query($db, "SELECT user_id FROM users WHERE email='$email' AND user_id != $user_id");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already taken');</script>";
    } else {

        // Optional: Password change
        $password = '';
        if(!empty($_POST['password'])){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "UPDATE users SET name='$name', email='$email', phone='$phone', password='$password' WHERE user_id=$user_id";
        } else {
            $query = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE user_id=$user_id";
        }

        if(mysqli_query($db, $query)){
    echo "<script>
        alert('Profile updated successfully');
        window.location.href = window.location.href; // page reload လုပ်တာနည်းလမ်း safer
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

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0">👤 My Profile</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']); ?>">
                            </div>

                            <!-- Password Field with Eye Toggle -->
                            <div class="mb-3">
    <label class="form-label fw-semibold">
        Password <small class="text-muted">(Leave blank to keep current)</small>
    </label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
        <span class="input-group-text bg-white" style="cursor:pointer;" onclick="togglePassword()">
            <i id="eyeIcon" class="bi bi-eye-slash"></i>
        </span>
    </div>
</div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" name="update" class="btn btn-primary btn-lg rounded-3">
                                    💾 Update Profile
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        }
    }
    </script>
</body>
</html>