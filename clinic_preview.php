<?php
session_start();
include 'Admin/db.php';

if(!isset($_GET['id'])) {
    header("Location: clinics.php");
    exit;
}

$id = mysqli_real_escape_string($db, $_GET['id']);
$query = "SELECT * FROM clinics WHERE clinics_id = '$id'";
$result = mysqli_query($db, $query);
$clinic = mysqli_fetch_assoc($result);

// Background အတွက် Logo ပုံကို သုံးမယ်
$bg_logo = !empty($clinic['clinics_logo']) ? 'Admin/uploads/'.$clinic['clinics_logo'] : 'default_logo.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $clinic['clinics_name']; ?> - Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Pyidaungsu', sans-serif; }
        
        .hero-banner {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?php echo $bg_logo; ?>');
            background-size: cover; 
            background-position: center;
            background-attachment: fixed; /* Parallax effect */
            height: 450px; 
            display: flex; 
            align-items: center; 
            color: white;
            position: relative;
        }

        .hero-content img {
            border: 5px solid rgba(255,255,255,0.3);
            transition: 0.5s;
        }
        .hero-content img:hover { transform: scale(1.05); border-color: #fff; }

        .main-img { 
            width: 100%; height: 400px; object-fit: cover; border-radius: 25px; 
            cursor: zoom-in; transition: 0.5s; border: 4px solid white;
        }
        .main-img:hover { transform: scale(1.02); box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important; }

        .sub-img { 
            width: 100%; height: 110px; object-fit: cover; border-radius: 15px; 
            cursor: zoom-in; transition: 0.4s; border: 2px solid white;
        }
        .sub-img:hover { transform: translateY(-5px); border-color: #0d6efd; }

        .info-box {
            background: white; border-radius: 25px; padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            height: 100%;
            transition: 0.3s;
        }
        
        .map-container {
            border-radius: 20px; overflow: hidden; border: 1px solid #eee;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 250px;
        }

        .btn-booking {
            background: linear-gradient(45deg, #0d6efd, #00d2ff);
            border: none; color: white; transition: 0.3s;
        }
        .btn-booking:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(13,110,253,0.3); color: white; }

        .section-title {
            position: relative; padding-bottom: 10px; margin-bottom: 20px;
        }
        .section-title::after {
            content: ''; position: absolute; left: 0; bottom: 0;
            width: 50px; height: 3px; background: #0d6efd; border-radius: 3px;
        }
    </style>
</head>
<body>

    <div class="hero-banner">
        <div class="container text-center hero-content" data-aos="zoom-in">
            <div class="mb-3">
                <img src="Admin/uploads/<?php echo $clinic['clinics_logo']; ?>" width="120" height="120" class="rounded-circle shadow-lg">
            </div>
            <h1 class="display-4 fw-bold mb-2"><?php echo $clinic['clinics_name']; ?></h1>
            <p class="lead mb-4 badge bg-primary px-4 py-2 rounded-pill"><?php echo $clinic['category']; ?></p>
            <div>
                <a href="clinics_details.php?id=<?php echo $id; ?>" class="btn btn-booking btn-lg rounded-pill px-5 shadow">
                   <i class="fas fa-calendar-check me-2"></i> ရက်ချိန်းယူရန်
                </a>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="row g-3">
                    <div class="col-12">
                        <?php if(!empty($clinic['img_1'])): ?>
                        <a href="Admin/uploads/<?php echo $clinic['img_1']; ?>" data-fancybox="gallery" data-caption="Main View">
                            <img src="Admin/uploads/<?php echo $clinic['img_1']; ?>" class="main-img shadow-sm">
                        </a>
                        <?php else: ?>
                            <div class="main-img bg-secondary d-flex align-items-center justify-content-center text-white">ပုံမရှိပါ</div>
                        <?php endif; ?>
                    </div>
                    <?php for($i=2; $i<=5; $i++): 
                        $img_col = "img_" . $i;
                        if(!empty($clinic[$img_col])):
                    ?>
                        <div class="col-3">
                            <a href="Admin/uploads/<?php echo $clinic[$img_col]; ?>" data-fancybox="gallery">
                                <img src="Admin/uploads/<?php echo $clinic[$img_col]; ?>" class="sub-img shadow-sm">
                            </a>
                        </div>
                    <?php endif; endfor; ?>
                </div>
            </div>

            <div class="col-lg-5" data-aos="fade-left">
                <div class="info-box shadow-sm">
                    <h4 class="fw-bold text-primary section-title">ဆေးခန်းအကြောင်း</h4>
                    <p class="text-muted" style="line-height: 1.9; font-size: 1.05rem;">
                        <?php echo nl2br(htmlspecialchars($clinic['clinics_description'])); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-4 g-4">
            <div class="col-12" data-aos="fade-up">
                <div class="info-box shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-6 border-end">
                            <h4 class="fw-bold text-primary section-title">ဆက်သွယ်ရန် အချက်အလက်</h4>
                            
                            <div class="d-flex align-items-center p-3 bg-primary-subtle rounded-4 mb-4" style="border-left: 5px solid #0d6efd;">
                                <i class="fas fa-clock fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">ဝန်ဆောင်မှုချိန်</h6>
                                    <p class="mb-0 text-primary fw-bold"><?php echo !empty($clinic['opening_hours']) ? $clinic['opening_hours'] : 'မသတ်မှတ်ထားပါ။'; ?></p>
                                </div>
                            </div>

                            <p class="mb-3 fs-6">
                                <strong><i class="fas fa-map-marker-alt text-danger me-2"></i>လိပ်စာ:</strong> 
                                <span class="text-muted"><?php echo $clinic['clinics_address']; ?></span>
                            </p>
                            
                            <?php if(!empty($clinic['clinics_phone'])): ?>
                            <p class="mb-4 fs-6">
                                <strong><i class="fas fa-phone-alt text-success me-2"></i>ဖုန်း:</strong> 
                                <a href="tel:<?php echo $clinic['clinics_phone']; ?>" class="text-decoration-none text-muted"><?php echo $clinic['clinics_phone']; ?></a>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 ps-md-5">
                            <h6 class="fw-bold mb-3"><i class="fas fa-map-marked-alt text-primary me-2"></i>ဆေးခန်းတည်နေရာ (Map)</h6>
                            <div class="map-container shadow-sm">
                                <?php if(!empty($clinic['map_link'])): ?>
                                    <iframe src="<?php echo $clinic['map_link']; ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                <?php else: ?>
                                    <div class="h-100 bg-light d-flex flex-column align-items-center justify-content-center text-muted">
                                        <i class="fas fa-map-signs fa-2x mb-2"></i>
                                        <div class="small">Map link မရှိသေးပါ။</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="position: fixed; bottom: 30px; left: 30px; z-index: 1000;">
        <a href="javascript:history.back()" class="btn btn-dark rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Initialize
        AOS.init({ duration: 1000, once: true });

        // Fancybox Config
        Fancybox.bind("[data-fancybox='gallery']", {
            closeButton: "inside",
            dragToClose: true,
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [],
                    right: ["iterateZoom", "close"],
                },
            },
        });
    </script>
</body>
</html>