<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if (!isset($_GET['id'])) { header("Location: clinics_admindashboard.php"); exit; }

$doctor_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// လက်ရှိ Doctor ရဲ့ data ကို ဆွဲထုတ်ခြင်း (booking_limit ပါ ဆွဲထုတ်မည်)
$res = mysqli_query($db, "SELECT * FROM doctors WHERE doctor_id = '$doctor_id'");
$doctor = mysqli_fetch_assoc($res);

if (!$doctor) { echo "Doctor not found!"; exit; }

$current_days = explode(", ", $doctor['available_days']);

if (isset($_POST['update_doctor'])) {
    $name = mysqli_real_escape_string($db, $_POST['doctor_name']);
    $degree = mysqli_real_escape_string($db, $_POST['degree']);
    $spec = mysqli_real_escape_string($db, $_POST['specialization']);
    $exp = mysqli_real_escape_string($db, $_POST['experience']);
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $limit = mysqli_real_escape_string($db, $_POST['booking_limit']); // Limit လက်ခံခြင်း
    $days = isset($_POST['days']) ? implode(", ", $_POST['days']) : $doctor['available_days'];

    if ($_FILES['doctor_image']['name']) {
        $img_name = time() . "_" . $_FILES['doctor_image']['name'];
        move_uploaded_file($_FILES['doctor_image']['tmp_name'], "uploads/" . $img_name);
        $img_query = ", doctor_image = '$img_name'";
    } else {
        $img_query = "";
    }

    // UPDATE query ထဲတွင် booking_limit ကို ထည့်သွင်းခြင်း
    $sql = "UPDATE doctors SET 
            doctor_name='$name', degree='$degree', specialization='$spec', 
            experience='$exp', start_time='$start', end_time='$end', 
            booking_limit='$limit', available_days='$days' $img_query 
            WHERE doctor_id='$doctor_id'";

    if (mysqli_query($db, $sql)) {
        echo "<script>alert('Updated successfully!'); window.location.href='clinics_admindashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Edit Doctor Profile</title>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow border-0 col-lg-6 mx-auto rounded-4">
        <div class="card-header bg-success text-white text-center py-3">
            <h5 class="mb-0"><i class="fas fa-user-md me-2"></i> Edit Doctor Profile</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">
                
                <div class="mb-3 text-center">
                    <?php if($doctor['doctor_image']): ?>
                        <img src="uploads/<?php echo $doctor['doctor_image']; ?>" width="100" height="100" class="rounded-circle mb-2 border border-3 border-success" style="object-fit: cover;">
                    <?php endif; ?>
                    <input type="file" name="doctor_image" class="form-control">
                    <small class="text-muted">Leave blank to keep current photo</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Doctor Name</label>
                    <input type="text" name="doctor_name" class="form-control" value="<?php echo $doctor['doctor_name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Degree (ဘွဲ့)</label>
                    <input type="text" name="degree" class="form-control" value="<?php echo $doctor['degree']; ?>" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 text-primary">
                        <label class="form-label fw-bold"><i class="fas fa-users me-1"></i> Daily Booking Limit</label>
                        <input type="number" name="booking_limit" class="form-control border-primary shadow-sm" value="<?php echo $doctor['booking_limit'] ?? 20; ?>" required min="1">
                        <small class="text-muted small">တစ်ရက်လက်ခံမည့် လူနာဦးရေ</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="<?php echo $doctor['specialization']; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Experience</label>
                        <input type="text" name="experience" class="form-control" value="<?php echo $doctor['experience']; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Duty Start</label>
                        <input type="time" name="start_time" class="form-control" value="<?php echo $doctor['start_time']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Duty End</label>
                    <input type="time" name="end_time" class="form-control" value="<?php echo $doctor['end_time']; ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block fw-bold">Duty Days</label>
                    <?php 
                    $weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    foreach($weekdays as $day): 
                        $checked = in_array($day, $current_days) ? "checked" : "";
                    ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="days[]" value="<?php echo $day; ?>" <?php echo $checked; ?>>
                            <label class="form-check-label"><?php echo $day; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="update_doctor" class="btn btn-success py-2 fw-bold">Update Changes</button>
                    <a href="clinics_admindashboard.php" class="btn btn-light border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>