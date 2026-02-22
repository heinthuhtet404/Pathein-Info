<?php 
session_start();
include("db.php");



if (isset($_POST['login'])) {
$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];




if (empty($email) || empty($password)) {
echo "<script>
alert('All fields are required');
</script>";
exit;
}

$email = mysqli_real_escape_string($db, $email);

$query = "SELECT * FROM users WHERE email='$email' AND status='Accept' LIMIT 1";
$result = mysqli_query($db, $query);
if ($result && mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {


        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email']   = $row['email'];
        $_SESSION['role_id'] = $row['role_id'];
        $_SESSION['category_id'] = $row['category_id'];

 // ✅ Get school_id and store in session
    $schoolQuery = mysqli_query($db, 
        "SELECT school_id FROM schools WHERE user_id = {$row['user_id']}");

    if(mysqli_num_rows($schoolQuery) > 0){
        $schoolData = mysqli_fetch_assoc($schoolQuery);
        $_SESSION['school_id'] = $schoolData['school_id'];
    }


          // ✅ Super Admin
        if ($row['role_id'] == 3) {
            $_SESSION['role_id'] = 3;
            header("Location: SuperAdminDashboard.php");
            exit;
        }




        // ✅ Category Admin
        if ($row['role_id'] == 1) {

            // Already Registered
            if ($row['is_registered'] == 1) {

                switch ($row['category_id']) {

                    case 1:
                        header("Location: SchoolAdminDashboard.php");
                        exit;

                    case 2:
                        header("Location: healthAdminDashboard.php");
                        exit;

                    case 3:
                        header("Location: transportAdminDashboard.php");
                        exit;

                    case 4:
                        header("Location: hotelAdminDashboard.php");
                        exit;

                    case 5:
                        header("Location: productAdminDashboard.php");
                        exit;

                    case 6:
                        header("Location: tourismAdminDashboard.php");
                        exit;
                }

            }
            // ❌ Not Registered Yet
            else {

                switch ($row['category_id']) {

                    case 1:
                        header("Location: register_school.php");
                        exit;

                    case 2:
                        header("Location: register_health.php");
                        exit;

                    case 3:
                        header("Location: register_transport.php");
                        exit;

                    case 4:
                        header("Location: register_hotel.php");
                        exit;

                    case 5:
                        header("Location: register_product.php");
                        exit;

                    case 6:
                        header("Location: register_tourism.php");
                        exit;
                }
            }
         


        }
         
    }
      
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