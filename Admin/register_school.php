<?php
session_start();
include('db.php');
include('SuperAdminHeader.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Save school
if (isset($_POST['save'])) {
    $name = mysqli_real_escape_string($db,$_POST['name']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $ownership = $_POST['ownership'];
    $type = $_POST['type'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $academic_type = $_POST['academic_type'];

    if ( empty(trim($name)) || empty(trim($email)) || empty(trim($address)) || empty(trim($phone)) || empty(trim($description))) {
        echo "<script>alert('All fields are required');</script>";
    } else {
        $check = "SELECT school_id FROM schools WHERE email='$email'";
        $result = mysqli_query($db, $check);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('School already exists');</script>";
        } else {
            $logo = "";
            if (!empty($_FILES['logo']['name'])) {
                $logo = time() . "_" . $_FILES['logo']['name'];
                move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/" . $logo);
            }

            $query = "INSERT INTO schools
            (user_id,name, email, ownership, type, address, phone, description, logo, status, academic_type)
            VALUES
            ('$user_id','$name', '$email', '$ownership', '$type', '$address', '$phone','$description','$logo', '$status', '$academic_type')";

            if (mysqli_query($db, $query)) {
                // Update user table
                mysqli_query($db, "UPDATE users SET is_registered = 1 WHERE user_id = $user_id");
                // Save school_id in session
                $_SESSION['school_id'] = mysqli_insert_id($db);
                header("Location: SchoolAdminDashboard.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($db) . "</div>";
            }
        }
    }
}
?>

<body>
    <?php include('SuperAdminSideBar.php'); ?>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div>
                <h3 class="fw-bold">🏫 Add New School</h3>
                <p class="text-muted mb-0">Fill in the school details</p>
            </div>
            <a href="superAdminDashboard.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top-4">
                <h4 class="mb-0">Add New School</h4>
            </div>
            <div class="card-body p-4">
                <form method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">School Name</label>
                        <input type="text" name="name" class="form-control form-control-lg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Academic Type</label>
                        <input type="text" name="academic_type" value="school" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Ownership</label>
                            <select name="ownership" class="form-select">
                                <option value="government">Government</option>
                                <option value="private">Private</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">School Type</label>
                            <select name="type" class="form-select">
                                <option value="primary">Primary</option>
                                <option value="middle">Middle</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="save" class="btn btn-primary btn-lg rounded-3">
                            💾 Save School
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>