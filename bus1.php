<?php
include("Admin/db.php");

// ခရီးသွားလာရေးအတွက် သက်ဆိုင်ရာ လမ်းကြောင်းအလိုက် data ယူခြင်း
$query = "SELECT * FROM bus_line WHERE status='active' LIMIT 3"; 
$result = mysqli_query($db, $query);

$data = [];
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$modes = [
    [
        'title' => 'ကားလမ်းကြောင်းများ', 
        'icon' => 'fa-bus', 
        'color' => '#4e73df', 
        'desc' => 'အဝေးပြေးယာဉ်လိုင်းများနှင့် မြို့တွင်းခရီးစဉ်များ',
        'img' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=500'
    ],
    [
        'title' => 'ရေလမ်းကြောင်းများ', 
        'icon' => 'fa-ship', 
        'color' => '#36b9cc', 
        'desc' => 'ဧရာဝတီမြစ်ကြောင်းနှင့် ကမ်းရိုးတန်းခရီးစဉ်များ',
        'img' => 'https://images.unsplash.com/photo-1500514966906-fe245eea9344?auto=format&fit=crop&q=80&w=500'
    ],
    [
        'title' => 'ရထားလမ်းကြောင်းများ', 
        'icon' => 'fa-train', 
        'color' => '#1cc88a', 
        'desc' => 'အပန်းဖြေရထားခရီးစဉ်များနှင့် လမ်းပိုင်းအသစ်များ',
        'img' => 'train.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Routes | Myanmar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');
        
        body {
            /* ကား Background ပုံကို Dark Overlay ခံပြီး ထည့်ထားပါတယ် */
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Pyidaungsu', sans-serif;
            color: white;
            min-height: 100vh;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 50px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: #00d2ff;
            border-radius: 2px;
        }

        /* Glassmorphism Effect - မှန်ကြည်ကဒ်ပုံစံ */
        .transport-card {
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .transport-card:hover {
            transform: translateY(-15px);
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .img-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }

        .transport-card:hover .img-container img {
            transform: scale(1.1);
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-top: -35px;
            margin-bottom: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            font-size: 1.8rem;
            z-index: 2;
        }

        .category-name {
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .text-white-80 {
            color: white;
        }

        .btn-custom {
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            border: none;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .card-body {
            padding: 2rem 1.5rem;
        }

        footer {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

    

    <div class="container py-5 mt-5">
        <div class="text-center">
            <h2 class="fw-bold section-title">ခရီးသွားလာရေး လမ်းကြောင်းများ</h2>
        </div>

        <div class="row g-5 justify-content-center">
            <?php 
            for($i = 0; $i < 3; $i++) { 
                $mode = $modes[$i];
                $displayImg = (isset($data[$i]['logo']) && !empty($data[$i]['logo'])) 
                              ? "Admin/uploads/".$data[$i]['logo'] 
                              : $mode['img'];
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 transport-card text-center">
                    <div class="img-container">
                        <img src="<?php echo $displayImg; ?>" alt="<?php echo $mode['title']; ?>">
                    </div>

                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="icon-wrapper" style="color: <?php echo $mode['color']; ?>;">
                            <i class="fas <?php echo $mode['icon']; ?>"></i>
                        </div>

                        <h4 class="category-name"><?php echo $mode['title']; ?></h4>
                        <p class="text-white-80 mb-4">
                            <?php echo $mode['desc']; ?>
                        </p>
                        
                        <div class="mt-auto">
                            <a href="bus_list.php?type=<?php echo $i; ?>" 
                               class="btn btn-custom text-white" 
                               style="background: linear-gradient(45deg, <?php echo $mode['color']; ?>, #00d2ff);">
                                အသေးစိတ်ကြည့်ရှုရန် <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <footer class="py-4 mt-5">
        <div class="container text-center text-white-50">
            <p class="mb-0">© 2026 <strong>Travel Myanmar</strong>. Explore the Golden Land.</p>
        </div>
    </footer>

</body>
</html>