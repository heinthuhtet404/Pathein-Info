<?php
session_start();
include("Admin/db.php");

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $nrc = mysqli_real_escape_string($db, $_POST['nrc']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if ($password !== $confirm_password) {
        $error = "စကားဝှက် နှစ်ခု မတူညီပါ။";
    } elseif (strlen($password) < 6) {
        $error = "စကားဝှက် အနည်းဆုံး ၆ လုံးရှိရပါမည်။";
    } else {
        // Check if email exists in bus_customer table
        $check = mysqli_query($db, "SELECT customer_id FROM bus_customer WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "ဒီအီးမေးလ် သုံးပြီးသားရှိပါသည်။";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Changed table name to bus_customer
            $query = "INSERT INTO bus_customer (name, email, phone, nrc, password) 
                      VALUES ('$name', '$email', '$phone', '$nrc', '$hashed_password')";
            
            if (mysqli_query($db, $query)) {
                $success = "အကောင့် အောင်မြင်စွာ ဖွင့်ပြီးပါပြီ။ ကျေးဇူးပြု၍ အကောင့်ဝင်ပါ။";
            } else {
                $error = "မှားယွင်းမှု ဖြစ်ပေါ်ခဲ့ပါသည်။ နောက်မှ ထပ်ကြိုးစားပါ။";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - အကောင့်ဖွင့်ရန်</title>
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
            padding: 20px 0;
        }
        
        .register-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            max-width: 500px;
            margin: 0 auto;
        }
        
        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid #ddd;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #004e92, #00a8ff);
            color: white;
            border-radius: 50px;
            padding: 12px;
            font-weight: bold;
            border: none;
            width: 100%;
            transition: 0.3s;
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,78,146,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="text-center mb-4">
                <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                <h3 class="fw-bold">အကောင့်အသစ်ဖွင့်ရန်</h3>
                <p class="text-muted">လက်မှတ်ဝယ်ယူရန် အကောင့်ဖွင့်ပေးပါ</p>
            </div>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">အမည်အပြည့်အစုံ</label>
                    <input type="text" name="name" class="form-control" required placeholder="ဥပမာ - မောင်မောင်">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">အီးမေးလ်</label>
                    <input type="email" name="email" class="form-control" required placeholder="example@gmail.com">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">ဖုန်းနံပါတ်</label>
                    <input type="tel" name="phone" class="form-control" required placeholder="09xxxxxxxxx">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">NRC (မှတ်ပုံတင်အမှတ်)</label>
                    <input type="text" name="nrc" class="form-control" required placeholder="၁၂/မဂဒု(နိုင်)၁၂၃၄၅၆">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">စကားဝှက်</label>
                    <input type="password" name="password" class="form-control" required placeholder="အနည်းဆုံး ၆ လုံး">
                </div>
                
                <div class="mb-4">
                    <label class="form-label">စကားဝှက် အတည်ပြုရန်</label>
                    <input type="password" name="confirm_password" class="form-control" required placeholder="စကားဝှက် ပြန်ရိုက်ပါ">
                </div>
                
                <button type="submit" class="btn-register mb-3">
                    <i class="fas fa-user-plus me-2"></i>အကောင့်ဖွင့်မည်
                </button>
                
                <div class="text-center">
                    <a href="buslogin.php" class="text-decoration-none">အကောင့်ရှိပြီးသားလား? ဝင်ရန်</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>