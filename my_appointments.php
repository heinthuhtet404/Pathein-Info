<?php
session_start();
include 'Admin/db.php';

// Login စစ်ဆေးခြင်း
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];

// SQL Query - Token နံပါတ်ပါ ဆွဲထုတ်ထားသည်
$sql = "SELECT a.*, d.doctor_name, d.specialization, c.clinics_name 
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.doctor_id
        JOIN clinics c ON a.clinics_id = c.clinics_id
        WHERE a.user_id = '$patient_id'
        ORDER BY a.appointment_id DESC";

$result = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - Clinic Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root { --primary-blue: #0d6efd; --bg-soft: #f8f9fa; }
        body { background-color: var(--bg-soft); font-family: 'Pyidaungsu', sans-serif; }
        
        .navbar { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        
        .appointment-card { 
            border: none; 
            border-radius: 25px; 
            transition: all 0.3s ease; 
            box-shadow: 0 8px 25px rgba(0,0,0,0.04);
            background: white;
            overflow: hidden;
        }
        .appointment-card:hover { transform: translateY(-10px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
        
        /* Token Circle Styling */
        .token-circle {
            width: 50px; height: 50px;
            background: #eef4ff;
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; border: 2px solid #d0e1ff;
        }

        .status-badge { 
            font-size: 0.7rem; padding: 6px 15px; 
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        
        .info-row { background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 15px; }
        
        /* Floating Back Button */
        .floating-back {
            position: fixed; bottom: 30px; left: 30px;
            width: 50px; height: 50px; background: #212529;
            color: white; border-radius: 50%; display: flex;
            align-items: center; justify-content: center;
            text-decoration: none; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1000; transition: 0.3s;
        }
        .floating-back:hover { background: #000; color: white; transform: scale(1.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top mb-5">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">
            <i class="fas fa-hospital-user me-2"></i>Clinic Booking
        </a>
        <a href="booking.php" class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm">
            <i class="fas fa-plus me-1"></i> New Booking
        </a>
    </div>
</nav>

<div class="container py-3">
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12 text-center text-md-start">
            <h3 class="fw-bold mb-1">ကျွန်ုပ်၏ ဘိုကင်များ</h3>
            <p class="text-muted small">သင်၏ ရက်ချိန်းများနှင့် တိုကင်နံပါတ်များကို ဤနေရာတွင် စစ်ဆေးနိုင်ပါသည်</p>
        </div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card appointment-card p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="d-flex align-items-center">
                                <div class="token-circle me-3" title="Token Number">
                                    <?php echo $row['token_no'] ?: '--'; ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></h6>
                                    <small class="text-primary fw-semibold"><?php echo htmlspecialchars($row['specialization']); ?></small>
                                </div>
                            </div>
                            <?php 
                                $status = strtolower($row['status']);
                                $badge_class = 'bg-warning-subtle text-warning border border-warning-subtle'; // pending
                                if($status == 'confirmed') $badge_class = 'bg-success-subtle text-success border border-success-subtle';
                                if($status == 'cancelled') $badge_class = 'bg-danger-subtle text-danger border border-danger-subtle';
                            ?>
                            <span class="badge rounded-pill status-badge <?php echo $badge_class; ?>">
                                <?php echo $status; ?>
                            </span>
                        </div>

                        <div class="info-row p-3 mb-4 d-flex align-items-center">
                            <div class="flex-grow-1 border-end text-center">
                                <small class="text-muted d-block mb-1">DATE</small>
                                <span class="fw-bold small text-dark"><i class="far fa-calendar-alt text-primary me-1"></i><?php echo date("d M, Y", strtotime($row['appointment_date'])); ?></span>
                            </div>
                            <div class="flex-grow-1 text-center">
                                <small class="text-muted d-block mb-1">TIME</small>
                                <span class="fw-bold small text-dark"><i class="far fa-clock text-primary me-1"></i><?php echo date("h:i A", strtotime($row['appointment_time'])); ?></span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 border-top pt-3">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-clinic-medical me-3 text-primary opacity-50"></i>
                                <span>Clinic: <strong class="text-dark"><?php echo htmlspecialchars($row['clinics_name']); ?></strong></span>
                            </div>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-user-circle me-3 text-primary opacity-50"></i>
                                <span>Patient: <strong class="text-dark"><?php echo htmlspecialchars($row['patient_name']); ?></strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5 mt-5" data-aos="zoom-in">
            <div class="mb-4">
                <i class="fas fa-calendar-day fa-5x text-muted opacity-25"></i>
            </div>
            <h5 class="fw-bold text-muted">တင်ထားသော ဘိုကင်များ မရှိသေးပါ။</h5>
            <p class="text-muted small mb-4 px-4">လက်ရှိအချိန်တွင် သင်ရက်ချိန်းယူထားသော ဆေးခန်းစာရင်း မတွေ့ရှိသေးပါ။</p>
            <a href="index.php" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm fw-bold">ဆေးခန်းများ ရှာဖွေရန်</a>
        </div>
    <?php endif; ?>
</div>

<a href="javascript:history.back()" class="floating-back">
    <i class="fas fa-arrow-left"></i>
</a>

<footer class="text-center py-5 text-muted small opacity-50">
    &copy; <?php echo date('Y'); ?> Clinic Appointment System &bull; All Rights Reserved
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
</body>
</html>