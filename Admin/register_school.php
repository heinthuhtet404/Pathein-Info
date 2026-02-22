<?php

session_start();
include('adminHeader.php');

include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['save'])) {

    // ✅ Get user_id from session (Login user)
    // $user_id = $_SESSION['user_id'];

    $name = mysqli_real_escape_string($db,$_POST['name']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $ownership = $_POST['ownership'];
    $type = $_POST['type'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $total_teachers = $_POST['total_teachers'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $academic_type = $_POST['academic_type'];

    if ( empty(trim($name)) ||
         empty(trim($email)) ||
         empty(trim($address)) ||
         empty(trim($phone)) ||
         empty(trim($description))) {

        echo "<script>alert('All fields are required');</script>";
    }
    else{

        $check = "SELECT school_id FROM schools WHERE email='$email'";
        $result = mysqli_query($db, $check);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('School already exists');</script>";
        }
        else {

            $logo = "";
            if (!empty($_FILES['logo']['name'])) {
                $logo = time() . "_" . $_FILES['logo']['name'];
                move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/" . $logo);
            }
            
//  echo "Session User ID: " . $_SESSION['user_id'];

// exit;

            $query = "INSERT INTO schools
            (user_id,name, email, ownership, type, address, phone,  description, logo, status, academic_type)
            VALUES
            ('$user_id','$name', '$email', '$ownership', '$type', '$address', '$phone',
              '$description','$logo', '$status', '$academic_type')";

            if (mysqli_query($db, $query)) {


                // ✅ Update user table
                mysqli_query($db, "UPDATE users SET is_registered = 1 WHERE user_id = $user_id");

           
                // ✅ Get inserted school_id
                 $school_id = mysqli_insert_id($db);



                // ✅ Save school_id in session
                $_SESSION['school_id'] = $school_id;


                header("Location: SchoolAdminDashboard.php");
                exit;

            } else {
                echo "Error: " . mysqli_error($db);
            }
        }
    }
}
?>


<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0">🏫 Add New School</h4>
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

                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>

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

                                <!-- <a href="edit_school.php" class="btn btn-outline-secondary rounded-3">
                                    ✏️ Update School
                                </a> -->
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>