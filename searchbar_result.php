<?php
include 'Admin/db.php';

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
$where = " WHERE clinics_name LIKE '%$search%' OR clinics_address LIKE '%$search%'";

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
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .clinic-card { border: none; border-radius: 15px; transition: 0.3s; }
        .clinic-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .clinic-img { height: 180px; object-fit: cover; border-radius: 15px 15px 0 0; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex align-items-center mb-4">
            <a href="clinics_categories.php" class="btn btn-outline-primary rounded-pill px-4 me-3"><i class="fas fa-arrow-left me-2"></i>Back</a>
            <h4 class="mb-0">ရှာဖွေမှုရလဒ်: "<?php echo htmlspecialchars($search); ?>"</h4>
        </div>

        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 clinic-card shadow-sm">
                        <img src="uploads/<?php echo $row['clinics_logo'] ?: 'default.jpg'; ?>" class="card-img-top clinic-img">
                        <div class="card-body p-4">
                            <h5 class="fw-bold"><?php echo htmlspecialchars($row['clinics_name']); ?></h5>
                            <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt text-danger me-2"></i><?php echo htmlspecialchars($row['clinics_address']); ?></p>
                            <a href="clinic_preview.php?id=<?php echo $row['clinics_id']; ?>" class="btn btn-primary w-100 rounded-pill">ကြည့်ရှုရန်</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5"><h5>ကိုက်ညီသော ဆေးခန်းမရှိပါ။</h5></div>
            <?php endif; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <?php for($i=1; $i<=$total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</body>
</html>