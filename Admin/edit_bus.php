<?php
session_start();

// Fix the include path - use relative path correctly
include(__DIR__ . "/db.php");

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$busline_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch bus line data (with owner name and email from bus_users)
$query = "SELECT bl.*, bu.owner_name, bu.email 
          FROM bus_line bl 
          LEFT JOIN bus_users bu ON bl.user_id = bu.user_id 
          WHERE bl.busline_id = $busline_id AND bl.user_id = $user_id LIMIT 1";
$result = mysqli_query($db, $query);
$bus = mysqli_fetch_assoc($result);

if (!$bus) {
    die("<div class='container mt-5 text-center'><h4>Bus line not found or you don't have permission.</h4><a href='BusAdminDashboard.php' class='btn btn-primary'>Back</a></div>");
}

// Update logic
$upload_error = '';
if (isset($_POST['update_bus'])) {
    $busline_name = mysqli_real_escape_string($db, $_POST['busline_name']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $total_seat = mysqli_real_escape_string($db, $_POST['total_seat']);
    $car_color = mysqli_real_escape_string($db, $_POST['car_color']);

    // Image upload - FIXED: Use same pattern as route.php
    $img_update = "";
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/bus_images/";
        
        // Create directory if not exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Generate filename with time() to avoid duplicates
        $img_name = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['image']['name']);
        $target_file = $target_dir . $img_name;
        $file_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        
        if (in_array($file_ext, $allowed_ext)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Store just the filename in database (not full path)
                $img_update = ", image='$img_name'";
                
                // Delete old image if exists
                if (!empty($bus['image']) && file_exists($target_dir . $bus['image'])) {
                    unlink($target_dir . $bus['image']);
                }
            } else {
                $upload_error = "File upload failed. Check directory permissions.";
            }
        } else {
            $upload_error = "Invalid file type. Allowed: " . implode(', ', $allowed_ext);
        }
    }

    if (empty($upload_error)) {
        $update_sql = "UPDATE bus_line SET 
                        busline_name='$busline_name',
                        phone='$phone',
                        total_seat='$total_seat',
                        Car_color='$car_color'
                        $img_update 
                        WHERE busline_id=$busline_id AND user_id=$user_id";

        if (mysqli_query($db, $update_sql)) {
            echo "<script>alert('Bus line updated successfully!'); window.location='BusAdminDashboard.php#tab-bus';</script>";
            exit;
        } else {
            $upload_error = "Database update failed: " . mysqli_error($db);
        }
    }
}

