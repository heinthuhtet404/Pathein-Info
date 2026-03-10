<?php
include("Admin/db.php");

$school_id = $_GET['school_id'];

$grade = $_GET['grade'];


// $stmt = $db->prepare("SELECT * FROM curriculums WHERE school_id=? AND grade=?");
// $stmt->bind_param("is", $school_id, $grade);
// $stmt->execute();
// $result = $stmt->get_result();

$imageStmt = $db->prepare("SELECT image FROM curriculums WHERE school_id=? AND grade=? LIMIT 1");
$imageStmt->bind_param("is", $school_id, $grade);
$imageStmt->execute();

$imageResult = $imageStmt->get_result();

$firstRow = $imageResult ->fetch_assoc();





$stmt = $db->prepare("SELECT * FROM curriculums WHERE school_id=? AND grade=?");
$stmt->bind_param("is", $school_id, $grade);
$stmt->execute();
$result = $stmt->get_result();



?>


<!DOCTYPE html>
<html>

<head>
    <title>Curriculum Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(135deg, #cbe4f9, #ffffff);
    }

    .hero-img {
        height: 350px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        transition: 0.3s ease;
    }

    .hero-img:hover {
        transform: translateY(-40px);
    }


    .search-box {
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .list-group {
        max-width: 800px;
        margin: 30px auto;

    }

    .list-group-item {
        border-radius: 12px !important;
        margin-bottom: 10px;
        transition: 0.3s;

    }


    .list-group-item:hover {
        background: #aad9fb;
        transform: translateX(5px);
    }
    </style>
</head>

<body>
    <?php include("navbar.php"); ?>
    <div class="container py-5">



        <!-- Image -->


        <div class="text-center mb-4">
            <?php if(!empty($firstRow['image'])){ ?>
            <img src="Admin/<?php echo $firstRow['image']; ?>" class="hero-img w-40">
            <?php } ?>


            <div class="text-center mb-4">

                <h2 class="fw-bold mt-4 text-primary">
                    🎓 <?php echo htmlspecialchars($grade); ?>
                </h2>

            </div>

        </div>


        <!-- Subject + Checkbox List -->
        <form method="POST" action="view_file.php">

            <ul class="list-group mt-4">

                <?php while($row = $result->fetch_assoc()){ ?>

                <li class="list-group-item"
                    onclick="window.location='view_file.php?file=<?php echo $row['file_path']; ?>'"
                    style="cursor:pointer;">

                    📘 <?php echo $row['subjects']; ?>

                </li>

                <?php } ?>

            </ul>
        </form>

    </div>


    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">© 2026 University of Computer Studies(Pathein). All Rights Reserved.</p>
    </footer>

</body>

</html>