<?php
session_start();
include 'Admin/db.php';

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['patient_id'])) {
    echo "<script>alert('ဘိုကင်တင်ရန် အရင်ဆုံး Login ဝင်ပေးပါ'); window.location='patient_login.php';</script>";
    exit;
}

// ၂။ Doctor နှင့် Clinic ID ပါမပါ စစ်ဆေးခြင်း
if (!isset($_GET['doctor_id']) || !isset($_GET['clinic_id'])) {
    header("Location: index.php");
    exit;
}

$doctor_id = mysqli_real_escape_string($db, $_GET['doctor_id']);
$clinic_id = mysqli_real_escape_string($db, $_GET['clinic_id']);

// ၃။ ဆရာဝန်အချက်အလက်ကို ဆွဲထုတ်ခြင်း
$doc_query = mysqli_query($db, "SELECT * FROM doctors WHERE doctor_id = '$doctor_id'");
$doc = mysqli_fetch_assoc($doc_query);

if (!$doc) { 
    echo "<div class='container mt-5 alert alert-danger'>Doctor not found!</div>"; 
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form - <?php echo $doc['doctor_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root { --primary-blue: #0d6efd; --soft-bg: #f0f4f8; }
        body { background-color: var(--soft-bg); font-family: 'Pyidaungsu', sans-serif; }
        
        .booking-container { max-width: 800px; margin: 50px auto; }
        .booking-card { 
            border-radius: 30px; border: none; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.08); 
            background: white; overflow: hidden;
        }

        .doctor-info-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #00d2ff 100%);
            color: white; padding: 30px;
        }

        .form-section { padding: 40px; }
        .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
        .form-control, .form-select {
            padding: 12px 20px; border-radius: 15px;
            border: 1px solid #dee2e6; background-color: #f8f9fa;
        }
        .form-control:focus {
            background-color: #fff; box-shadow: 0 0 0 0.25 margin-top: 5px;
        }

        .slot-status-box {
            background: #fff; border-radius: 15px; padding: 15px;
            border: 1px dashed #0d6efd;
        }

        .btn-submit {
            padding: 15px; border-radius: 15px; font-weight: 700;
            transition: 0.3s;
        }
        
        .btn-submit:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(13,110,253,0.3); }

        /* Floating Back Button Style */
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

<div class="container booking-container">
    <div class="booking-card" data-aos="zoom-in">
        <div class="doctor-info-banner d-md-flex align-items-center justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Appointment Form</h4>
                <p class="mb-0 opacity-75"> <?php echo $doc['doctor_name']; ?> နှင့် ရက်ချိန်းယူခြင်း</p>
            </div>
            <div class="text-md-end mt-3 mt-md-0">
                <span class="badge bg-white text-primary rounded-pill px-3"><?php echo $doc['specialization']; ?></span>
            </div>
        </div>

        <div class="form-section">
            <div class="alert alert-primary border-0 rounded-4 mb-4 small">
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <i class="fas fa-calendar-alt me-1"></i> တာဝန်ကျရက်<br>
                        <strong><?php echo $doc['available_days']; ?></strong>
                    </div>
                    <div class="col-6">
                        <i class="fas fa-clock me-1"></i> ကြည့်ရှုချိန်<br>
                        <strong><?php echo date("h:i A", strtotime($doc['start_time'])); ?> - <?php echo date("h:i A", strtotime($doc['end_time'])); ?></strong>
                    </div>
                </div>
            </div>

            <div class="slot-status-box mb-4 text-center">
                <span class="small text-muted mb-2 d-block">ရက်စွဲအလိုက် လက်ကျန် Slot</span>
                <h5 id="slot_status" class="fw-bold mb-0 text-secondary">ရက်စွဲရွေးချယ်ပါ</h5>
            </div>

            <form action="booking_process.php" method="POST" onsubmit="return validateBooking()">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['patient_id']; ?>">
                <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $doctor_id; ?>">
                <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-2"></i>လူနာအမည်</label>
                    <input type="text" name="patient_name" class="form-control" required placeholder="အမည်အပြည့်အစုံ">
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-birthday-cake me-2"></i>အသက်</label>
                        <input type="number" name="patient_age" class="form-control" required placeholder="ဥပမာ - ၂၅">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-venus-mars me-2"></i>ကျား/မ</label>
                        <select name="patient_gender" class="form-select">
                            <option value="Male">ကျား</option>
                            <option value="Female">မ</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-phone me-2"></i>ဖုန်းနံပါတ်</label>
                    <input type="tel" name="patient_phone" class="form-control" required placeholder="09xxxxxxxxx">
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-calendar-check me-2"></i>ရက်စွဲရွေးချယ်ပါ</label>
                        <input type="date" name="appointment_date" id="app_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-clock me-2"></i>အချိန်ရွေးချယ်ပါ</label>
                        <input type="time" name="appointment_time" id="app_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>နေရပ်လိပ်စာ (သို့မဟုတ်) ရောဂါလက္ခဏာ</label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="အသေးစိတ်ဖြည့်စွက်နိုင်ပါသည်..."></textarea>
                </div>

                <button type="submit" name="confirm_booking" id="submit_btn" class="btn btn-primary w-100 btn-submit shadow-sm">
                    <i class="fas fa-paper-plane me-2"></i> Booking အတည်ပြုမည်
                </button>
            </form>
        </div>
    </div>
