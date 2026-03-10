<?php
session_start();
include("db.php");

if(isset($_POST['login'])){

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if(empty($email) || empty($password)){
echo "<script>alert('Email နှင့် Password ဖြည့်ပါ');</script>";
}

else{

$email = mysqli_real_escape_string($db,$email);

$query = "SELECT * FROM users WHERE email='$email' AND role_id=1 LIMIT 1";
$result = mysqli_query($db,$query);

if(mysqli_num_rows($result) == 1){

$user = mysqli_fetch_assoc($result);

/* Superadmin approve check */
if($user['status'] != 'Accept'){

echo "<script>alert('Superadmin မှ approve မလုပ်သေးပါ');</script>";

}

else{

/* password verify */
if(password_verify($password,$user['password'])){

$_SESSION['business_id']   = $user['user_id'];
$_SESSION['business_name'] = $user['business_name'];
$_SESSION['category_id']   = $user['category_id'];

$category = $user['category_id'];


// clinic record ရှိ/မရှိ စစ်ခြင်း (အတွက် category 2 အတွက်)
    if($category == 2){
        $clinic_check = mysqli_query($db, "SELECT * FROM clinics WHERE user_id = '{$user['user_id']}' LIMIT 1");
        if(mysqli_num_rows($clinic_check) == 0){
            // Register လုပ်ပြီး clinic မထည့်သေးရင်
            header("Location: register_health.php");
            exit();
        } else {
            // Clinic ရှိပြီးသားဆိုရင်
            header("Location: clinics_admindashboard.php");
            exit();
        }
    }

    if($category == 3){
    $current_user_id = $user['user_id'];

    // bus_users table မှာ စစ်ဆေး
    $busUserQuery = mysqli_query($db, "SELECT * FROM bus_users WHERE user_id = $current_user_id LIMIT 1");

    if(mysqli_num_rows($busUserQuery) > 0){
        // Bus user ရှိပြီးသား → session တင်ပြီး dashboard သို့
        $busUserData = mysqli_fetch_assoc($busUserQuery);
        $_SESSION['cargate_name'] = $busUserData['cargate_name'];
        $_SESSION['busline_id']   = $busUserData['busline_id'] ?? null;

        header("Location: BusAdminDashboard.php");
        exit();
    } else {
        // ပထမဆုံး login → register page သို့
        header("Location: register_Bus.php");
        exit();
    }
}
/* Redirect based on business category */
switch($category){

case 1:
header("Location: school_dashboard.php");
break;

// case 2:
// header("Location: register_health.php");
// break;

// case 3:
// header("Location: busline_dashboard.php");
// break;

case 4:
header("Location: hotel_dashboard.php");
break;

case 5:
header("Location: product_dashboard.php");
break;

default:
header("Location: business_dashboard.php");
break;

}

exit();

}

else{

echo "<script>alert('Password မှားနေပါသည်');</script>";

}

}

}

else{

echo "<script>alert('Email မရှိပါ');</script>";

}

}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Login | လုပ်ငန်းရှင်ဝင်ရောက်ရန်</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background Elements */
        .bg-bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .bubble-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation: float 20s infinite;
        }
        
        .bubble-2 {
            width: 500px;
            height: 500px;
            bottom: -200px;
            right: -100px;
            animation: float 25s infinite reverse;
        }
        
        .bubble-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 15s infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, 30px) rotate(5deg); }
            50% { transform: translate(0, 50px) rotate(0deg); }
            75% { transform: translate(-30px, 30px) rotate(-5deg); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.05; }
            50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.08; }
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2.5rem 2rem;
            border: none;
            text-align: center;
            position: relative;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 L0,100 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            opacity: 0.1;
        }
        
        .header-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 3px solid rgba(255, 255, 255, 0.5);
            animation: pulse-icon 2s infinite;
        }
        
        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
        }
        
        .header-icon i {
            font-size: 2.5rem;
            color: white;
        }
        
        .card-header h3 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: 1px;
        }
        
        .card-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 10px 0 0 0;
            font-size: 1rem;
            font-weight: 300;
        }
        
        .card-body {
            padding: 2.5rem;
            background: white;
        }
        
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-label i {
            color: #667eea;
            margin-right: 8px;
            width: 20px;
            font-size: 1rem;
        }
        
        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .input-group-custom .form-control {
            padding-left: 45px;
            height: 55px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .input-group-custom .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
            background: white;
        }
        
        .input-group-custom .form-control:focus + i {
            color: #764ba2;
        }
        
        .input-group-custom .form-control:hover {
            border-color: #764ba2;
            background: white;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0aec0;
            z-index: 20;
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            padding: 16px 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        
        .btn-login:hover i {
            transform: translateX(5px);
        }
        
        .forgot-password {
            text-align: right;
            margin: 1rem 0 2rem;
        }
        
        .forgot-password a {
            color: #718096;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .forgot-password a i {
            margin-left: 5px;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: #667eea;
        }
        
        .forgot-password a:hover i {
            transform: translateX(3px);
        }
        
        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }
        
        .register-link p {
            color: #718096;
            margin-bottom: 0;
            font-size: 1rem;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            margin-left: 5px;
        }
        
        .register-link a i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .register-link a:hover {
            color: #764ba2;
        }
        
        .register-link a:hover i {
            transform: translateX(5px);
        }
        
        .alert-message {
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
            background: #fed7d7;
            color: #c53030;
            display: flex;
            align-items: center;
        }
        
        .alert-message i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .features {
            display: flex;
            justify-content: space-around;
            margin-top: 2rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 15px;
        }
        
        .feature-item {
            text-align: center;
        }
        
        .feature-item i {
            color: #667eea;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .feature-item span {
            display: block;
            font-size: 0.8rem;
            color: #718096;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .card-header {
                padding: 2rem 1.5rem;
            }
            
            .card-header h3 {
                font-size: 1.5rem;
            }
            
            .header-icon {
                width: 60px;
                height: 60px;
            }
            
            .header-icon i {
                font-size: 2rem;
            }
            
            .features {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .feature-item {
                flex: 1 1 auto;
            }
        }
        
        /* Loading Animation */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #e2e8f0;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <!-- Animated Background Bubbles -->
    <div class="bg-bubble bubble-1"></div>
    <div class="bg-bubble bubble-2"></div>
    <div class="bg-bubble bubble-3"></div>
    
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
    </div>

    <div class="login-container">
        <div class="login-card card">
            
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3><i class="fas fa-sign-in-alt me-2"></i>Business Login</h3>
                <p>လုပ်ငန်းရှင်များအတွက် ဝင်ရောက်ရန်</p>
            </div>

            <div class="card-body">
                <form method="POST" id="loginForm">
                    
                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" 
                               placeholder="သင်၏ email လိပ်စာ" required>
                    </div>

                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control" 
                               placeholder="သင်၏ လျှို့ဝှက်နံပါတ်" id="password" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword" 
                           onclick="togglePassword()"></i>
                    </div>

                    <div class="forgot-password">
                        <a href="#">
                            လျှို့ဝှက်နံပါတ် မေ့နေပါသလား? 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="login" class="btn-login" onclick="showLoading()">
                            <i class="fas fa-sign-in-alt"></i> ဝင်ရောက်ရန်
                        </button>
                    </div>

                    <!-- Features -->
                    <!-- <div class="features">
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>လုံခြုံစိတ်ချရ</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>24/7 ဝန်ဆောင်မှု</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset"></i>
                            <span>အကူအညီ</span>
                        </div>
                    </div> -->

                </form>

                <div class="register-link">
                    <p>
                        အကောင့်မရှိသေးဘူးလား?
                        <a href="register.php">
                            စာရင်းသွင်းရန် <i class="fas fa-arrow-right"></i>
                        </a>
                    </p>
                </div>
            </div>

        </div>
        
        <!-- Business Categories -->
        <!-- <div class="text-center mt-4">
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-school text-primary me-1"></i> ကျောင်း
                </span>
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-hospital text-primary me-1"></i> ဆေးရုံ
                </span>
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-bus text-primary me-1"></i> ကားလိုင်း
                </span>
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-hotel text-primary me-1"></i> ဟိုတယ်
                </span>
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-box text-primary me-1"></i> ထုတ်ကုန်
                </span>
            </div>
        </div> -->
    </div>

    <script>
        // Password Toggle Function
        function togglePassword() {
            const password = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            
            if (password.type === 'password') {
                password.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Loading Spinner
        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'flex';
        }

        // Hide loading when page loads
        window.onload = function() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Email နှင့် Password ဖြည့်ပါ');
            }
        });

        // Add floating animation to inputs
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>