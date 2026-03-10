 <?php
session_start();
include("db.php");

// ၁။ Login စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ၂။ Booking သိမ်းဆည်းခြင်း Logic (မူလအတိုင်း မပြောင်းလဲပါ)
if (isset($_POST['submit_booking'])) {
    $customer_name = mysqli_real_escape_string($db, $_POST['customer_name']);
    $bus_id = intval($_POST['bus_id']);
    $route_id = intval($_POST['route_id']);
    $seat_number = mysqli_real_escape_string($db, $_POST['seat_number']);
    $booking_date = $_POST['booking_date'];
    $status = 'pending';

    $query = "INSERT INTO bus_booking (user_id, customer_name, bus_id, route_id, seat_number, booking_date, status) 
              VALUES ('$user_id', '$customer_name', '$bus_id', '$route_id', '$seat_number', '$booking_date', '$status')";
    
    if (mysqli_query($db, $query)) {
        header("Location: BusAdminDashboard.php"); // Dashboard ဖိုင်အမည် မှန်အောင် ပြင်ထားပါသည်
        exit();
    } else {
        echo "Error: " . mysqli_error($db);
    }
}

// ၃။ Dropdown အတွက် Data ဆွဲထုတ်ခြင်း
$my_buses = mysqli_query($db, "SELECT * FROM bus_line WHERE user_id = $user_id");
$my_routes = mysqli_query($db, "SELECT * FROM bus_route WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Booking | Admin</title>
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
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 650px;
        }

        .form-label {
            color: #00d2ff;
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #00d2ff;
            box-shadow: 0 0 10px rgba(0, 210, 255, 0.3);
            color: white;
        }

        .form-control::placeholder { color: rgba(255, 255, 255, 0.4); }
        
        /* Select option background fix */
        option { background: #000f1e; color: white; }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00d2ff);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.4);
        }

        .btn-light {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
        }

        .btn-light:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ff4d4d;
            border-color: #ff4d4d;
        }

        .header-icon {
            font-size: 2.5rem;
            color: #00d2ff;
            margin-bottom: 15px;
        }
    </style>
</head>
<!------<body>

    <div class="glass-card">
        <div class="text-center mb-4">
            <i class="fas fa-ticket-alt header-icon"></i>
            <h3 class="fw-bold">Add New Booking</h3>
            <p class="text-info small">ခရီးသည် ဘိုကင်အသစ် ထည့်သွင်းရန်</p>
        </div>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label"><i class="fa fa-user me-2"></i>ဝယ်ယူသူအမည်</label>
                <input type="text" name="customer_name" class="form-control" placeholder="ဥပမာ- မောင်မောင်" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label"><i class="fa fa-bus me-2"></i>ကားဂိတ်/ကား</label>
                    <select name="bus_id" class="form-select" required>
                        <option value="">-- ရွေးချယ်ပါ --</option>
                        <?php while($bus = mysqli_fetch_assoc($my_buses)): ?>
                            <option value="<?= $bus['busline_id'] ?>"><?= htmlspecialchars($bus['busline_name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fa fa-route me-2"></i>လမ်းကြောင်း</label>
                    <select name="route_id" class="form-select" required>
                        <option value="">-- ရွေးချယ်ပါ --</option>
                        <?php while($route = mysqli_fetch_assoc($my_routes)): ?>
                            <option value="<?= $route['id'] ?>"><?= htmlspecialchars($route['route_name']) ?> (<?= number_format($route['price']) ?> Ks)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label"><i class="fa fa-chair me-2"></i>ခုံနံပါတ်</label>
                    <input type="text" name="seat_number" class="form-control" placeholder="A1, A2" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="fa fa-calendar-days me-2"></i>သွားမည့်ရက်စွဲ</label>
                    <input type="date" name="booking_date" class="form-control" required>
                </div>
            </div>

            <div class="d-grid gap-3">
                <button type="submit" name="submit_booking" class="btn btn-primary btn-lg">
                    <i class="fa fa-save me-2"></i>Booking အတည်ပြုမည်
                </button>
                <a href="BusAdminDashboard.php" class="btn btn-light">
                    <i class="fa fa-arrow-left me-2"></i>Dashboard သို့ ပြန်သွားမည်
                </a>
            </div>
        </form>
    </div>

</body>
</html>