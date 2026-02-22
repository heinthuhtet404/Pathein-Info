<?php
include("Admin/db.php");

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $query = "SELECT * FROM schools 
              WHERE status='active' 
              AND academic_type='School'
              AND name LIKE '%$search%'
              ORDER BY school_id ASC";
}else{
    $query = "SELECT * FROM schools 
              WHERE status='active' 
              AND academic_type='School'
              ORDER BY school_id ASC";
}

$result = mysqli_query($db, $query);

if(!$result){
    die("Query Error: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Schools</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background: blue;
    }

    .school-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: 0.4s;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .school-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 45px rgba(13, 110, 253, 0.25);
    }

    .school-img {
        height: 230px;
        object-fit: cover;
    }

    .btn-detail {
        border-radius: 30px;
        padding: 8px 22px;
    }

    input:focus {
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.3);
    }

    /* ===== Beautiful Search Button ===== */
    .search-btn {
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 20%;
        background: linear-gradient(135deg, #0a7ad6, #00c6ff);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        transition: all 0.4s ease;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.35);
    }

    /* Hover Effect */
    .search-btn:hover {
        transform: scale(1.15) rotate(10deg);
        background: linear-gradient(135deg, #084298, #0099cc);
        box-shadow: 0 15px 35px rgba(13, 110, 253, 0.5);
    }

    /* Click Animation */
    .search-btn:active {
        transform: scale(0.95);
    }
    </style>
</head>

<body>

    <?php include("navbar.php"); ?>

    <div class="container py-5">

        <!-- 🔍 Search Bar -->
        <div class="row mb-5">
            <div class="col-md-6 mx-auto">
                <form method="GET" class="search-box">
                    <div class="input-group custom-search">

                        <input type="text" name="search" class="form-control form-control-lg border-0 search-input"
                            placeholder="ကျောင်းအမည်/ကျောင်းအမျိုးအစားဖြင့်ရှာရန်..." value="<?php echo $search; ?>">

                        <button type="submit" class="search-btn">
                            <span class="search-icon">🔍</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>



        <!-- 🏫 School Cards -->
        <div class="row g-4">

            <?php 
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) { 
        ?>

            <div class="col-md-4">
                <div class="card school-card">

                    <?php if(!empty($row['logo'])) { ?>
                    <img src="Admin/uploads/<?php echo $row['logo']; ?>" class="card-img-top school-img">
                    <?php } else { ?>
                    <img src="Photo/photo1.jpg" class="card-img-top school-img">
                    <?php } ?>

                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-3">
                            <?php echo $row['name']; ?>
                        </h5>

                        <a href="schoolDetail.php?id=<?php echo $row['school_id']; ?>"
                            class="btn btn-primary btn-detail">
                            ပိုမိုကြည့်ရှုရန်
                        </a>
                    </div>

                </div>
            </div>

            <?php 
            }
        } else {
            echo "<div class='text-center text-muted'>No schools found.</div>";
        }
        ?>

        </div>

    </div>

    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">© 2026 University of Computer Studies(Pathein). All Rights Reserved.</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>