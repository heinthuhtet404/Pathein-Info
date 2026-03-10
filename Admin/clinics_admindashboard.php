<?php
session_start();
include 'db.php';



// ၁။ Login Check
if (!isset($_SESSION['business_id'])) {
    header("Location: business_man_login.php");
    exit;
}

$user_id = $_SESSION['business_id']; // ✔ အရင် assign

// debug
// echo "Session business id = " . $_SESSION['business_id'] . "<br>";
// echo "Session id = ".$user_id."<br>";

// $query = "SELECT * FROM clinics WHERE user_id = '$user_id'";
// $result = mysqli_query($db,$query);

// echo "Rows = ".mysqli_num_rows($result)."<br>";

// ၂။ ဆေးခန်းဒေတာ ဆွဲထုတ်ခြင်း
$query = "SELECT * FROM clinics WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($db, $query);
$clinic = mysqli_fetch_assoc($result);

if (!$clinic) {
    header("Location: register_health.php");
    exit;
}

$clinics_id = $clinic['clinics_id'];

// ၃။ စာမျက်နှာဖွင့်လျှင် Noti Reset လုပ်ခြင်း
mysqli_query($db, "UPDATE appointments SET is_notified = 1 WHERE clinics_id = '$clinics_id' AND is_notified = 0");

// ၄။ Status Update (Confirm/Cancel) Logic
if (isset($_GET['action']) && isset($_GET['app_id'])) {
    $app_id = mysqli_real_escape_string($db, $_GET['app_id']);
    $status = ($_GET['action'] == 'confirm') ? 'confirmed' : 'cancelled';
    mysqli_query($db, "UPDATE appointments SET status = '$status' WHERE appointment_id = '$app_id' AND clinics_id = '$clinics_id'");
    header("Location: clinics_admindashboard.php");
}