// Function to get image URL
function getBusImageUrl($image_name) {
    if (!empty($image_name)) {
        return "uploads/bus_images/" . $image_name;
    }
    return "https://placehold.co/100x100/1e3c5c/ffffff?text=No+Image";
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bus Line | <?= htmlspecialchars($bus['busline_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f7f4;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .premium-wrapper {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }

        .premium-main-card {
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .premium-header {
            padding: 30px 40px 20px;
            border-bottom: 1px solid #edebe7;
        }

        .bus-brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .bus-icon-box {
            width: 56px;
            height: 56px;
            background: #1e3c5c;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 28px;
            box-shadow: 0 10px 20px -5px rgba(30, 60, 92, 0.3);
        }

        .bus-name {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: #1e3c5c;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .bus-type {
            font-size: 13px;
            color: #9b8e7f;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .premium-content {
            padding: 40px;
        }

        .form-label {
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #9b8e7f;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .input-group-custom {
            margin-bottom: 24px;
        }

        .input-group-custom .input-group-text {
            background: #f8f7f4;
            border: 1px solid #e5d5c5;
            border-right: none;
            border-radius: 16px 0 0 16px;
            color: #c4a079;
            padding: 0 18px;
        }

        .form-control-custom {
            width: 100%;
            padding: 14px 18px;
            background: #f8f7f4;
            border: 1px solid #e5d5c5;
            border-radius: 16px;
            font-size: 15px;
            color: #1e3c5c;
            transition: all 0.3s;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #c4a079;
            box-shadow: 0 5px 15px rgba(196, 160, 121, 0.1);
            background: #ffffff;
        }

        .form-control-custom[readonly] {
            background: #edebe7;
            border-color: #d4c5b5;
            color: #6b6259;
            cursor: not-allowed;
        }

        .row-custom {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
        }

        .row-custom > div {
            flex: 1;
        }

        .color-picker-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f8f7f4;
            border: 1px solid #e5d5c5;
            border-radius: 16px;
            padding: 8px 15px;
        }

        .color-picker-wrapper input[type="color"] {
            width: 50px;
            height: 40px;
            border: 2px solid #c4a079;
            border-radius: 10px;
            cursor: pointer;
            padding: 0;
            background: transparent;
        }

        .color-picker-wrapper span {
            color: #1e3c5c;
            font-weight: 500;
        }

        .image-preview-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .current-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 16px;
            border: 2px solid #c4a079;
        }

        .file-upload-area {
            flex: 1;
            background: #f8f7f4;
            border: 2px dashed #c4a079;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload-area:hover {
            background: #f0e9e2;
            border-color: #1e3c5c;
        }

        .file-upload-area i {
            font-size: 30px;
            color: #c4a079;
            margin-bottom: 5px;
        }

        .file-upload-area p {
            color: #1e3c5c;
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .file-upload-area small {
            color: #9b8e7f;
            font-size: 11px;
        }

        .file-upload-input {
            display: none;
        }

        .file-preview {
            display: none;
            background: #f0e9e2;
            border-radius: 12px;
            padding: 8px 15px;
            margin-top: 10px;
            color: #1e3c5c;
        }

        .file-preview i {
            color: #c4a079;
            margin-right: 8px;
        }

        .btn-submit {
            background: #1e3c5c;
            border: none;
            border-radius: 18px;
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 16px 40px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
        }

        .btn-submit:hover {
            background: #c4a079;
            color: #1e3c5c;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(196, 160, 121, 0.3);
        }

        .btn-cancel {
            background: transparent;
            border: 2px solid #e5d5c5;
            border-radius: 18px;
            color: #9b8e7f;
            font-weight: 500;
            font-size: 14px;
            padding: 14px;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            border-color: #c4a079;
            color: #1e3c5c;
        }

        .info-row {
            background: #f8f7f4;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 25px;
            border: 1px solid #e5d5c5;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .info-item i {
            width: 24px;
            color: #c4a079;
        }

        .info-item span {
            color: #1e3c5c;
        }

        .alert {
            padding: 15px;
            border-radius: 16px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-danger {
            background: #ffe6e6;
            border-left-color: #dc3545;
            color: #721c24;
        }

        /* Debug info - remove after fixing */
        .debug-info {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #333;
            border-left: 4px solid #c4a079;
        }
    </style>
</head>
<body>

<div class="premium-wrapper">
    <div class="premium-main-card">
        <!-- Header -->
        <div class="premium-header">
            <div class="bus-brand">
                <div class="bus-icon-box">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <div class="bus-name">Edit Bus Line</div>
                    <div class="bus-type"><?= htmlspecialchars($bus['busline_name']) ?></div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="premium-content">
            <?php if (!empty($upload_error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $upload_error ?>
                </div>
            <?php endif; ?>

            <!-- Debug info - remove after fixing -->
            <div class="debug-info">
                <strong>Debug:</strong> Image in database: "<?= htmlspecialchars($bus['image']) ?>"<br>
                <strong>Image URL:</strong> <?= getBusImageUrl($bus['image']) ?><br>
                <strong>File exists:</strong> <?= (!empty($bus['image']) && file_exists("uploads/bus_images/" . $bus['image'])) ? 'Yes' : 'No' ?>
            </div>

            <!-- Fixed information (read-only) - including email -->
            <div class="info-row">
                <div class="info-item">
                    <i class="fas fa-user"></i>
                    <span><strong>ပိုင်ရှင်:</strong> <?= htmlspecialchars($bus['owner_name']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <span><strong>Email:</strong> <?= htmlspecialchars($bus['email']) ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><strong>လိပ်စာ:</strong> <?= htmlspecialchars($bus['address']) ?></span>
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <!-- Image (editable) -->
                <div class="form-label">ကားပုံ</div>
                <div class="image-preview-wrapper">
                    <img src="<?= getBusImageUrl($bus['image']) ?>" class="current-image" id="previewImage" onerror="this.src='https://placehold.co/100x100/1e3c5c/ffffff?text=Error'">
                    <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>ပုံအသစ်တင်ရန် နှိပ်ပါ</p>
                        <small>JPG, PNG, WEBP</small>
                        <input type="file" name="image" id="fileInput" class="file-upload-input" accept="image/*">
                    </div>
                </div>
                <div id="filePreview" class="file-preview">
                    <i class="fas fa-check-circle"></i> <span id="fileName"></span>
                </div>

                <!-- Bus Number (editable) -->
                <div class="input-group-custom">
                    <label class="form-label">ကားနံပါတ်</label>
                    <div class="d-flex">
                        <span class="input-group-text"><i class="fas fa-bus-alt"></i></span>
                        <input type="text" name="busline_name" class="form-control-custom" value="<?= htmlspecialchars($bus['busline_name']) ?>" style="border-radius: 0 16px 16px 0; border-left: none;" required>
                    </div>
                </div>

                <!-- Phone & Total Seats -->
                <div class="row-custom">
                    <div>
                        <label class="form-label">ဖုန်းနံပါတ်</label>
                        <input type="text" name="phone" class="form-control-custom" value="<?= htmlspecialchars($bus['phone']) ?>" required>
                    </div>
                    <div>
                        <label class="form-label">ခုံအရေအတွက်</label>
                        <input type="number" name="total_seat" class="form-control-custom" value="<?= htmlspecialchars($bus['total_seat']) ?>" min="1" required>
                    </div>
                </div>

                <!-- Color (editable) -->
                <div class="form-label">ကားအရောင်</div>
                <div class="color-picker-wrapper">
                    <input type="color" name="car_color" id="colorPicker" value="<?= htmlspecialchars($bus['Car_color'] ?: '#1e3c5c') ?>">
                    <span id="colorValue"><?= htmlspecialchars($bus['Car_color'] ?: '#1e3c5c') ?></span>
                </div>

                <!-- Buttons -->
                <button type="submit" name="update_bus" class="btn-submit" style="margin-top: 30px;">
                    <i class="fas fa-save"></i> သိမ်းဆည်းမည်
                </button>
                <a href="BusAdminDashboard.php#tab-bus" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>မလုပ်တော့ပါ
                </a>
            </form>
        </div>
    </div>
</div>

<script>
// Color picker preview
const colorPicker = document.getElementById('colorPicker');
const colorValue = document.getElementById('colorValue');

colorPicker.addEventListener('input', function() {
    colorValue.textContent = this.value;
});

// File input preview and instant image preview
const fileInput = document.getElementById('fileInput');
const filePreview = document.getElementById('filePreview');
const fileName = document.getElementById('fileName');
const previewImage = document.getElementById('previewImage');

fileInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        // Show file name
        fileName.textContent = this.files[0].name;
        filePreview.style.display = 'block';
        
        // Show image preview instantly
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    } else {
        filePreview.style.display = 'none';
    }
});
</script>

</body>
</html>