<?php 
session_start();
include("db.php");

if (isset($_POST['login'])) {

    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('All fields are required');</script>";
        exit;
    }

    $email = mysqli_real_escape_string($db, $email);

    $query = "SELECT * FROM users WHERE email='$email' AND status='Accept' LIMIT 1";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // ✅ Password Verify (Superadmin + All Users)
        if (password_verify($password, $row['password'])) {

            // Store Common Session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email']   = $row['email'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['category_id'] = $row['category_id'];

            // ==============================
            // ✅ SUPER ADMIN
            // ==============================
            if ($row['role_id'] == 3) {
                header("Location: SuperAdminDashboard.php");
                exit;
            }

            // ==============================
            // ✅ GET EXTRA IDS (Optional)
            // ==============================

            $user_id = (int)$row['user_id'];

            // School
            $schoolQuery = mysqli_query($db, 
                "SELECT school_id FROM schools WHERE user_id = $user_id");
            if($schoolQuery && mysqli_num_rows($schoolQuery) > 0){
                $schoolData = mysqli_fetch_assoc($schoolQuery);
                $_SESSION['school_id'] = $schoolData['school_id'];
            }

            // Hotel
            $hotelQuery = mysqli_query($db, 
                "SELECT hotel_id FROM hotels WHERE user_id = $user_id");
            if($hotelQuery && mysqli_num_rows($hotelQuery) > 0){
                $hotelData = mysqli_fetch_assoc($hotelQuery);
                $_SESSION['hotel_id'] = $hotelData['hotel_id'];
            }

            // Clinic
            $clinicQuery = mysqli_query($db, 
                "SELECT clinic_id FROM clinics WHERE user_id = $user_id");
            if($clinicQuery && mysqli_num_rows($clinicQuery) > 0){
                $clinicData = mysqli_fetch_assoc($clinicQuery);
                $_SESSION['clinic_id'] = $clinicData['clinic_id'];
            }

            // Bus Line
            $busQuery = mysqli_query($db, 
                "SELECT busline_id FROM bus_line WHERE user_id = $user_id");
            if($busQuery && mysqli_num_rows($busQuery) > 0){
                $busData = mysqli_fetch_assoc($busQuery);
                $_SESSION['busline_id'] = $busData['busline_id'];
            }

            // ==============================
            // ✅ CATEGORY ADMIN (role_id = 1)
            // ==============================

            if ($row['role_id'] == 1) {

                // Product Admin Special Case
                if ($row['category_id'] == 5) {
                    header("Location: productAdminDashboard.php");
                    exit;
                }

                if ($row['is_registered'] == 1) {

                    switch ($row['category_id']) {

                        case 1:
                            header("Location: SchoolAdminDashboard.php");
                            break;

                        case 2:
                            header("Location: healthAdminDashboard.php");
                            break;

                        case 3:
                            header("Location: BusAdminDashboard.php");
                            break;

                        case 4:
                            header("Location: hotelAdminDashboard.php");
                            break;

                        default:
                            echo "<script>alert('Invalid category');</script>";
                            break;
                    }

                } else {

                    switch ($row['category_id']) {

                        case 1:
                            header("Location: register_school.php");
                            break;

                        case 2:
                            header("Location: register_health.php");
                            break;

                        case 3:
                            header("Location: register_bus.php");
                            break;

                        case 4:
                            header("Location: register_hotel.php");
                            break;

                        default:
                            echo "<script>alert('Invalid category');</script>";
                            break;
                    }
                }

                exit;
            }

        } else {
            echo "<script>alert('Incorrect Password');</script>";
        }

    } else {
        echo "<script>alert('User not found or not approved');</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow">
                    <div class="card-header text-center fw-bold">
                        Login
                    </div>

                    <div class="card-body">
                        <form method="POST">

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-primary">
                                    Login
                                </button>
                            </div>

                        </form>
                        <div class="text-center mt-3">
                            <p>
                                If you don't have an account,
                                <a href="register.php" class="fw-bold text-decoration-none">
                                    please register
                                </a>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>