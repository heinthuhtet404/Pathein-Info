<?php
include("db.php");

if (isset($_POST['submit'])) {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // ✅ Force Category Admin role = 1
    $role_id = 1;

    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : NULL;

    // 1️⃣ Required fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        echo "<script>alert('All required fields are required');</script>";
    }

    // 2️⃣ Email format
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    }

    // 3️⃣ Password match
    else if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match');</script>";
    }

    // 4️⃣ Strong password
    else if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/', $password)) {
        echo "<script>alert('Password must be strong (8 chars, upper, lower, number)');</script>";
    }

    else {

        $email = mysqli_real_escape_string($db, $email);

        // 5️⃣ Email duplicate check
        $check = mysqli_query($db, "SELECT user_id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('Email already exists');</script>";
        }
        else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // ✅ Correct NULL handling
            $category_value = ($category_id === NULL) ? "NULL" : $category_id;

            $query = "INSERT INTO users 
            (name, email, phone, password, role_id, category_id, status, created_at)
            VALUES 
            ('$name', '$email', '$phone', '$hashedPassword', $role_id, $category_value, 'Pending', NOW())";

            if (mysqli_query($db, $query)) {
                echo "<script>
                        alert('User registered successfully');
                        window.location.href='login.php';
                      </script>";
            } else {
                echo "<script>alert('Registration failed');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center fw-bold text-primary">
                        <h3> User Registration</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST">

                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password *</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password *</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>

                            <!-- <div class="mb-3">
                                <label class="form-label">Role *</label>
                                <select name="role" class="form-select" required>
                                    <option value="">-- Select Role --</option>

                                    <option value="user">User</option>
                                    <option value="SchoolAdmin">School Admin</option>
                                    <option value="HospitalAdmin">Hospital Admin</option>
                                    <option value="HotelAdmin">Hotel Admin</option>
                                    <option value="BusAdmin">Bus Admin</option>
                                    <option value="ProductAdmin">Product Admin</option>
                                </select>
                            </div> -->

                            <!-- Role Dropdown -->
                            <div class="mb-3">
                                <label class="form-label">Role *</label>
                                <input type="text" name="role_id" class="form-control" id="roleSelect"
                                    value="Categories Admin" readonly>

                            </div>


                            <!-- Category Dropdown -->
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" id="categorySelect">
                                    <option value="">-- Select Category --</option>
                                    <option value="1">School Admin</option>
                                    <option value="2">Health Admin</option>
                                    <option value="3">Transport Admin</option>
                                    <option value="4">Hotel Admin</option>
                                    <option value="5">Product Admin</option>
                                    <option value="6">Tourism Admin</option>
                                </select>
                            </div>




                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
<script>
document.addEventListener("DOMContentLoaded", function() {

    const roleSelect = document.getElementById("roleSelect");
    const categorySelect = document.getElementById("categorySelect");

    roleSelect.addEventListener("change", function() {

        if (this.value === "1") {
            categorySelect.disabled = false;
        } else {
            categorySelect.disabled = true;
            categorySelect.value = "";
        }

    });

});
</script>

</html>