<?php
session_start();
include 'db.php';

if (!isset($_SESSION['business_id'])) { header("Location: business_man_login.php"); exit; }

$user_id = $_SESSION['business_id'];
$clinic_q = mysqli_query($db, "SELECT clinics_id FROM clinics WHERE user_id = '$user_id'");
$clinic = mysqli_fetch_assoc($clinic_q);
$clinics_id = $clinic['clinics_id'];

if (isset($_POST['save_doctor'])) {
    $doctor_name = mysqli_real_escape_string($db, $_POST['doctor_name']);
    $degree = mysqli_real_escape_string($db, $_POST['degree']);
    $specialization = mysqli_real_escape_string($db, $_POST['specialization']);
    $experience = mysqli_real_escape_string($db, $_POST['experience']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $available_days = isset($_POST['days']) ? implode(", ", $_POST['days']) : "Not specified";

    // ပုံတင်ခြင်း Logic
    $img_name = $_FILES['doctor_image']['name'];
    $tmp_name = $_FILES['doctor_image']['tmp_name'];
    $img_upload_path = "";

    if ($img_name) {
        $img_upload_path = time() . "_" . $img_name;
        move_uploaded_file($tmp_name, "uploads/" . $img_upload_path);
    }

    $query = "INSERT INTO doctors (clinics_id, doctor_name, degree, doctor_image, specialization, experience, available_days, start_time, end_time) 
              VALUES ('$clinics_id', '$doctor_name', '$degree', '$img_upload_path', '$specialization', '$experience', '$available_days', '$start_time', '$end_time')";

    if (mysqli_query($db, $query)) {
        echo "<script>alert('Doctor added successfully!'); window.location.href='clinics_admindashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; border: none; }
        .card-header { border-radius: 15px 15px 0 0 !important; font-weight: bold; }
        .form-label { font-weight: 600; margin-top: 10px; }
        .btn-save { background-color: #0d6efd; color: white; border-radius: 8px; padding: 10px; font-weight: bold; }
        .btn-save:hover { background-color: #0b5ed7; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0">👨‍⚕️ ဆရာဝန်အသစ်ထည့်ရန်</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3 text-center">
                            <label class="form-label d-block">ဆရာဝန် ဓတ်ပုံ</label>
                            <input type="file" name="doctor_image" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ဆရာဝန် အမည်</label>
                            <input type="text" name="doctor_name" class="form-control" placeholder="Dr. Aung Aung" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ဘွဲ့</label>
                            <input type="text" name="degree" class="form-control" placeholder="M.B.,B.S" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">အထူပြု</label>
                                <input type="text" name="specialization" class="form-control" placeholder="ဥပမာ- ကလေးအထူးကု">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">အတွေ့အကြုံ</label>
                                <input type="text" name="experience" class="form-control" placeholder="ဥပမာ- 5 Years">
                            </div>
                        </div>
                        <div class="mb-3">
    <label class="form-label fw-bold">တစ်နေ့တာ လူနာလက်ခံနိုင်သည့်အရေအတွက်</label>
    <input type="number" name="booking_limit" class="form-control" value="10" min="1">
    <small class="text-muted">* တစ်နေ့လျှင် လူနာ အယောက်မည်မျှအထိ ဘိုကင်တင်ခွင့်ပြုမည်ကို သတ်မှတ်ပါ။</small>
</div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">တာဝန်စချိန်</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">တာဝန်ပြီးချိန်</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">ဝာာဝန်ကျသောရက်</label>
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                <?php foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="<?php echo $day; ?>" id="day-<?php echo $day; ?>">
                                        <label class="form-check-label" for="day-<?php echo $day; ?>"><?php echo $day; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="save_doctor" class="btn btn-save btn-lg">
                                သိမ်းမည်
                            </button>
                            <a href="clinics_admindashboard.php" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> နောက်သို့</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>