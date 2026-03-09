<?php
include("db.php");

if (isset($_POST['submit'])) {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);
    $idCard   = trim($_POST['idCard']);
    $business_name = trim($_POST['business_name']);
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : NULL;

    $role_id = 1;
    $password = "Password12345@";

    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($idCard) || empty($business_name) || empty($category_id)) {
        echo "<script>alert('အချက်အလက်များကိုဖြည့်သွင်းပါ။');</script>";
    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    }

    else {

        // Escape (Basic protection)
        $email = mysqli_real_escape_string($db, $email);
        $phone = mysqli_real_escape_string($db, $phone);
        $idCard = mysqli_real_escape_string($db, $idCard);
        $business_name = mysqli_real_escape_string($db, $business_name);

        // 1️⃣ Check Email / Phone / ID Card unique
        $checkUser = mysqli_query($db, "
            SELECT user_id FROM users
            WHERE email='$email'
            OR phone='$phone'
            OR idCard='$idCard'
        ");

        if (mysqli_num_rows($checkUser) > 0) {
            echo "<script>alert('Email, Phone or ID Card already exists');</script>";
        }
        else {

            // 2️⃣ Check Business Name + Category combination
            $checkBusiness = mysqli_query($db, "
                SELECT user_id FROM users
                WHERE business_name='$business_name'
                AND category_id='$category_id'
            ");

            if (mysqli_num_rows($checkBusiness) > 0) {
                echo "<script>alert('ဒီလုပ်ငန်းအမျိုးအစားထဲတွင် ဒီလုပ်ငန်းအမည်ရှိပြီးသားဖြစ်နေပါသည်။');</script>";
            }
            else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $uploadDir = "uploads/";
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Photo upload
                $photoName = "";
                if (!empty($_FILES['photo']['name'])) {
                    $photoName = time() . "_" . basename($_FILES['photo']['name']);
                    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
                }

                // Licence upload
                $licenceName = "";
                if (!empty($_FILES['Licence']['name'])) {
                    $licenceName = time() . "_lic_" . basename($_FILES['Licence']['name']);
                    move_uploaded_file($_FILES['Licence']['tmp_name'], $uploadDir . $licenceName);
                }

                $query = "INSERT INTO users
                (name, email, photo, phone, address, idCard, licence, business_name, password, role_id, category_id, status, is_registered, created_at)
                VALUES
                ('$name', '$email', '$photoName', '$phone', '$address', '$idCard', '$licenceName', '$business_name',
                '$hashedPassword', $role_id, $category_id, 'Pending', 0, NOW())";

                if (mysqli_query($db, $query)) {
                    echo "<script>
                            alert('အောင်မြင်ပါသည်။');
                            window.location.href='business_man_login.php';
                          </script>";
                } else {
                    echo "<script>alert('မအောင်မြင်ပါ။');</script>";
                }
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
    <title>မှတ်ပုံတင်ရန် | Business Registration</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .registration-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border: none;
            text-align: center;
            position: relative;
        }
        
        .card-header h3 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .card-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 10px 0 0 0;
            font-size: 1rem;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 5px;
            background: white;
            border-radius: 5px;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-label i {
            color: #667eea;
            margin-right: 8px;
            width: 20px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .form-control:hover, .form-select:hover {
            border-color: #764ba2;
        }
        
        .input-group-custom {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
            z-index: 10;
        }
        
        .input-group-custom .form-control {
            padding-left: 45px;
        }
        
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .file-upload-wrapper .form-control {
            padding: 10px;
            background: #f7fafc;
            border: 2px dashed #cbd5e0;
            cursor: pointer;
        }
        
        .file-upload-wrapper .form-control:hover {
            border-color: #667eea;
            background: #f0f4fa;
        }
        
        .file-upload-wrapper small {
            display: block;
            margin-top: 5px;
            color: #718096;
            font-size: 0.85rem;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .btn-register i {
            margin-right: 10px;
        }
        
        .required-star {
            color: #e53e3e;
            margin-left: 3px;
            font-size: 1.2rem;
        }
        
        .form-text-custom {
            color: #718096;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: #a0aec0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .divider::before {
            margin-right: 1rem;
        }
        
        .divider::after {
            margin-left: 1rem;
        }
        
        .divider span {
            font-size: 0.9rem;
            font-weight: 500;
            color: #718096;
        }
        
        .alert-message {
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .card-header h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container registration-container">
        <div class="registration-card card">
            
            <div class="card-header">
                <h3><i class="fas fa-user-plus me-2"></i>မှတ်ပုံတင်ရန်</h3>
                <p>လုပ်ငန်းမှတ်ပုံတင်ခြင်းအတွက် အောက်ပါအချက်အလက်များကိုဖြည့်ပါ</p>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    
                    <!-- Personal Information Section -->
                    <div class="divider">
                        <span><i class="fas fa-user-circle me-2"></i>ကိုယ်ရေးအချက်အလက်များ</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-user"></i>အမည် <span class="required-star">*</span>
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" class="form-control" placeholder="သင်၏အမည်အပြည့်အစုံ" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-envelope"></i>Email <span class="required-star">*</span>
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" class="form-control" placeholder="youremail@example.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-phone"></i>ဖုန်းနံပါတ် <span class="required-star">*</span>
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-phone"></i>
                                <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxx" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-id-card"></i>မှတ်ပုံတင်နံပါတ် <span class="required-star">*</span>
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-id-card"></i>
                                <input type="text" name="idCard" class="form-control" placeholder="မှတ်ပုံတင်နံပါတ်" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i>လိပ်စာ
                        </label>
                        <div class="input-group-custom">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="address" class="form-control" placeholder="နေရပ်လိပ်စာအပြည့်အစုံ">
                        </div>
                    </div>

                    <!-- Business Information Section -->
                    <div class="divider">
                        <span><i class="fas fa-building me-2"></i>လုပ်ငန်းအချက်အလက်များ</span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-building"></i>လုပ်ငန်းအမည် <span class="required-star">*</span>
                            </label>
                            <div class="input-group-custom">
                                <i class="fas fa-building"></i>
                                <input type="text" name="business_name" class="form-control" placeholder="လုပ်ငန်းအမည်" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-tags"></i>လုပ်ငန်းအမျိုးအစား <span class="required-star">*</span>
                            </label>
                            <select name="category_id" class="form-select" required>
                                <option value="" selected disabled>-- လုပ်ငန်းအမျိုးအစားရွေးချယ်ပါ --</option>
                                <option value="1"><i class="fas fa-school"></i> ကျောင်း</option>
                                <option value="2"><i class="fas fa-hospital"></i> ဆေးရုံ</option>
                                <option value="3"><i class="fas fa-bus"></i> ကားလိုင်း</option>
                                <option value="4"><i class="fas fa-hotel"></i> ဟိုတယ်</option>
                                <option value="5"><i class="fas fa-box"></i> ထုတ်ကုန်</option>
                            </select>
                        </div>
                    </div>

                    <!-- Document Upload Section -->
                    <div class="divider">
                        <span><i class="fas fa-upload me-2"></i>စာရွက်စာတမ်းများ</span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-camera"></i>ဓါတ်ပုံ <span class="required-star">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="photo" class="form-control" accept="image/*" required>
                                <small><i class="fas fa-info-circle"></i> JPG, PNG or GIF (Max. 2MB)</small>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-file-alt"></i>လိုင်စင်အထောက်အထားပုံ <span class="required-star">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="Licence" class="form-control" accept="image/*,application/pdf" required>
                                <small><i class="fas fa-info-circle"></i> JPG, PNG, PDF (Max. 5MB)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <!-- <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                            <label class="form-check-label" for="termsCheck">
                                စည်းမျဉ်းစည်းကမ်းများကို ဖတ်ရှုနားလည်သဘောတူပါသည် 
                                <a href="#" class="text-primary">အသေးစိတ်ကြည့်ရန်</a>
                            </label>
                        </div>
                    </div> -->

                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn-register">
                            <i class="fas fa-paper-plane"></i> စာရင်းသွင်းရန်
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="form-text-custom">
                            <i class="fas fa-lock me-1"></i>
                            သင်၏အချက်အလက်များကို လုံခြုံစွာသိမ်းဆည်းထားပါသည်။
                        </p>
                    </div>

                </form>
            </div>

        </div>
        
        <!-- Login Link -->
        <div class="text-center mt-4">
            <p class="text-white">
                အကောင့်ရှိပြီးသားလား? 
                <a href="business_man_login.php" class="text-white fw-bold text-decoration-underline">
                    ဝင်ရောက်ရန် <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS (Optional for some components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>