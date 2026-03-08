<?php
session_start();
include 'Admin/db.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // ၁။ Password တိုက်စစ်ခြင်း
    if ($password !== $confirm_password) {
        $error = "လျှို့ဝှက်နံပါတ် နှစ်ခု မတူညီပါသဖြင့် ပြန်လည်စစ်ဆေးပါ။";
    } else {
        // ၂။ Email ရှိပြီးသားလား စစ်ဆေးခြင်း
        $check = mysqli_query($db, "SELECT email FROM patients WHERE email='$email'");
        if(mysqli_num_rows($check) > 0) {
            $error = "ဤအီးမေးလ်ဖြင့် အကောင့်ရှိပြီးသား ဖြစ်နေပါသည်။";
        } else {
            // ၃။ Password ကို Hash လုပ်ပြီး Database ထဲ သိမ်းခြင်း
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO patients (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$hashed_password')";
            
            if (mysqli_query($db, $sql)) {
                echo "<script>alert('အကောင့်ဖွင့်ခြင်း အောင်မြင်ပါသည်။ Login ဝင်နိုင်ပါပြီ။'); window.location='patient_login.php';</script>";
                exit;
            } else {
                $error = "အကောင့်ဖွင့်စဉ် အမှားအယွင်းတစ်ခု ဖြစ်ပေါ်ခဲ့ပါသည်။";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account - Clinic Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root { --primary-color: #0d6efd; --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        body { background: var(--bg-gradient); min-height: 100vh; display: flex; align-items: center; font-family: 'Pyidaungsu', sans-serif; padding: 40px 0; }
        
        .register-card {
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            background: white;
            overflow: hidden;
        }
        
        .register-header {
            background: var(--primary-color);
            padding: 30px;
            color: white;
            text-align: center;
        }

        .form-section { padding: 40px; }
        
        .form-label { font-size: 0.85rem; font-weight: 600; color: #495057; }
        
        .input-group-text {
            background: #f8f9fa;
            border-right: none;
            color: #6c757d;
        }
        
        .form-control {
            border-left: none;
            padding: 10px 12px;
            border-radius: 0 10px 10px 0;
            background: #f8f9fa;
        }
        
        .form-control:focus { background: white; box-shadow: none; border-color: #dee2e6; }
        
        .btn-register {
            background: var(--primary-color);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            transition: 0.3s;
        }
        
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(13,110,253,0.3); }

        .back-home { position: fixed; top: 20px; left: 20px; color: #495057; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<a href="index.php" class="back-home"><i class="fas fa-arrow-left me-2"></i>ပင်မစာမျက်နှာသို့</a>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5" data-aos="fade-up">
            <div class="card register-card">
                <div class="register-header">
                    <i class="fas fa-user-plus fa-3x mb-3"></i>
                    <h4 class="fw-bold mb-0">လူနာအကောင့်အသစ်ဖွင့်ရန်</h4>
                </div>
                
                <div class="form-section">
                    <?php if(isset($error)): ?>
                        <div class='alert alert-danger border-0 small mb-4'>
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">အမည်အပြည့်အစုံ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Mg Mg" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">အီးမေးလ်လိပ်စာ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ဖုန်းနံပါတ်</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxxx">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">လျှို့ဝှက်နံပါတ်</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">အတည်ပြုနံပါတ်</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn btn-primary btn-register w-100 text-white mb-3">
                            အကောင့်ဖွင့်မည် <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted small mb-0">အကောင့်ရှိပြီးသားလား? <a href="patient_login.php" class="text-primary fw-bold text-decoration-none">Login ဝင်ပါ</a></p>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-4 text-muted small">&copy; <?php echo date('Y'); ?> Clinic Appointment System</p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
</body>
</html>