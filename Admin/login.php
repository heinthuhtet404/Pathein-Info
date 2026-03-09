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
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>အက်ဒမင် ဝင်ရောက်ရန် | ပုသိမ်မြို့ ဝန်ဆောင်မှုပေါ်တယ်</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated Background Elements - Updated Colors */
        body::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        body::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .login-card {
            border-radius: 2rem;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(65, 88, 208, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(200, 80, 192, 0.3);
        }

        .login-header {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .login-subheader {
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #C850C0;
            box-shadow: 0 0 0 4px rgba(200, 80, 192, 0.15);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 10;
        }

        .btn-login {
            background: linear-gradient(90deg, #4158D0, #C850C0);
            border: none;
            border-radius: 1rem;
            padding: 0.875rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(65, 88, 208, 0.4);
            width: 100%;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(200, 80, 192, 0.5);
            background: linear-gradient(90deg, #3a4eb8, #b048a8);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .brand-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .brand-badge img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
        }

        .brand-badge span {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .footer-note i {
            color: #C850C0;
        }

        /* Alert customization */
        .alert {
            border-radius: 1rem;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="login-card">
        
        <!-- Brand Badge -->
        <div class="brand-badge">
            <!-- <img src="Photo/u.png" alt="ပုသိမ်မြို့"> -->
            <span>ပုသိမ်မြို့</span>
        </div>

        <!-- Header -->
        <div class="login-header">
            အက်ဒမင် ဝင်ရောက်ရန်
        </div>
        <!-- <div class="login-subheader">
            စီမံခန့်ခွဲသူများအတွက် လုံခြုံစိတ်ချရသော ဝင်ပေါက်
        </div> -->

        <!-- Login Form -->
        <form method="POST">

            <!-- Email Field -->
            <div class="input-group-custom">
                <!-- <i class="bi bi-envelope-fill input-icon"></i> -->
                 <label class="form-label" style="margin-left: 1.5rem;">အီးမေးလ်</label>
                <input type="email" name="email" class="form-control" 
                       placeholder="example@domain.com" required>
                
            </div>

            <!-- Password Field -->
            <div class="input-group-custom">
                <!-- <i class="bi bi-lock-fill input-icon"></i> -->
                 <label class="form-label" style="margin-left: 1.5rem;">စကားဝှက်</label>
                <input type="password" name="password" class="form-control" 
                       placeholder="••••••••" required>
                
            </div>

            <!-- Login Button -->
            <button type="submit" name="login" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>ဝင်ရောက်မည်
            </button>

        </form>

        <!-- Footer Note -->
        <div class="footer-note">
            <i class="bi bi-shield-check me-1"></i> 
            စီမံခန့်ခွဲသူများအတွက်သာ ရည်ရွယ်ပါသည်။
        </div>

    </div>

</body>

</html>