<?php
session_start();
include 'Admin/db.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    // အီးမေးလ်ဖြင့် လူနာကို ရှာဖွေခြင်း
    $result = mysqli_query($db, "SELECT * FROM patients WHERE email='$email' LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        // Password ကို Hash တိုက်စစ်ခြင်း
        if (password_verify($password, $row['password'])) {
            // Session ထဲတွင် လူနာအချက်အလက်သိမ်းဆည်းခြင်း
            $_SESSION['patient_id'] = $row['id'];
            $_SESSION['patient_name'] = $row['username'];
            
            // Login အောင်မြင်ပါက ပင်မစာမျက်နှာ (သို့) ဘိုကင်စာမျက်နှာသို့ သွားမည်
            header("Location: index.php"); 
            exit;
        } else {
            $error = "လျှို့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။";
        }
    } else {
        $error = "ဤအီးမေးလ်ဖြင့် အကောင့်ဖွင့်ထားခြင်း မရှိသေးပါ။";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login - Clinic Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root { --primary-color: #0d6efd; --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        body { background: var(--bg-gradient); min-height: 100vh; display: flex; align-items: center; font-family: 'Pyidaungsu', sans-serif; }
        
        .login-card {
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            background: white;
        }
        
        .login-header {
            background: var(--primary-color);
            padding: 30px;
            color: white;
            text-align: center;
        }

        .form-section { padding: 40px; }
        
        .input-group-text {
            background: transparent;
            border-right: none;
            color: #6c757d;
        }
        
        .form-control {
            border-left: none;
            padding: 12px;
            border-radius: 0 12px 12px 0;
        }
        
        .form-control:focus { box-shadow: none; border-color: #dee2e6; }
        
        .btn-login {
            background: var(--primary-color);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            transition: 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13,110,253,0.3);
        }

        .back-home {
            position: fixed;
            top: 20px;
            left: 20px;
            color: #495057;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<a href="index.php" class="back-home"><i class="fas fa-arrow-left me-2"></i>ပင်မစာမျက်နှာသို့</a>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4" data-aos="zoom-in">
            <div class="card login-card">
                <div class="login-header">
                    <i class="fas fa-user-circle fa-3x mb-3"></i>
                    <h4 class="fw-bold mb-0">လူနာအကောင့်ဝင်ရန်</h4>
                </div>
                
                <div class="form-section">
                    <?php if(isset($error)): ?>
                        <div class='alert alert-danger border-0 small mb-4'>
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <label class="form-label small fw-bold text-muted">အီးမေးလ်လိပ်စာ</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                        </div>

                        <label class="form-label small fw-bold text-muted">လျှို့ဝှက်နံပါတ်</label>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <button type="submit" name="login" class="btn btn-primary btn-login w-100 text-white mb-3">
                            Login ဝင်မည် <i class="fas fa-sign-in-alt ms-2"></i>
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted small mb-0">အကောင့်မရှိသေးပါက <a href="patient_register.php" class="text-primary fw-bold text-decoration-none">ဒီမှာဖွင့်ပါ</a></p>
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