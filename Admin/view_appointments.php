<?php
include 'db.php';

// ၁။ Admin က ဤစာမျက်နှာသို့ ရောက်လာလျှင် Noti ကို Reset လုပ်မည်
mysqli_query($db, "UPDATE appointments SET is_notified = 1 WHERE is_notified = 0");

// ၂။ ဘိုကင်အားလုံးကို ရက်စွဲအလိုက် (အသစ်ဆုံးမှ အဟောင်းသို့) ဆွဲထုတ်မည်
// token_no ပါဝင်ရန် a.* ကို သုံးထားပါသည်
$sql = "SELECT a.*, d.doctor_name, c.clinics_name 
        FROM appointments a
        LEFT JOIN doctors d ON a.doctor_id = d.doctor_id
        LEFT JOIN clinics c ON a.clinics_id = c.clinics_id
        ORDER BY a.appointment_date DESC, a.appointment_time ASC";

$result = mysqli_query($db, $sql);
$current_date = ""; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .date-divider { background: #e9ecef; padding: 8px 20px; font-weight: bold; border-radius: 5px; margin-top: 25px; color: #495057; border-left: 5px solid #0d6efd; }
        .appointment-row:hover { background-color: #f8f9fa; }
        .pulse-alert { animation: pulse-red 2s infinite; cursor: pointer; display: none; }
        @keyframes pulse-red {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { transform: scale(1.02); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
    </style>
</head>
<body class="p-4">

<div class="container bg-white p-4 shadow-sm rounded-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="fas fa-calendar-alt text-primary me-2"></i>ဘိုကင်စာရင်း အားလုံး
        </h3>
        
        <div id="newBookingAlert" class="pulse-alert badge bg-danger p-2 px-3 rounded-pill" onclick="location.reload()">
            <i class="fas fa-bell me-2"></i> 
            ဘိုကင်အသစ် <span id="notiCount">0</span> ခု ရှိနေပါသည် - Refresh နှိပ်ပါ
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle border-0">
            <thead class="table-dark">
                <tr>
                    <th style="width: 8%;">Token</th> <th style="width: 12%;">အချိန်</th>
                    <th style="width: 25%;">လူနာအမည်နှင့် ဖုန်း</th>
                    <th style="width: 25%;">ဆရာဝန်နှင့် ဆေးခန်း</th>
                    <th style="width: 10%;">အခြေအနေ</th>
                    <th style="width: 20%; text-align: center;">ပြင်ဆင်ရန်</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    if ($current_date != $row['appointment_date']): 
                        $current_date = $row['appointment_date'];
                ?>
                    <tr>
                        <td colspan="6" class="date-divider">
                            <i class="far fa-calendar-check me-2"></i><?php echo date('d-M-Y (l)', strtotime($current_date)); ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr class="appointment-row border-bottom">
                    <td class="text-center fw-bold text-primary">
                        <?php echo ($row['token_no'] > 0) ? "#" . $row['token_no'] : "-"; ?>
                    </td>

                    <td class="fw-bold text-danger">
                        <i class="far fa-clock me-1"></i><?php echo date('h:i A', strtotime($row['appointment_time'])); ?>
                    </td>
                    <td>
                        <div class="fw-bold"><?php echo $row['patient_name']; ?></div>
                        <small class="text-primary"><i class="fas fa-phone-alt me-1"></i><?php echo $row['patient_phone']; ?></small>
                    </td>
                    <td>
                        <div class="fw-bold text-secondary">Dr. <?php echo $row['doctor_name']; ?></div>
                        <span class="badge bg-light text-dark border small"><?php echo $row['clinics_name']; ?></span>
                    </td>
                    <td>
                        <?php 
                        $status = $row['status'];
                        $badge_class = ($status == 'pending') ? 'bg-warning' : ($status == 'confirmed' ? 'bg-success' : 'bg-danger');
                        ?>
                        <span class="badge rounded-pill <?php echo $badge_class; ?> px-3">
                            <?php echo ucfirst($status); ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group shadow-sm">
                            <a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=confirmed" class="btn btn-sm btn-outline-success" title="Confirm"><i class="fas fa-check"></i></a>
                            <a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=cancelled" class="btn btn-sm btn-outline-danger" title="Cancel"><i class="fas fa-times"></i></a>
                        </div>
                    </td>
                    <td class="text-center fw-bold text-primary">
    <?php 
        // token_no ကို တိုက်ရိုက်ထုတ်ကြည့်ပါ (Debug အတွက်)
        echo "Token is: " . $row['token_no']; 
    ?>
</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function checkNewBookings() {
        fetch('check_new_booking.php')
        .then(res => res.text())
        .then(count => {
            const countNum = parseInt(count);
            const alertBox = document.getElementById('newBookingAlert');
            const countSpan = document.getElementById('notiCount');

            if (countNum > 0) {
                alertBox.style.display = 'inline-block';
                countSpan.innerText = countNum;
            } else {
                alertBox.style.display = 'none';
            }
        });
    }
    setInterval(checkNewBookings, 5000);
</script>

</body>
</html>