<?php
session_start();
include 'db.php';

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ၂။ users table နှင့် bus_users table ကို Join ပြီး အချက်အလက်များကို အကုန်သယ်ယူခြင်း
// ဤသို့လုပ်ခြင်းဖြင့် ဒုတိယအကြိမ်ဝင်လျှင်လည်း သိမ်းထားသော data များ ပြန်ပါလာမည်ဖြစ်သည်။
$userQuery = mysqli_query($db, "
    SELECT u.name, u.email, b.cargate_name, b.address, b.phone, b.image 
    FROM users u 
    LEFT JOIN bus_users b ON u.user_id = b.user_id 
    WHERE u.user_id = $user_id
");

$userData = mysqli_fetch_assoc($userQuery);
$login_name = $userData['name'];
$login_email = $userData['email'];

// သိမ်းထားပြီးသား data ရှိလျှင် variable ထဲထည့်မည်၊ မရှိလျှင် ကွက်လပ်ထားမည်
$saved_cargate = $userData['cargate_name'] ?? "";
$saved_address = $userData['address'] ?? "";
$saved_phone   = $userData['phone'] ?? "";
$saved_image   = $userData['image'] ?? "default.png";

// ၃။ Save လုပ်ခြင်း Logic (Submit နှိပ်လိုက်ချိန်)
if (isset($_POST['save'])) {
    $cargate_name = mysqli_real_escape_string($db, $_POST['cargate_name']);
    $owner_name   = $login_name; 
    $email        = mysqli_real_escape_string($db, $_POST['email']);
    $address      = mysqli_real_escape_string($db, $_POST['address']);
    $phone        = mysqli_real_escape_string($db, $_POST['phone']);
    $role         = "Bus Admin";

    // ပုံ Upload တင်ခြင်း
    $image_name = $_FILES['image']['name'];
    $image_tmp  = $_FILES['image']['tmp_name'];
    $upload_dir = "uploads/";
    
    if (!empty($image_name)) {
        $final_image = time() . "_" . $image_name;
        move_uploaded_file($image_tmp, $upload_dir . $final_image);
    } else {
        $final_image = $saved_image; // ပုံသစ်မတင်လျှင် ပုံဟောင်းကို ဆက်သုံးမည်
    }

    if (empty(trim($cargate_name))) {
        echo "<script>alert('ဂိတ်အမည်ကို ဖြည့်စွက်ပါ');</script>";
    } else {
        // bus_users table ထဲသို့ data သွင်းခြင်း (user_id သည် UNIQUE ဖြစ်နေရပါမည်)
        $query = "INSERT INTO bus_users (user_id, cargate_name, owner_name, email, role, image, address, phone) 
                  VALUES ('$user_id', '$cargate_name', '$owner_name', '$email', '$role', '$final_image', '$address', '$phone')
                  ON DUPLICATE KEY UPDATE 
                  cargate_name = '$cargate_name', 
                  owner_name = '$owner_name', 
                  email = '$email',
                  image = '$final_image', 
                  address = '$address', 
                  phone = '$phone',
                  login_time = CURRENT_TIMESTAMP";

        if (mysqli_query($db, $query)) {
            $_SESSION['cargate_name'] = $cargate_name;
            mysqli_query($db, "UPDATE users SET is_registered = 1 WHERE user_id = $user_id");

            echo "<script>alert('Profile သိမ်းဆည်းပြီးပါပြီ'); window.location.href='BusAdminDashboard.php';</script>";
            exit;
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Pyidaungsu:wght@400;700&display=swap');
        body { background-color: #f0f2f5; font-family: 'Montserrat', 'Pyidaungsu', sans-serif; }
        .header-bg { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); height: 180px; padding-top: 40px; color: white; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px; }
        .form-card { max-width: 650px; margin: -60px auto 50px; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); background: white; }
        .readonly-field { background-color: #e9ecef !important; font-weight: 600; color: #495057; }
        .btn-primary { background: #1e3c72; border: none; padding: 12px; border-radius: 12px; font-weight: 700; transition: 0.3s; }
        .btn-primary:hover { background: #2a5298; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="header-bg text-center">
    <h2 class="fw-bold"><i class="fas fa-user-shield me-2"></i> Admin Profile Setup</h2>
    <p class="opacity-75">လုပ်ငန်းမစတင်မီ သင်၏ Profile ကို အရင်ဖြည့်စွက်ပါ</p>
</div>

<div class="container">
    <div class="card form-card shadow">
        <div class="card-body p-4 p-md-5">
            <form method="post" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-user me-2 text-primary"></i>(ပိုင်ရှင်အမည်)</label>
                    <input type="text" class="form-control " value="">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-bus me-2 text-primary"></i>(ဂိတ်အမည်)</label>
                    <input type="text" name="cargate_name" class="form-control" value="<?php echo $saved_cargate; ?>" placeholder="ဥပမာ - ရွှေမန္တလာ" required>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fas fa-envelope me-2 text-primary"></i>Email Address</label>
                        <input type="email" name="email" class="form-control" value="" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fas fa-phone me-2 text-primary"></i>Phone Number</label>
                        <input type="text-box" name="phone" class="form-control" value="<?php echo $saved_phone; ?>" placeholder="09xxxxxxxxx" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-image me-2 text-primary"></i>Profile Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <?php if($saved_image != "default.png"): ?>
                        <small class="text-success">လက်ရှိပုံ: <?php echo $saved_image; ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Office Address (လိပ်စာ)</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="အမှတ်၊ လမ်း၊ မြို့နယ်..." required><?php echo $saved_address; ?></textarea>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" name="save" class="btn btn-primary fs-5">
                        <i class="fas fa-check-circle me-2"></i> Profile သိမ်းဆည်းမည်
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>