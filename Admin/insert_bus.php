<?php
session_start();
include("db.php");

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ၂။ Form Submission Logic
if (isset($_POST['submit_bus'])) {
    $user_id = $_SESSION['user_id'];
    $busline_name = mysqli_real_escape_string($db, $_POST['busline_name']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $total_seat = mysqli_real_escape_string($db, $_POST['total_seat']);
    $car_color = mysqli_real_escape_string($db, $_POST['car_color']);
    $routes = 1; // ✅ Default Route ID (တစ်ကားတစ်လမ်းကြောင်း စနစ်အတွက်)
    $status = 'active';

    // 🖼️ Image Upload Handling
    $image_name = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/bus_images/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        
        if (in_array($file_ext, $allowed_ext)) {
            $new_filename = uniqid('bus_', true) . '.' . $file_ext;
            $target_file = $target_dir . $new_filename;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_name = mysqli_real_escape_string($db, $target_file);
            }
        }
    }

    // ✅ INSERT Query - Simplified fields only
    $query = "INSERT INTO bus_line (user_id, busline_name, phone, address, total_seat, Car_color, routes, image, status) 
              VALUES ('$user_id', '$busline_name', '$phone', '$address', '$total_seat', '$car_color', '$routes', '$image_name', '$status')";
    
    if (mysqli_query($db, $query)) {
        echo "<script>alert('✅ ကားလိုင်းအသစ် ထည့်သွင်းပြီးပါပြီ'); window.location='BusAdminDashboard.php#tab-bus';</script>";
    } else {
        echo "<script>alert('❌ Error: " . mysqli_error($db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus Line - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body { 
            font-family: 'Pyidaungsu', sans-serif;
            background: linear-gradient(rgba(0, 15, 30, 0.8), rgba(0, 15, 30, 0.9)), 
                        url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 600px;
        }

        .form-label {
            color: #00d2ff;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            color: white !important;
            padding: 12px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #00d2ff;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.4);
            color: white !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.75) !important;
            opacity: 1;
        }

        .input-group-text {
            background: rgba(0, 210, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #00d2ff;
            border-right: none;
            border-radius: 12px 0 0 12px;
        }

        .btn-submit {
            background: linear-gradient(45deg, #007bff, #00d2ff);
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            color: white;
            transition: 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 210, 255, 0.4);
        }

        .btn-light {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 15px;
            padding: 12px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-light:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ff4d4d !important;
        }

        .section-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #007bff, #00d2ff);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.3);
        }

        .file-upload-label {
            display: block;
            background: rgba(255,255,255,0.15);
            border: 1px dashed rgba(255,255,255,0.4);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            color: rgba(255,255,255,0.85);
            cursor: pointer;
            transition: 0.3s;
        }
        .file-upload-label:hover {
            background: rgba(255,255,255,0.25);
            border-color: #00d2ff;
        }
        .file-upload-input { display: none; }
        
        .color-preview {
            width: 40px; height: 40px; border-radius: 10px;
            border: 2px solid rgba(255,255,255,0.3);
            cursor: pointer; transition: 0.3s;
        }
        .color-preview:hover { transform: scale(1.05); }
    </style>
</head>
<body>

<div class="glass-card shadow">
    <div class="text-center mb-4">
        <div class="section-icon">
            <i class="fas fa-bus"></i>
        </div>
        <h4 class="fw-bold m-0">Add New Bus Line</h4>
        <p class="text-info small mt-1 opacity-75">ကားလိုင်းအသစ်အတွက် အချက်အလက်များ ဖြည့်ပေးပါ</p>
    </div>
    
    <form method="POST" enctype="multipart/form-data">
        
        <!-- ✅ ကားနံပါတ် (ဂိတ်အမည် ဖယ်ရှားထားသည်) -->
        <div class="mb-3">
            <label class="form-label">ကားနံပါတ်</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-bus-alt"></i></span>
                <input type="text" name="busline_name" class="form-control" placeholder="ဥပမာ - YGN/12-3456" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <!-- ✅ ဖုန်းနံပါတ် -->
            <div class="col-md-6">
                <label class="form-label">ဖုန်းနံပါတ်</label>
                <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxxx" required>
            </div>
            <!-- ✅ စုစုပေါင်းခုံ -->
            <div class="col-md-6">
                <label class="form-label">ခုံအရေအတွက်</label>
                <input type="number" name="total_seat" class="form-control" placeholder="ဥပမာ - 45" min="1" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <!-- ✅ ကားအရောင် -->
            <div class="col-md-6">
                <label class="form-label">ကားအရောင်</label>
                <div class="d-flex align-items-center gap-2">
                    <input type="color" name="car_color" class="form-control form-control-color color-preview" value="#007bff" title="အရောင်ရွေးပါ" id="colorPicker">
                    <span class="small opacity-75" id="colorValue">#007bff</span>
                </div>
            </div>
            <!-- ✅ လိပ်စာ -->
            <div class="col-md-6">
                <label class="form-label">လိပ်စာ</label>
                <input type="text" name="address" class="form-control" placeholder="ဂိတ်လိပ်စာ...">
            </div>
        </div>

        <!-- ✅ ပုံတင်ရန် -->
        <!-- <div class="mb-4">
            <label class="form-label">ကားပုံ တင်ရန်</label>
            <label class="file-upload-label">
                <i class="fas fa-cloud-upload-alt me-2"></i>ပုံရွေးချယ်ပါ
                <input type="file" name="image" class="file-upload-input" accept="image/*" required>
            </label>
            <small class="text-muted opacity-75 d-block mt-1">* jpg, png, webp ဖိုင်များသာ တင်နိုင်ပါသည်။</small>
        </div> -->

        <!-- 🔒 Hidden Route ID (Database အတွက်သာ - One Bus One Route) -->
        <input type="hidden" name="routes" value="1">

        <div class="d-grid gap-3">
            <button type="submit" name="submit_bus" class="btn btn-submit">
                <i class="fas fa-save me-2"></i>ကားလိုင်း သိမ်းဆည်းမည်
            </button>
            <a href="BusAdminDashboard.php#tab-bus" class="btn btn-light text-center">
                <i class="fas fa-times me-2"></i>မလုပ်တော့ပါ
            </a>
        </div>
    </form>
</div>

<script>
// Color picker value preview
const colorPicker = document.getElementById('colorPicker');
const colorValue = document.getElementById('colorValue');

colorPicker.addEventListener('input', function() {
    colorValue.textContent = this.value;
});

// File name preview
document.querySelector('.file-upload-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if(fileName) {
        this.parentElement.innerHTML = `<i class="fas fa-check-circle me-2 text-success"></i> ${fileName}`;
    }
});
</script>

</body>
</html>