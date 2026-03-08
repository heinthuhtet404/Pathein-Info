<?php
include 'Admin/db.php';

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$cat_name = isset($_GET['cat']) ? $_GET['cat'] : 'all';
$cat_sql = mysqli_real_escape_string($db, $cat_name);

$where = ($cat_name == 'all') ? "" : " WHERE category = '$cat_sql'";

$total_res = mysqli_query($db, "SELECT COUNT(*) as total FROM clinics" . $where);
$total_records = mysqli_fetch_assoc($total_res)['total'];
$total_pages = ceil($total_records / $limit);

$query = "SELECT * FROM clinics $where LIMIT $limit OFFSET $offset";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cat_name; ?> - Clinics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Pyidaungsu', sans-serif; }
        
        .header-title {
            background: white;
            padding: 30px 0;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 40px;
        }

        .clinic-card { 
            border: none; 
            border-radius: 20px; 
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            background: white;
        }
        
        .clinic-card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important; 
        }

        .img-container {
            overflow: hidden;
            height: 200px;
        }

        .clinic-img { 
            width: 100%;
            height: 100%;
            object-fit: cover; 
            transition: 0.5s;
        }

        .clinic-card:hover .clinic-img {
            transform: scale(1.1);
        }

        .btn-view {
            background: linear-gradient(45deg, #0d6efd, #00d2ff);
            border: none;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-view:hover {
            box-shadow: 0 5px 15px rgba(13,110,253,0.3);
            color: white;
            transform: scale(1.02);
        }

        /* Pagination Styling */
        .page-link {
            border-radius: 10px !important;
            margin: 0 5px;
            border: none;
            color: #0d6efd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .active > .page-link {
            background: #0d6efd !important;
        }
        
        .empty-state {
            padding: 100px 0;
            color: #adb5bd;
        }
    </style>
</head>
<body>

    <div class="header-title shadow-sm">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" data-aos="fade-right">
                    <a href="clinics_categories.php" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left text-primary"></i>
                    </a>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($cat_name); ?> ဆေးခန်းများ</h3>
                        <p class="text-muted small mb-0">စုစုပေါင်း (<?php echo $total_records; ?>) ခု ရှိပါသည်</p>
                    </div>
                </div>
                <div class="d-none d-md-block" data-aos="fade-left">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">Location: Pathein</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php 
                $delay = 0;
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="card h-100 clinic-card shadow-sm">
                        <div class="img-container">
                            <img src="Admin/uploads/<?php echo $row['clinics_logo'] ?: 'default.jpg'; ?>" class="clinic-img">
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-2">
                                <span class="badge bg-info-subtle text-info fw-normal rounded-pill px-3"><?php echo htmlspecialchars($row['category']); ?></span>
                            </div>
                            <h5 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($row['clinics_name']); ?></h5>
                            <p class="text-muted small mb-4" style="height: 40px; overflow: hidden;">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i><?php echo htmlspecialchars($row['clinics_address']); ?>
                            </p>
                            <a href="clinic_preview.php?id=<?php echo $row['clinics_id']; ?>" class="btn btn-view w-100 rounded-pill py-2">
                                အသေးစိတ်ကြည့်မည် <i class="fas fa-chevron-right ms-2 small"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                $delay += 100; // တစ်ခုပြီးတစ်ခု ဖြည်းဖြည်းချင်း ပေါ်လာအောင် delay ပေးခြင်း
                endwhile; 
                ?>
            <?php else: ?>
                <div class="col-12 text-center empty-state" data-aos="zoom-in">
                    <i class="fas fa-hospital-alt fa-4x mb-3 opacity-25"></i>
                    <h5>ဤအမျိုးအစားအတွက် ဆေးခန်းမရှိသေးပါ။</h5>
                    <a href="clinics_categories.php" class="btn btn-primary rounded-pill mt-3">နောက်သို့ပြန်သွားရန်</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <nav class="mt-5" data-aos="fade-up">
            <ul class="pagination justify-content-center">
                <?php if($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?cat=<?php echo urlencode($cat_name); ?>&page=<?php echo $page-1; ?>">Previous</a></li>
                <?php endif; ?>

                <?php for($i=1; $i<=$total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link shadow-sm" href="?cat=<?php echo urlencode($cat_name); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?cat=<?php echo urlencode($cat_name); ?>&page=<?php echo $page+1; ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>