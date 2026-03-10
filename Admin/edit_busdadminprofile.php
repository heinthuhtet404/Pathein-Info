<?php
session_start();
include("db.php");

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ၂။ လက်ရှိ Admin Data ကို Table ထဲပြဖို့ ဆွဲထုတ်ခြင်း
$query = "SELECT * FROM bus_users WHERE user_id = $user_id LIMIT 1";
$result = mysqli_query($db, $query);
$admin = mysqli_fetch_assoc($result);

// ၃။ Update Logic (Save ခလုတ်နှိပ်သည့်အခါ)
if (isset($_POST['update_profile'])) {
    // ပြင်လို့ရတဲ့ field များ
    $phone   = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);

    // ပုံအသစ်တင်ခဲ့လျှင်
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
        $img_update = ", image='$image_name'";
    } else {
        $img_update = "";
    }

    // ပြင်မည့် field များကိုပဲ update လုပ်မည် (cargate_name, owner_name, email ကို မပြင်ရ)
    $update_sql = "UPDATE bus_users SET 
                    phone='$phone', 
                    address='$address' 
                    $img_update 
                    WHERE user_id=$user_id";

    if (mysqli_query($db, $update_sql)) {
        echo "<script>alert('Profile Updated Successfully!'); window.location='BusAdminDashboard.php';</script>";
    } else {
        echo "<script>alert('Update Failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 30px;
        }
        .table { color: white !important; vertical-align: middle; }
        .table td { border-color: rgba(255,255,255,0.1); padding: 15px 10px; }
        .form-control, .form-control-plaintext {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
        }
        .form-control:focus {
            background: rgba(0,0,0,0.5);
            color: white;
            border-color: #00d2ff;
            box-shadow: none;
        }
        .form-control[readonly] {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.1);
            color: #151414;
            cursor: not-allowed;
        }
        .profile-preview {
            width: 100px; height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #00d2ff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-container shadow-lg">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-info m-0"><i class="fa fa-user-gear me-2"></i> Edit Admin Profile</h4>
                    <a href="BusAdminDashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to Dashboard</a>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="30%"><i class="fa fa-image me-2 text-info"></i> Profile Photo</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="uploads/<?= $admin['image'] ?>" class="profile-preview" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><i class="fa fa-bus me-2 text-info"></i> Car Gate Name</td>
                                    <td>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($admin['cargate_name']) ?>" readonly>
                                        <!-- fixed field, no name attribute, so it won't be submitted -->
                                    </td>
                                </tr>

                                <tr>
                                    <td><i class="fa fa-user me-2 text-info"></i> Owner Name</td>
                                    <td>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($admin['owner_name']) ?>" readonly>
                                    </td>
                                </tr>

                                <tr>
                                    <td><i class="fa fa-envelope me-2 text-info"></i> Email Address</td>
                                    <td>
                                        <input type="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" readonly>
                                    </td>
                                </tr>

                                <tr>
                                    <td><i class="fa fa-phone me-2 text-info"></i> Phone Number</td>
                                    <td>
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($admin['phone']) ?>" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td><i class="fa fa-map-marker-alt me-2 text-info"></i> Address</td>
                                    <td>
                                        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($admin['address']) ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <button type="reset" class="btn btn-link text-white text-decoration-none me-3">Reset Changes</button>
                        <button type="submit" name="update_profile" class="btn btn-info text-white px-5 rounded-pill fw-bold shadow">
                            <i class="fa fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>