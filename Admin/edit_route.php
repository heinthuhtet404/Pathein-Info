<?php
session_start();
include("db.php");

// ၁။ Login နှင့် ID စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: BusAdminDashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = intval($_GET['id']);

// ၂။ ဒေတာဟောင်းကို ဆွဲထုတ်ခြင်း
$res = mysqli_query($db, "SELECT * FROM bus_route WHERE id=$id AND user_id=$user_id");
$data = mysqli_fetch_assoc($res);

if (!$data) { 
    echo "<div class='alert alert-danger text-center m-5'>လမ်းကြောင်း ရှာမတွေ့ပါ သို့မဟုတ် ဝင်ရောက်ခွင့်မရှိပါ။</div>"; 
    exit; 
}

// ၃။ Update လုပ်ခြင်း Logic
if (isset($_POST['update_route'])) {
    $route_name = mysqli_real_escape_string($db, $_POST['route_name']);
    $start = mysqli_real_escape_string($db, $_POST['start_point']);
    $end = mysqli_real_escape_string($db, $_POST['end_point']);
    $time = mysqli_real_escape_string($db, $_POST['time']);
    $price = intval($_POST['price']);
    $date_input = mysqli_real_escape_string($db, $_POST['route_date']);

    $img_sql = ""; 
    if (!empty($_FILES['bus_image']['name'])) {
        $img_name = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['bus_image']['name']);
        $tmp_name = $_FILES['bus_image']['tmp_name'];
        
        if (move_uploaded_file($tmp_name, "uploads/" . $img_name)) {
            $img_sql = ", image='$img_name'";
            if (!empty($data['image']) && file_exists("uploads/" . $data['image'])) {
                unlink("uploads/" . $data['image']);
            }
        }
    }

    $update_sql = "UPDATE bus_route SET 
                    route_name='$route_name', 
                    start_point='$start', 
                    end_point='$end', 
                    time='$time', 
                    Date='$date_input', 
                    price=$price 
                    $img_sql
                   WHERE id=$id AND user_id=$user_id";
    
    if (mysqli_query($db, $update_sql)) {
        echo "<script>alert('ပြင်ဆင်မှု အောင်မြင်ပါသည်'); window.location='BusAdminDashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Route - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body { 
            background: #0f172a; 
            font-family: 'Pyidaungsu', sans-serif; 
            padding-bottom: 50px;
            color: #f8fafc;
        }

        .header-section {
            background: linear-gradient(135deg, #1e40af 0%, #1e1b4b 100%);
            height: 200px; padding-top: 40px; color: white;
            border-bottom-left-radius: 60px; border-bottom-right-radius: 60px;
        }

        .main-card { 
            max-width: 800px; margin: -80px auto 0; 
            background: #1e293b; padding: 40px;
            border-radius: 30px; border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        /* Date & Time Field Fixes */
        .form-control {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px;
            color-scheme: dark; /* Calendar Picker ကို အမည်းရောင်ပြောင်းရန် */
        }

        .form-control:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2) !important;
        }

        .input-group-text {
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
            color: #38bdf8 !important;
        }

        .img-preview-box {
            width: 100%; height: 280px; background: #0f172a;
            border-radius: 20px; border: 2px dashed #334155;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; margin-bottom: 30px; position: relative;
        }

        #preview-img { width: 100%; height: 100%; object-fit: cover; }

        .section-title {
            font-size: 0.8rem; font-weight: 700; color: #38bdf8;
            text-transform: uppercase; letter-spacing: 1px;
            margin: 30px 0 15px; display: flex; align-items: center;
        }
        .section-title::after { content: ""; flex: 1; height: 1px; background: rgba(56,189,248,0.2); margin-left: 15px; }

        .btn-save {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: none; border-radius: 15px; padding: 15px;
            font-weight: 700; color: white; transition: 0.3s;
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(2,132,199,0.3); }

        /* Calendar Icon နေရာညှိခြင်း */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            padding: 5px;
            filter: invert(0.5) sepia(1) saturate(5) hue-rotate(175deg); /* Icon ကို အပြာရောင်သန်းစေရန် */
        }
    </style>
</head>
<body>

<div class="header-section text-center">
    <h2 class="fw-bold"><i class="fa fa-route me-2"></i> Update Route</h2>
    <p class="opacity-75">ခရီးစဉ်အချက်အလက်များကို မှန်ကန်စွာ ပြင်ဆင်ပါ</p>
</div>

<div class="container">
    <div class="main-card">
        <form method="POST" enctype="multipart/form-data">
            
            <div class="img-preview-box shadow-sm">
                <img src="<?= !empty($data['image']) ? 'uploads/'.$data['image'] : 'https://placehold.co/800x400/0f172a/38bdf8?text=Bus+Image' ?>" id="preview-img">
                <div style="position: absolute; bottom: 15px; right: 15px;">
                    <label for="bus_image" class="btn btn-info btn-sm rounded-pill px-3 text-white">
                        <i class="fa fa-camera me-1"></i> Change Photo
                    </label>
                    <input type="file" name="bus_image" id="bus_image" class="d-none" accept="image/*" onchange="previewFile()">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small opacity-75">Route Name</label>
                <input type="text" name="route_name" class="form-control" value="<?= htmlspecialchars($data['route_name']) ?>" required>
            </div>

            <div class="section-title">Location</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">From</label>
                    <input type="text" name="start_point" class="form-control" value="<?= htmlspecialchars($data['start_point']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">To</label>
                    <input type="text" name="end_point" class="form-control" value="<?= htmlspecialchars($data['end_point']) ?>" required>
                </div>
            </div>

            <div class="section-title">Schedule & Price</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small"><i class="fa fa-calendar me-1"></i> Date</label>
                    <input type="date" name="route_date" class="form-control" value="<?= $data['Date'] ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small"><i class="fa fa-clock me-1"></i> Time</label>
                    <input type="time" name="time" class="form-control" value="<?= htmlspecialchars($data['time']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Price (Ks)</label>
                    <div class="input-group">
                        <span class="input-group-text">Ks</span>
                        <input type="number" name="price" class="form-control" value="<?= $data['price'] ?>" required>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-8">
                    <button type="submit" name="update_route" class="btn btn-save w-100 shadow">
                        <i class="fa fa-sync-alt me-2"></i> Save Changes
                    </button>
                </div>
                <div class="col-md-4">
                    <a href="BusAdminDashboard.php" class="btn btn-outline-light w-100 py-3 rounded-4 fw-bold">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('preview-img');
        const file = document.getElementById('bus_image').files[0];
        const reader = new FileReader();
        reader.onloadend = () => { preview.src = reader.result; }
        if (file) { reader.readAsDataURL(file); }
    }
</script>

</body>
</html>