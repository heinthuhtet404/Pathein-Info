<?php
include("Admin/db.php");


$query = "SELECT school_id, name, logo, academic_type 
          FROM schools 
          WHERE status='active' 
          AND academic_type='school'
          ORDER BY school_id DESC 
          LIMIT 1";
;
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
</head>

<body>

    <?php include('navbar.php'); ?>

    <div class="container py-5">
        <div class="row g-4">

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

            <div class="col-md-4">
                <div class="card school-card">

                    <?php if(!empty($row['logo'])){ ?>
                    <img src="Admin/uploads/<?php echo $row['logo']; ?>" class="card-img-top school-img">
                    <?php } else { ?>
                    <img src="Photo/photo1.jpg" class="card-img-top school-img">
                    <?php } ?>

                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-3">စာသင်ကျောင်းများ</h5>

                        <a href="school.php?academicType=<?php echo $row['academic_type']; ?>"
                            class="btn btn-primary btn-detail">
                            အသေးစိတ်ကြည့်ရှုရန်
                        </a>

                    </div>


                </div>
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-3">တက္ကသိုလ်များ</h5>

                    <!-- <a href="university.php?academicType=<?php echo $row['academic_type']; ?>"
                            class="btn btn-primary btn-detail">
                            အသေးစိတ်ကြည့်ရှုရန်
                        </a> -->

                </div>

            </div>

            <?php } ?>

        </div>
    </div>
    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">© 2026 University of Computer Studies(Pathein). All Rights Reserved.</p>
    </footer>


</body>

</html>