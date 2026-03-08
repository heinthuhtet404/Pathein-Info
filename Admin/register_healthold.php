<?php
session_start();
include 'db.php';

// ၁။ Login ဝင်ထားခြင်း ရှိမရှိ စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ၂။ Save ခလုတ်နှိပ်လိုက်လျှင် လုပ်ဆောင်မည့်အပိုင်း
if (isset($_POST['save'])) {
    
    // String data များကို ယူခြင်း
    $clinics_name = mysqli_real_escape_string($db, $_POST['clinics_name']);
    $clinics_email = mysqli_real_escape_string($db, $_POST['clinics_email']);
    $clinics_address = mysqli_real_escape_string($db, $_POST['clinics_address']);
    $clinics_phone = mysqli_real_escape_string($db, $_POST['clinics_phone']);
    $clinics_description = mysqli_real_escape_string($db, $_POST['clinics_description']);
    $category = mysqli_real_escape_string($db, $_POST['category']);
    $map_link = mysqli_real_escape_string($db, $_POST['map_link']);
    $opening_hours = mysqli_real_escape_string($db, $_POST['opening_hours']);

    // ၃။ Image Upload လုပ်ရန် Folder သတ်မှတ်ခြင်း
    // project root ထဲမှာ uploads folder ရှိမရှိစစ်ပြီး မရှိရင် ဆောက်ပေးပါမယ်
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // ၄။ Logo Upload လုပ်ခြင်း
    $logo_filename = "";
    if (!empty($_FILES['clinics_logo']['name'])) {
        // ပုံအမည်တူရင် မထပ်အောင် time() ထည့်ပေးထားပါတယ်
        $logo_filename = time() . '_logo_' . str_replace(' ', '_', $_FILES['clinics_logo']['name']);
        move_uploaded_file($_FILES['clinics_logo']['tmp_name'], $target_dir . $logo_filename);
    }

    // ၅။ Gallery Images ၅ ပုံကို Loop ပတ်ပြီး သိမ်းခြင်း
    $gallery_files = [1=>"", 2=>"", 3=>"", 4=>"", 5=>""]; 
    for ($i = 1; $i <= 5; $i++) {
        $input_name = "img_" . $i;
        if (isset($_FILES[$input_name]) && !empty($_FILES[$input_name]['name'])) {
            $filename = time() . "_gallery" . $i . "_" . str_replace(' ', '_', $_FILES[$input_name]['name']);
            if(move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_dir . $filename)) {
                $gallery_files[$i] = $filename;
            }
        }
    }

    // ၆။ Database ထဲသို့ SQL Query ဖြင့် ထည့်သွင်းခြင်း
    if (!empty($clinics_name) && !empty($clinics_address)) {
        $query = "INSERT INTO clinics 
        (user_id, clinics_name, clinics_address, clinics_phone, clinics_email, clinics_description, clinics_logo, category, img_1, img_2, img_3, img_4, img_5, map_link, opening_hours) 
        VALUES 
        ('$user_id', '$clinics_name', '$clinics_address', '$clinics_phone', '$clinics_email', '$clinics_description', '$logo_filename', '$category', 
        '{$gallery_files[1]}', '{$gallery_files[2]}', '{$gallery_files[3]}', '{$gallery_files[4]}', '{$gallery_files[5]}', '$map_link', '$opening_hours')";

        if (mysqli_query($db, $query)) {
            echo "<script>alert('ဆေးခန်းအချက်အလက်များ အောင်မြင်စွာ သိမ်းဆည်းပြီးပါပြီ'); window.location='clinics_admindashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        echo "<script>alert('ကျေးဇူးပြု၍ ဆေးခန်းအမည်နှင့် လိပ်စာကို မဖြစ်မနေ ဖြည့်သွင်းပေးပါ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Clinic - HealthCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: none; }
        .section-title { border-left: 5px solid #0d6efd; padding-left: 10px; margin-bottom: 20px; font-weight: bold; color: #333; }
        .form-label { font-weight: 600; margin-bottom: 5px; }
        .btn-save { padding: 12px; font-weight: bold; font-size: 1.1rem; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-hospital-plus me-2"></i>ဆေးခန်းအချက်အလက်သစ် ဖြည့်သွင်းရန်</h3>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="post" enctype="multipart/form-data">
                        
                        <h5 class="section-title">၁။ အခြေခံအချက်အလက်များ</h5>
                        <div class="row g-3">
                            <div class="col-md-7 mb-3">
                                <label class="form-label">ဆေးခန်းအမည်*</label>
                                <input type="text" name="clinics_name" class="form-control" placeholder="ဆေးခန်းအမည် ရိုက်ထည့်ပါ" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label text-primary">အမျိုးအစား *</label>
                                <select name="category" class="form-select border-primary" required>
                                    <option value="" selected disabled>အမျိုးအစား ရွေးချယ်ပါ</option>
                                    <option value="အထွေထွေ">အထွေထွေရောဂါကု</option>
                                    <option value="သွားနှင့်ခံတွင်း">သွားနှင့်ခံတွင်း</option>
                                    <option value="မျက်စိ">မျက်စိအထူးကု</option>
                                    <option value="သားဖွားမီးယပ်">သားဖွားနှင့်မီးယပ်</option>
                                    <option value="ကလေး">ကလေးအထူးကု</option>
                                    <option value="အရေပြား">အရေပြား</option>
                                    <option value="အရိုးအကြော">အရိုး၊ အကြော၊ အဆစ်</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label အီးမေးလ် class="form-label">အီးမေးလ်</label>
                                <input type="email" name="clinics_email" class="form-control" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ဖုန်းနံပါတ်</label>
                                <input type="text" name="clinics_phone" class="form-control" placeholder="၀၉-XXXXXXXXX">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">လိပ်စာအပြည့်အစုံ *</label>
                            <textarea name="clinics_address" class="form-control" rows="2" placeholder="အိမ်အမှတ်၊ လမ်း၊ မြို့နယ်..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ဆေးခန်းအကြောင်းအကျဉ်း</label>
                            <textarea name="clinics_description" class="form-control" rows="4" placeholder="ဆေးခန်း၏ ဝန်ဆောင်မှုများနှင့် အကြောင်းအရာများ..."></textarea>
                        </div>

                        <hr class="my-5">

                        <h5 class="section-title">၂။ ဆေးခန်းပုံရိပ်များ </h5>
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 border rounded text-center bg-white h-100">
                                    <label class="form-label text-danger d-block mb-3">လိုဂိုပုံ</label>
                                    <i class="fas fa-id-badge fa-3x text-muted mb-3"></i>
                                    <input type="file" name="clinics_logo" class="form-control" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="bg-light p-3 rounded-3 h-100 border">
                                    <label class="form-label mb-3 text-secondary"><i class="fas fa-images me-2"></i>ဆေးခန်းမြင်ကွင်းပုံများ </label>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <input type="file" name="img_1" class="form-control form-control-sm" accept="image/*">
                                            <small class="text-muted">ပုံ (၁)</small>
                                        </div>
                                        <div class="col-4">
                                            <input type="file" name="img_2" class="form-control form-control-sm" accept="image/*">
                                            <small class="text-muted">ပုံ (၂)</small>
                                        </div>
                                        <div class="col-4">
                                            <input type="file" name="img_3" class="form-control form-control-sm" accept="image/*">
                                            <small class="text-muted">ပုံ (၃)</small>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <input type="file" name="img_4" class="form-control form-control-sm" accept="image/*">
                                            <small class="text-muted">ပုံ (၄)</small>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <input type="file" name="img_5" class="form-control form-control-sm" accept="image/*">
                                            <small class="text-muted">ပုံ (၅)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <h5 class="section-title">၃။ တည်နေရာနှင့် အချိန်ဇယား</h5>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Google Map Embed Link</label>
                                <input type="text" name="map_link" class="form-control" placeholder="https://www.google.com/maps/embed?pb=...">
                                <small class="text-muted">Google Map မှ Share > Embed a map > src ထဲက link ကို ကူးထည့်ပါ။</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ဖွင့်ချိန်/ပိတ်ချိန် (Opening Hours)</label>
                                <input type="text" name="opening_hours" class="form-control" placeholder="ဥပမာ- 9:00 AM - 5:00 PM (နေ့စဉ်)">
                            </div>
                        </div>

                        <div class="d-grid gap-2 col-md-8 mx-auto mt-5">
                            <button type="submit" name="save" class="btn btn-primary btn-save shadow-lg rounded-pill">
                                <i class="fas fa-cloud-upload-alt me-2"></i>အချက်အလက်အားလုံးကို သိမ်းဆည်းမည်
                            </button>
                            <a href="clinics_admindashboard.php" class="btn btn-link text-secondary">မသိမ်းဘဲ ပြန်ထွက်မည်</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>