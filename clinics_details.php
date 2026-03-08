<?php
session_start();
include 'Admin/db.php';

// ၁။ Clinic ID စစ်ဆေးခြင်း
if (!isset($_GET['id'])) {
    header("Location: clinics.php");
    exit;
}

$clinic_id = mysqli_real_escape_string($db, $_GET['id']);
$clinic_q = mysqli_query($db, "SELECT * FROM clinics WHERE clinics_id = '$clinic_id'");
$clinic = mysqli_fetch_assoc($clinic_q);

if (!$clinic) {
    echo "<div class='container mt-5 alert alert-danger'>Clinic not found!</div>";
    exit;
}

// ၂။ Booking Limit တွက်ချက်သည့် Function 
function getRemainingSlots($db, $doctor_id, $booking_limit) {
    date_default_timezone_set("Asia/Yangon");
    $today = date('Y-m-d');
    
    $query = "SELECT COUNT(*) as booked_total FROM appointments 
              WHERE doctor_id = '$doctor_id' 
              AND appointment_date = '$today' 
              AND status != 'cancelled'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $booked_count = $row['booked_total'];

    $remaining = $booking_limit - $booked_count;
    return ($remaining > 0) ? $remaining : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $clinic['clinics_name']; ?> - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root { --primary-color: #0d6efd; --secondary-gradient: linear-gradient(135deg, #0d6efd 0%, #00d2ff 100%); --bg-light: #f8f9fa; }
        body { background-color: var(--bg-light); font-family: 'Pyidaungsu', sans-serif; }
        
        .clinic-header { background: white; padding: 50px 0; border-bottom: 1px solid #eee; }
        .logo-container img { width: 130px; height: 130px; object-fit: cover; border-radius: 25px; border: 5px solid #fff; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        /* Modern Nav Pills */
        .nav-pills .nav-link { 
            color: #6c757d; font-weight: 600; padding: 10px 25px; 
            border-radius: 50px; margin-right: 8px; transition: 0.3s;
            border: 1px solid transparent;
        }
        .nav-pills .nav-link:hover { background: #f0f7ff; color: var(--primary-color); }
        .nav-pills .nav-link.active { 
            background: var(--secondary-gradient) !important; 
            box-shadow: 0 5px 15px rgba(13,110,253,0.3);
            color: white !important;
        }

        .card { border: none; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: 0.3s; }
        .doctor-row { transition: 0.3s; border-radius: 15px; margin-bottom: 10px; }
        .doctor-row:hover { background-color: #f0f7ff !important; transform: scale(1.01); }
        
        .doctor-img { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        
        .btn-book { 
            background: var(--secondary-gradient); border: none; font-weight: 700;
            transition: 0.3s; padding: 8px 25px;
        }
        .btn-book:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(13,110,253,0.4); color: white; }

        .sidebar-info { position: sticky; top: 20px; }
        .badge-slot { font-size: 0.75rem; background: #e8f3ff; color: #0d6efd; border: 1px solid #d0e7ff; }
    </style>
</head>
<body>

<div class="clinic-header mb-5">
    <div class="container" data-aos="fade-down">
        <div class="row align-items-center">
            <div class="col-md-auto text-center logo-container">
                <?php if ($clinic['clinics_logo']): ?>
                    <img src="Admin/uploads/<?php echo $clinic['clinics_logo']; ?>" alt="Logo">
                <?php else: ?>
                    <div class="bg-light rounded-4 d-flex align-items-center justify-content-center border" style="width: 130px; height: 130px;">
                        <i class="fas fa-hospital fa-4x text-secondary"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md ps-md-4 mt-3 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="clinics_categories.php" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $clinic['clinics_name']; ?></li>
                    </ol>
                </nav>
                <h1 class="fw-bold text-dark mb-2"><?php echo $clinic['clinics_name']; ?></h1>
                <p class="text-muted fs-6"><i class="fas fa-map-marker-alt text-danger me-2"></i> <?php echo $clinic['clinics_address']; ?></p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center"><i class="fas fa-phone-alt text-primary me-2"></i><strong><?php echo $clinic['clinics_phone']; ?></strong></div>
                    <div class="d-flex align-items-center"><i class="fas fa-envelope text-info me-2"></i><strong><?php echo $clinic['clinics_email']; ?></strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="card overflow-hidden">
                <div class="card-header bg-white py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt text-primary me-2"></i>ဆရာဝန်များ၏ အချိန်ဇယား</h5>
                    <span class="badge bg-light text-dark fw-normal rounded-pill px-3 py-2 border"><?php echo date('d M Y (l)'); ?></span>
                </div>
                
                <div class="px-4 pb-2 bg-white">
                    <div class="nav-scroller overflow-auto">
                        <ul class="nav nav-pills flex-nowrap pb-3" id="pills-tab" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-all">All Days</button></li>
                            <?php 
                            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                            foreach($days as $day): 
                            ?>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $day; ?>"><?php echo $day; ?></button></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content p-4">
                        <div class="tab-pane fade show active" id="pills-all"><?php displayDoctorTable($db, $clinic_id, 'all'); ?></div>
                        <?php foreach($days as $day): ?>
                        <div class="tab-pane fade" id="pills-<?php echo $day; ?>"><?php displayDoctorTable($db, $clinic_id, $day); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" data-aos="fade-left">
            <div class="sidebar-info">
                <div class="card p-3 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary text-uppercase mb-3 border-bottom pb-2">ဆေးခန်းအကျဉ်း</h6>
                        <p class="text-muted" style="line-height: 1.8; font-size: 0.95rem;"><?php echo nl2br(htmlspecialchars($clinic['clinics_description'])); ?></p>
                        <hr class="opacity-25">
                        <div class="d-flex align-items-center p-3 bg-light rounded-4">
                            <i class="fas fa-clock fa-2x text-primary me-3"></i>
                            <div>
                                <small class="text-muted d-block">Opening Hours</small>
                                <span class="fw-bold">Open 24 Hours / Daily</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card bg-primary text-white p-2">
                    <div class="card-body text-center">
                        <i class="fas fa-info-circle mb-2 fa-2x"></i>
                        <p class="small mb-0">ရက်ချိန်းယူရန်အတွက် သက်ဆိုင်ရာ ဆရာဝန်၏ "Book Now" ခလုတ်ကို နှိပ်ပါ။</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function displayDoctorTable($db, $clinic_id, $filter) {
    if ($filter == 'all') {
        $query = "SELECT * FROM doctors WHERE clinics_id = '$clinic_id'";
    } else {
        $query = "SELECT * FROM doctors WHERE clinics_id = '$clinic_id' AND available_days LIKE '%$filter%'";
    }
    
    $result = mysqli_query($db, $query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle" style="border-collapse: separate; border-spacing: 0 10px;">
            <thead class="bg-light small text-uppercase text-muted">
                <tr>
                    <th class="border-0 ps-3">Doctor</th>
                    <th class="border-0 text-center">Slots Info</th>
                    <th class="border-0">Duty Time</th>
                    <th class="border-0 text-end pe-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): 
                    while($doc = mysqli_fetch_assoc($result)): 
                ?>
                <tr class="doctor-row shadow-sm bg-white">
                    <td class="ps-3 py-3 rounded-start">
                        <div class="d-flex align-items-center">
                            <?php if($doc['doctor_image']): ?>
                                <img src="Admin/uploads/<?php echo $doc['doctor_image']; ?>" class="doctor-img me-3">
                            <?php else: ?>
                                <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;"><i class="fas fa-user-md text-primary fa-lg"></i></div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-bold text-dark mb-0">Dr. <?php echo $doc['doctor_name']; ?></div>
                                <span class="text-primary small fw-semibold"><?php echo $doc['specialization']; ?></span>
                            </div>
                        </div>
                    </td>
                  
                    <td class="text-center">
                        <span class="badge badge-slot rounded-pill px-3 py-2">
                            <i class="fas fa-users me-1"></i> Limit: <?php echo $doc['booking_limit']; ?>
                        </span>
                    </td>

                    <td>
                        <div class="small fw-bold text-dark"><i class="far fa-clock me-1 text-primary"></i><?php echo date("h:i A", strtotime($doc['start_time'])); ?></div>
                        <div class="text-muted" style="font-size: 0.75rem;">to <?php echo date("h:i A", strtotime($doc['end_time'])); ?></div>
                    </td>

                    <td class="text-end pe-3 rounded-end">
                        <a href="booking.php?clinic_id=<?php echo $clinic_id; ?>&doctor_id=<?php echo $doc['doctor_id']; ?>" 
                           class="btn btn-sm btn-book rounded-pill px-4 shadow-sm text-white">Book Now</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4" class="text-center py-5 text-muted">
                    <i class="fas fa-user-slash fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">ဤနေ့တွင် တာဝန်ကျဆရာဝန် မရှိသေးပါ။</p>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
<style>
        .floating-back-btn {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 55px;
            height: 55px;
            background-color: #212529; /* Black circle */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            z-index: 1000;
            transition: all 0.3s ease;
            border: none;
        }

        .floating-back-btn:hover {
            background-color: #343a40;
            transform: scale(1.1);
            color: white;
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        }

        .floating-back-btn i {
            font-size: 20px;
        }
    </style>

    <a href="javascript:history.back()" class="floating-back-btn" title="Back">
        <i class="fas fa-arrow-left"></i>
    </a>
</body>
</html>