<?php
session_start();
include("Admin/db.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];
    
    // Database ထဲတွင် အီးမေးလ် နှင့် အကောင့် status စစ်ဆေးခြင်း
    $query = "SELECT * FROM bus_customer WHERE email = '$email' AND status = 'active'";
    $result = mysqli_query($db, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Password Verify လုပ်ခြင်း
        if (password_verify($password, $user['password'])) {
            
            // Customer အချက်အလက်များ သိမ်းဆည်းခြင်း
            $_SESSION['customer_id'] = $user['customer_id'];
            $_SESSION['customer_name'] = $user['name'];
            $_SESSION['customer_email'] = $user['email'];
            
            // *** အရေးကြီးဆုံး အပိုင်း ***
            // redirect parameter ပါလာရင် အဲဒီကိုပြန်သွားမယ်
            if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                $redirect = urldecode($_GET['redirect']);
                header("Location: $redirect");
                exit();
            } 
            // session ထဲမှာ redirect_url ရှိရင် အဲဒီကိုသွားမယ်
            elseif (isset($_SESSION['redirect_url']) && !empty($_SESSION['redirect_url'])) {
                $redirect = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);
                header("Location: $redirect");
                exit();
            } 
            // ဘာ redirect မှမပါရင် bus_list.php ကိုပဲသွားမယ်
            else {
                header("Location: bus_list.php");
                exit();
            }
            
        } else {
            $error = "စကားဝှက် မှားယွင်းနေပါသည်။";
        }
    } else {
        $error = "ဤအီးမေးလ်ဖြင့် အကောင့်မရှိပါ သို့မဟုတ် အကောင့်ပိတ်ထားပါသည်။";
    }
}

// *** အရေးကြီးဆုံး အပိုင်း ***
// redirect parameter ပါလာရင် session ထဲမှာ သိမ်းထားမယ်
if (isset($_GET['redirect'])) {
    $_SESSION['redirect_url'] = $_GET['redirect'];
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - အကောင့်ဝင်ရန်</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            font-family: 'Pyidaungsu', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            max-width: 450px;
            margin: 0 auto;
        }
        
        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid #ddd;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #004e92, #00a8ff);
            color: white;
            border-radius: 50px;
            padding: 12px;
            font-weight: bold;
            border: none;
            width: 100%;
            transition: 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,78,146,0.3);
        }
        
        .info-box {
            background: #e8f0fe;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            border-left: 4px solid #004e92;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="text-center mb-4">
                <i class="fas fa-bus-alt fa-3x text-primary mb-3"></i>
                <h3 class="fw-bold">အကောင့်ဝင်ရန်</h3>
                <p class="text-muted">လက်မှတ်ဝယ်ယူရန် အကောင့်ဝင်ပေးပါ</p>
            </div>
            
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <!-- redirect parameter ပါလာရင် ပြသမည် -->
            <?php if(isset($_GET['redirect'])): ?>
                <div class="info-box">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    ဆက်လက်ဆောင်ရွက်ရန် အကောင့်ဝင်ပေးပါ။
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label ms-2">အီးမေးလ်</label>
                    <input type="email" name="email" class="form-control" required placeholder="example@gmail.com">
                </div>
                
                <div class="mb-4">
                    <label class="form-label ms-2">စကားဝှက်</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn-login mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>အကောင့်ဝင်မည်
                </button>
                
                <div class="text-center">
                    <span class="text-muted">အကောင့်မရှိသေးဘူးလား?</span> 
                    <a href="register.php<?= isset($_GET['redirect']) ? '?redirect='.urlencode($_GET['redirect']) : '' ?>" class="text-decoration-none fw-bold">အကောင့်အသစ်ဖွင့်ရန်</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>