</div>

<a href="javascript:history.back()" class="floating-back shadow">
    <i class="fas fa-arrow-left"></i>
</a>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800 });

// AJAX Slot Checking
document.getElementById('app_date').addEventListener('change', function() {
    const selectedDate = this.value;
    const doctorId = document.getElementById('doctor_id').value;
    const statusBox = document.getElementById('slot_status');
    const submitBtn = document.getElementById('submit_btn');

    if (selectedDate) {
        statusBox.innerHTML = "<span class='spinner-border spinner-border-sm me-2'></span>စစ်ဆေးနေသည်...";
        
        fetch('check_availability.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `date=${selectedDate}&doctor_id=${doctorId}`
        })
        .then(response => response.text())
        .then(availableSlots => {
            const slots = parseInt(availableSlots);
            
            if (slots > 0) {
                statusBox.innerHTML = `<i class='fas fa-check-circle text-success me-2'></i>${slots} ဦး ကျန်သေးသည်`;
                statusBox.classList.remove('text-danger', 'text-secondary');
                statusBox.classList.add('text-success');
                submitBtn.disabled = false;
                submitBtn.innerHTML = "<i class='fas fa-paper-plane me-2'></i> Booking အတည်ပြုမည်";
            } else {
                statusBox.innerHTML = "<i class='fas fa-times-circle text-danger me-2'></i>ဘိုကင်ပြည့်သွားပါပြီ";
                statusBox.classList.remove('text-success', 'text-secondary');
                statusBox.classList.add('text-danger');
                submitBtn.disabled = true;
                submitBtn.innerHTML = "လူနာပြည့်သွားပါပြီ";
            }
        });
    }
});

function validateBooking() {
    const dateInput = document.getElementById('app_date').value;
    const timeInput = document.getElementById('app_time').value;
    const availableDays = "<?php echo $doc['available_days']; ?>";
    const startTime = "<?php echo $doc['start_time']; ?>";
    const endTime = "<?php echo $doc['end_time']; ?>";

    const selectedDate = new Date(dateInput);
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const selectedDay = dayNames[selectedDate.getDay()];

    // ဆရာဝန်ရှိသောရက်ဟုတ်မဟုတ် စစ်ဆေးခြင်း
    if (!availableDays.includes(selectedDay)) {
        alert("ဆရာဝန်သည် " + selectedDay + " နေ့တွင် တာဝန်ကျမရှိပါ။\nတာဝန်ကျရက်များ: " + availableDays);
        return false;
    }

    // ကြည့်ရှုချိန်အတွင်း ဟုတ်မဟုတ် စစ်ဆေးခြင်း
    if (timeInput < startTime || timeInput > endTime) {
        alert("ရွေးချယ်ထားသောအချိန်သည် ဆရာဝန်ကြည့်ရှုချိန် မဟုတ်ပါ။\nကြည့်ရှုချိန်: " + startTime + " မှ " + endTime);
        return false;
    }
    return true;
}
</script>
</body>
</html>