// ၅။ Stats တွက်ချက်ခြင်း
$today = date('Y-m-d');
$total_app = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM appointments WHERE clinics_id = '$clinics_id'"));
$today_app = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM appointments WHERE clinics_id = '$clinics_id' AND appointment_date = '$today' AND status != 'cancelled'"));
$total_docs = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM doctors WHERE clinics_id = '$clinics_id'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: #212529; color: white; position: sticky; top: 0; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #0d6efd; color: white; }
        .clinic-logo { width: 70px; height: 70px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; }
        .card { border: none; border-radius: 12px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); }
        .pulse-alert { animation: pulse-red 2s infinite; display: none; cursor: pointer; }
        @keyframes pulse-red {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { transform: scale(1.03); box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0 sidebar shadow">
            <div class="p-4 text-center border-bottom border-secondary">
                <?php if ($clinic['clinics_logo']): ?>
                    <img src="uploads/<?php echo $clinic['clinics_logo']; ?>" class="clinic-logo mb-2">
                <?php else: ?>
                    <i class="fas fa-hospital-user fa-3x mb-2 text-primary"></i>
                <?php endif; ?>
                <h6 class="text-white mb-0 small"><?php echo htmlspecialchars($clinic['clinics_name']); ?></h6>
            </div>
            <nav class="mt-3">
                <a href="clinics_admindashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i> ခြုံငုံသုံးသပ်ချက်</a>
                <a href="view_appointments.php"><i class="fas fa-calendar-check me-2"></i> ကြိုတင်ချိန်းဆိုထားသည်များ</a>
                <a href="#doctors"><i class="fas fa-user-md me-2"></i> ဆရာဝန်နှင့်အချိန်စယား</a>
                <a href="add_doctor.php"><i class="fas fa-plus-circle me-2"></i> ဆရာဝန်အသစ်ထည့်ရန်</a>
                <a href="edit_clinic.php"><i class="fas fa-edit me-2"></i> Edit Profile</a>
                <hr class="mx-3 border-secondary">
                <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </nav>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark"><i class="fas fa-chart-line text-primary me-2"></i> ဆေးခန်း ခြုံငုံသုံးသပ်ချက်</h4>
                
                <div id="newActivityAlert" class="pulse-alert badge bg-danger p-2 px-3 rounded-pill" onclick="location.reload()">
                    <i class="fas fa-bell me-2"></i> ဘိုကင်အသစ် <span id="notiCount">0</span> ခု ရှိနေပါသည်
                </div>

                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">Clinic Status: Open</span>
            </div>

            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 border-start border-primary border-5">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x text-primary me-3"></i>
                            <div><h3 class="mb-0 fw-bold"><?php echo $total_app['total']; ?></h3><p class="text-muted mb-0">စုစုပေါင်း ကြိုတင်ချန်းဆိုထားသည်များ</p></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 border-start border-info border-5">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-md fa-2x text-info me-3"></i>
                            <div><h3 class="mb-0 fw-bold"><?php echo $total_docs['total']; ?></h3><p class="text-muted mb-0">ဆရာဝန်များ</p></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 border-start border-success border-5">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-check fa-2x text-success me-3"></i>
                            <div><h3 class="mb-0 fw-bold"><?php echo $today_app['total']; ?></h3><p class="text-muted mb-0">ယနေ့လူနာ</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-5">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">မကြာသေးမီက ချိန်းဆိုမှုများ</h5>
                    <a href="view_appointments.php" class="btn btn-sm btn-outline-primary px-3">အားလုံးကြည့်ရန်</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small">
                                <tr>
                                    <th>လူနာအမည်</th>
                                    <th>အချိန်နှင့်ရက်စွဲ</th>
                                    <th>ဆရာဝန်</th>
                                    <th>အခြေအနေ</th>
                                    <th class="text-center">လုပ်ဆောင်ချက်</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $app_q = "SELECT a.*, d.doctor_name FROM appointments a 
                                          LEFT JOIN doctors d ON a.doctor_id = d.doctor_id
                                          WHERE a.clinics_id = '$clinics_id' 
                                          ORDER BY a.appointment_id DESC LIMIT 5";
                                $app_res = mysqli_query($db, $app_q);
                                while($app = mysqli_fetch_assoc($app_res)):
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo htmlspecialchars($app['patient_name']); ?></div>
                                        <small class="text-muted"><i class="fas fa-phone-alt me-1"></i><?php echo $app['patient_phone']; ?></small>
                                    </td>
                                    <td><?php echo $app['appointment_date']; ?><br><small class="text-muted"><?php echo $app['appointment_time']; ?></small></td>
                                    <td> <?php echo htmlspecialchars($app['doctor_name']); ?></td>
                                    <td>
                                        <?php if($app['status'] == 'pending'): ?>
                                            <span class="badge bg-warning-subtle text-warning border px-3">စောင့်စိုင်းနေသည်</span>
                                        <?php elseif($app['status'] == 'confirmed'): ?>
                                            <span class="badge bg-success px-3">အတည်ပြုပြီး</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3">ပယ်ဖျက်ပြီး</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($app['status'] == 'pending'): ?>
                                            <a href="?action=confirm&app_id=<?php echo $app['appointment_id']; ?>" class="btn btn-sm btn-success rounded-pill px-3">အတည်ပြသည်</a>
                                            <a href="?action=cancel&app_id=<?php echo $app['appointment_id']; ?>" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-times"></i></a>
                                        <?php else: ?>
                                            <small class="text-muted">လုပ်ဆောင်ချက်မရှိပါ</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="doctors" class="card shadow-sm mb-5 border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">တာဝန်ကျသောဆရာဝန်အချိန်စရင်း</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-dark small">
                                <tr>
                                    <th>ဆရာဝန်အမည်</th>
                                    <th>အထူးပြု</th>
                                    <th>တာဝန်ကျသောရက်</th>
                                    <th>တာဝန်ကျသောအချိန်</th>
                                    <th>လူဦးရေအကန့်အသက်</th>
                                    <th>လုပ်ဆောင်ချက်</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $doc_list = mysqli_query($db, "SELECT * FROM doctors WHERE clinics_id = '$clinics_id'");
                                while($doc = mysqli_fetch_assoc($doc_list)):
                                ?>
                                <tr>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <?php if($doc['doctor_image']): ?>
                                                <img src="uploads/<?php echo $doc['doctor_image']; ?>" width="40" height="40" class="rounded-circle me-2">
                                            <?php else: ?>
                                                <i class="fas fa-user-md fa-2x text-secondary me-2"></i>
                                            <?php endif; ?>
                                            <div class="fw-bold small">Dr. <?php echo $doc['doctor_name']; ?></div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info-subtle text-info border small"><?php echo $doc['specialization']; ?></span></td>
                                    <td class="small fw-bold text-primary"><?php echo $doc['available_days']; ?></td>
                                    <td class="small">
                                        <?php echo date("h:i A", strtotime($doc['start_time'])) . " - " . date("h:i A", strtotime($doc['end_time'])); ?>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?php echo $doc['booking_limit']; ?> ဦး/ရက်</span></td>
                                    <td>
                                        <a href="edit_doctor.php?id=<?php echo $doc['doctor_id']; ?>" class="btn btn-sm btn-outline-primary border-0"><i class="fas fa-edit"></i></a>
                                        <a href="delete_doctor.php?id=<?php echo $doc['doctor_id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('ဖျက်ရန် သေချာပါသလား?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> 
    </div>
</div>

<script>
    function checkUpdates() {
        fetch('check_new_booking.php')
        .then(res => res.text())
        .then(count => {
            const alertBox = document.getElementById('newActivityAlert');
            const countText = document.getElementById('notiCount');
            if (parseInt(count) > 0) {
                alertBox.style.display = 'inline-block';
                countText.innerText = count;
            } else {
                alertBox.style.display = 'none';
            }
        });
    }
    setInterval(checkUpdates, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>