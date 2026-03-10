<?php
session_start();
include("db.php");

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ၂။ Form Submission Logic (One Bus One Route Logic ထည့်သွင်းထားသည်)
if (isset($_POST['submit_route'])) {
    // ✅ busline_id ကို ရယူခြင်း (ကားလိုင်းရွေးချယ်မှု)
    $busline_id = intval($_POST['busline_id']);
    
    $route_name = mysqli_real_escape_string($db, $_POST['route_name']);
    $start_point = mysqli_real_escape_string($db, $_POST['start_point']);
    $end_point = mysqli_real_escape_string($db, $_POST['end_point']);
    $time = mysqli_real_escape_string($db, $_POST['time']); 
    $price = intval($_POST['price']);
    $final_date = mysqli_real_escape_string($db, $_POST['route_date']); 

    // 🔒 SECURITY CHECK 1: ဤ user ပိုင်ဆိုင်သော busline ဟုတ်/မဟုတ် စစ်ဆေးခြင်း
    $check_owner = mysqli_query($db, "SELECT busline_id FROM bus_line WHERE busline_id = $busline_id AND user_id = $user_id LIMIT 1");
    if (mysqli_num_rows($check_owner) == 0) {
        echo "<script>alert('❌ Error: ဤကားလိုင်းကို သင်ဝင်ရောက်စီမံခွင့်မရှိပါ!'); window.history.back();</script>";
        exit;
    }
    
    // 🔒 ONE BUS ONE ROUTE CHECK: ဤ busline_id တွင် ရှိပြီးသား route ရှိ/မရှိ စစ်ဆေးခြင်း
    $check_existing = mysqli_query($db, "SELECT id FROM bus_route WHERE busline_id = $busline_id LIMIT 1");
    if (mysqli_num_rows($check_existing) > 0) {
        echo "<script>alert('❌ ဤကားလိုင်းတွင် လမ်းကြောင်းရှိပြီးဖြစ်ပါသည်။\\nတစ်ကားလျှင် တစ်လမ်းကြောင်းသာ သတ်မှတ်နိုင်ပါသည်။'); window.history.back();</script>";
        exit;
    }

    // ပုံတင်သည့် Logic
    $img_name = "";
    if (!empty($_FILES['bus_image']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['bus_image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            $img_name = time() . "_" . uniqid() . "." . $file_ext;
            $tmp_name = $_FILES['bus_image']['tmp_name'];
            $upload_path = "uploads/" . $img_name;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            move_uploaded_file($tmp_name, $upload_path);
        }
    }

    // ✅ Insert Query - busline_id ထည့်သွင်းထားသည် (One Bus One Route)
    $query = "INSERT INTO bus_route (user_id, busline_id, route_name, start_point, end_point, time, Date, price, image) 
              VALUES ('$user_id', '$busline_id', '$route_name', '$start_point', '$end_point', '$time', '$final_date', '$price', '$img_name')";
    
    if (mysqli_query($db, $query)) {
        echo "<script>alert('✅ လမ်းကြောင်းအသစ် ထည့်သွင်းပြီးပါပြီ'); window.location='BusAdminDashboard.php#tab-route';</script>";
    } else {
        // UNIQUE constraint error check
        if (mysqli_errno($db) == 1062) {
            echo "<script>alert('❌ ဤကားလိုင်းတွင် လမ်းကြောင်းရှိပြီးဖြစ်ပါသည်။'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($db) . "');</script>";
        }
    }
}

// ၃။ Dropdown အတွက်: လွတ်နေသော ကားလိုင်းများကိုသာ ဆွဲထုတ်ခြင်း (One Bus One Route)
$available_buses_query = "SELECT bl.busline_id, bl.busline_name, bl.total_seat, bl.Car_color 
                          FROM bus_line bl 
                          LEFT JOIN bus_route br ON bl.busline_id = br.busline_id 
                          WHERE bl.user_id = $user_id 
                          AND br.busline_id IS NULL  -- ✅ Route မရှိသေးသော ကားများကိုသာ ယူမည်
                          AND bl.status = 'active'
                          ORDER BY bl.busline_name";
$available_buses = mysqli_query($db, $available_buses_query);

// ✅ ရှိပြီးသား ကားလိုင်းများ (ပိတ်ထားရန်အတွက် - ပြသရန်သာ)
$used_buses_query = "SELECT bl.busline_id, bl.busline_name, br.route_name, br.start_point, br.end_point
                     FROM bus_line bl 
                     INNER JOIN bus_route br ON bl.busline_id = br.busline_id 
                     WHERE bl.user_id = $user_id 
                     ORDER BY bl.busline_name";
$used_buses = mysqli_query($db, $used_buses_query);

// ✅ Color Helper Function (Car_color int ကို hex အဖြစ်ပြန်ပြောင်းရန်)
function intToHexColor($intColor) {
    if (empty($intColor) || $intColor == 0) return '#6c757d';
    return sprintf("#%06X", $intColor);
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Route | Admin</title>
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
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 700px;
        }

        .form-label {
            color: #00d2ff;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            color: white !important;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #00d2ff;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.4);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
            opacity: 1;
        }
        
        .form-select option { background: #1a2a3a; color: white; }
        .form-select option:disabled { color: #6c757d; font-style: italic; }

        .preview-zone {
            border: 2px dashed rgba(0, 210, 255, 0.5);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            transition: 0.3s;
        }
        .preview-zone:hover {
            border-color: #00d2ff;
            background: rgba(0, 210, 255, 0.1);
        }

        .input-group-text {
            background: rgba(0, 210, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            font-weight: bold;
        }

        .btn-save {
            background: linear-gradient(45deg, #00c853, #64dd17);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: bold;
            color: white;
            transition: 0.3s;
        }

        .btn-save:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(100, 221, 23, 0.4);
        }
        .btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
            padding: 10px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ff4d4d;
        }

        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
            scale: 1.2;
        }
        
        .one-bus-notice {
            background: rgba(0, 210, 255, 0.15);
            border: 1px solid rgba(0, 210, 255, 0.4);
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }
        .one-bus-notice i { color: #00d2ff; font-size: 1.1rem; }
        
        .used-bus-list {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.3);
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;
            max-height: 150px;
            overflow-y: auto;
        }
        .used-bus-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 0.85rem;
        }
        .used-bus-item:last-child { border-bottom: none; }
        .used-bus-item i { color: #e74c3c; margin-right: 6px; }
        .used-bus-route {
            background: rgba(0, 210, 255, 0.2);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
        }
        
        .bus-preview-info {
            background: rgba(0, 210, 255, 0.1);
            border-left: 3px solid #00d2ff;
            padding: 10px 15px;
            margin-top: 10px;
            border-radius: 0 8px 8px 0;
            font-size: 0.9rem;
            display: none;
        }
        .bus-preview-info.show { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
        
        .color-dot {
            width: 16px; height: 16px; border-radius: 50%;
            display: inline-block; border: 2px solid white;
            vertical-align: middle; margin-right: 5px;
        }
    </style>
</head>
<body>

    <div class="glass-card shadow">
        <div class="text-center mb-4">
            <h4 class="fw-bold m-0"><i class="fas fa-link me-2 text-info"></i>Add New Route</h4>
            <p class="text-white-50 small mt-1">တစ်ကားလျှင် တစ်လမ်းကြောင်းသာ သတ်မှတ်နိုင်ပါသည်</p>
        </div>

        <!-- ⚠️ One Bus One Rule Notice -->
        <div class="one-bus-notice">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>သတိပြုရန်:</strong> တစ်ကားလိုင်းလျှင် တစ်လမ်းကြောင်းသာ သတ်မှတ်နိုင်ပါသည်။<br>
                <small class="opacity-75">ကားအသစ်ထပ်ထည့်ပြီးမှသာ နောက်ထပ်လမ်းကြောင်း ထပ်မံသတ်မှတ်နိုင်ပါမည်။</small>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            
            <!-- ✅ BUS LINE SELECTION - လွတ်နေသောကားများကိုသာ ရွေးခွင့်ပြုမည် -->
            <div class="mb-4">
                <label class="form-label">ကားလိုင်း ရွေးချယ်ပါ <span class="text-danger">*</span></label>
                <select name="busline_id" class="form-select" id="busSelect" required>
                    <option value="">-- ကားလိုင်းရွေးပါ --</option>
                    <?php 
                    if (mysqli_num_rows($available_buses) > 0) {
                        while ($bus = mysqli_fetch_assoc($available_buses)) {
                            $colorHex = intToHexColor($bus['Car_color']);
                            echo "<option value='{$bus['busline_id']}' data-color='{$colorHex}'>
                                    {$bus['busline_name']} (ခုံ: {$bus['total_seat']})
                                  </option>";
                        }
                    } else {
                        echo "<option value='' disabled>✅ ကားအားလုံးတွင် လမ်းကြောင်းရှိပြီးပါသည်</option>";
                    }
                    ?>
                </select>
                
                <!-- Bus Info Preview -->
                <div id="busPreview" class="bus-preview-info">
                    <i class="fas fa-bus me-2"></i>
                    <span id="busPreviewText">ရွေးလိုက်သော ကားလိုင်းအတွက်သာ ဤခရီးစဉ်ကို သတ်မှတ်နိုင်ပါမည်။</span>
                </div>
                
                <!-- ❌ ရှိပြီးသားကားများကို ပြသခြင်း -->
                <?php if (mysqli_num_rows($used_buses) > 0): ?>
                <div class="used-bus-list">
                    <small class="text-muted d-block mb-2">🔒 ရှိပြီးသား ကားလိုင်းများ (ရွေး၍မရပါ):</small>
                    <?php while($used = mysqli_fetch_assoc($used_buses)): 
                        $start = htmlspecialchars($used['start_point']);
                        $end = htmlspecialchars($used['end_point']);
                    ?>
                    <div class="used-bus-item">
                        <span><i class="fas fa-lock"></i> <?= htmlspecialchars($used['busline_name']) ?></span>
                        <span class="used-bus-route"><?= $start ?> → <?= $end ?></span>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="form-label">ကားပုံတင်ရန်</label>
                <div class="preview-zone" onclick="document.querySelector('input[name=bus_image]').click()">
                    <i class="fas fa-cloud-upload-alt me-2"></i>ပုံရွေးချယ်ရန် နှိပ်ပါ
                    <input type="file" name="bus_image" class="form-control d-none" accept="image/*" id="busImageInput">
                </div>
                <small class="text-muted opacity-75 d-block mt-1" id="fileName"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">လမ်းကြောင်းအမည်</label>
                <input type="text" name="route_name" class="form-control" placeholder="ဥပမာ - မနက်ခရီးစဉ် (1)" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label">စထွက်မည့်နေရာ</label>
                    <input type="text" name="start_point" class="form-control" placeholder="မြို့အမည် ရိုက်ပါ" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ဆိုက်ရောက်မည့်နေရာ</label>
                    <input type="text" name="end_point" class="form-control" placeholder="မြို့အမည် ရိုက်ပါ" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label">ထွက်ခွာမည့်ရက်စွဲ</label>
                    <input type="date" name="route_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ထွက်ခွာမည့်အချိန်</label>
                    <input type="time" name="time" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">ဈေးနှုန်း (Price)</label>
                <div class="input-group">
                    <input type="number" name="price" class="form-control" placeholder="ဥပမာ- 25000" min="0" required>
                    <span class="input-group-text">Ks</span>
                </div>
            </div>

            <div class="d-grid gap-3">
                <button type="submit" name="submit_route" class="btn btn-save" id="submitBtn" disabled>
                    <i class="fas fa-save me-2"></i>လမ်းကြောင်းသိမ်းမည်
                </button>
                <a href="BusAdminDashboard.php#tab-route" class="btn btn-cancel text-center">
                    မလုပ်တော့ပါ (Cancel)
                </a>
            </div>
        </form>
    </div>

<script>
// Bus Select Change - Submit Button Enable/Disable + Preview Update
const busSelect = document.getElementById('busSelect');
const submitBtn = document.getElementById('submitBtn');
const busPreview = document.getElementById('busPreview');
const busPreviewText = document.getElementById('busPreviewText');

busSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    // Enable/Disable Submit Button
    submitBtn.disabled = !this.value;
    
    // Update Preview
    if (this.value && selectedOption.dataset.color) {
        busPreview.classList.add('show');
        const colorDot = `<span class="color-dot" style="background:${selectedOption.dataset.color}"></span>`;
        busPreviewText.innerHTML = colorDot + ' ရွေးလိုက်သော ကားလိုင်းအတွက်သာ ဤခရီးစဉ်ကို သတ်မှတ်နိုင်ပါမည်။';
    } else {
        busPreview.classList.remove('show');
    }
});

// File name preview + click zone
const fileInput = document.getElementById('busImageInput');
const fileName = document.getElementById('fileName');
const previewZone = document.querySelector('.preview-zone');

fileInput.addEventListener('change', function(e) {
    const name = e.target.files[0]?.name;
    if(name) {
        fileName.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i> ${name}`;
        previewZone.innerHTML = `<i class="fas fa-image me-2 text-info"></i> ${name}`;
    }
});

// Allow clicking the preview zone to open file picker
previewZone.addEventListener('click', function() {
    fileInput.click();
});
</script>

</body>
</html>