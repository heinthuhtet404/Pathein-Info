<?php
include("Admin/db.php");

$id = $_GET['id'];

$query = "SELECT * FROM schools WHERE school_id='$id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <title>School Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="schoolDetail.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <?php include("navbar.php"); ?>

    <div class="container py-5">

        <!-- HERO -->
        <div class="text-center mb-3">
            <?php if(!empty($row['logo'])){ ?>
            <img src="Admin/uploads/<?php echo $row['logo']; ?>" class="hero-img w-100">
            <?php } else { ?>
            <img src="Photo/photo1.jpg" class="hero-img w-100">
            <?php } ?>

            <h2 class="fw-bold mt-4"><?php echo $row['name']; ?></h2>
            <h6 class="fw-bold mt-4"><?php echo $row['description']; ?></h6>

        </div>

        <!-- Basic Info -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="info-card text-center">
                    <h6>📍 Address</h6>
                    <p><?php echo $row['address']; ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card text-center">
                    <h6>📞 Phone</h6>
                    <p><?php echo $row['phone']; ?></p>
                </div>
            </div>

            <!-- <div class="col-md-4">
                <div class="info-card text-center">
                    <h6>👩‍🏫 School Type</h6>
                    <p><?php echo $row['type']; ?></p>
                </div>
            </div>
        </div> -->
            <div class="col-md-4">
                <div class="info-card text-center">
                    <h6>
                        <i class="fas fa-school text-primary"></i>
                        School Type
                    </h6>
                    <p><?php echo $row['type']; ?></p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-center flex-wrap gap-3 mb-4 pt-3">
                <button class="nav-btn" onclick="showTab('teachers')">ဆရာ/ဆရာမအင်အား</button>
                <button class="nav-btn" onclick="showTab('curriculum')">Curriculum</button>
                <button class="nav-btn" onclick="showTab('activity')">Activities</button>
                <button class="nav-btn" onclick="showTab('fee')">Payment Fee</button>
                <button class="nav-btn" onclick="showTab('announcement')">Announcements</button>

                <?php if($row['ownership'] == 'government'){ ?>

                <button class="nav-btn" disabled>
                    Register Students (Offline Only)
                </button>

                <div class="alert alert-info mt-2 text-center">
                    ဒီကျောင်းမှာ လူကိုယ်တိုင်လာရောက်အပ်နှံရပါမည်။
                </div>

                <?php } else { ?>

                <button class="nav-btn" onclick="showTab('registerStudent')">
                    Register Students
                </button>

                <?php } ?>

            </div>

            <!-- Dynamic Content -->
            <!-- <div id="teachers" class="tab-content-box">
            <h5>👩‍🏫 ဆရာ/ဆရာမအင်အား</h5>
            <p>ဆရာ/ဆရာမစုစုပေါင်း - <?php echo $row['total_teachers']; ?> ဦး</p>
        </div> -->

            <div id="teachers" class="tab-content-box" style="display:none;">
                <?php
$school_id = $row['school_id'];

$_SESSION['schoolID']=$school_id;

$teacher_query = "SELECT * FROM teachers WHERE school_id='$school_id'";
$teacher_result = mysqli_query($db, $teacher_query);
?>
                <?php if(mysqli_num_rows($teacher_result) > 0){ 
              
$total_teachers = mysqli_num_rows($teacher_result);

                ?>




                <div class="row">
                    <h4 class="mb-4 text-primary fw-bold">
                        👩‍🏫 ဆရာ/ဆရာမအင်အား
                        <span class="badge bg-primary rounded-pill">
                            (စုစုပေါင်းအရေအတွက် = <?php echo $total_teachers; ?> ယောက်)
                        </span>
                    </h4>

                    <?php while($teacher = mysqli_fetch_assoc($teacher_result)) { ?>

                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0 rounded-4 h-100">
                            <div class="card-body text-center">

                                <h5 class="fw-bold mb-2">
                                    <?php echo $teacher['teacher_name']; ?>
                                </h5>

                                <p class="mb-1">
                                    📘 <strong>Subject:</strong>
                                    <?php echo $teacher['subject']; ?>
                                </p>

                                <p class="text-muted">
                                    🎓 <?php echo $teacher['qualification']; ?>
                                </p>

                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>

                <?php } else { ?>

                <div class="alert alert-warning text-center">
                    ဆရာ/ဆရာမအချက်အလက်မရှိသေးပါ။
                </div>

                <?php } ?>

            </div>


            <div id="curriculum" class="tab-content-box" style="display:none;">

                <?php
// $curriculum_query = "SELECT * FROM curriculums WHERE school_id='$school_id'";

$curriculum_query = "
    SELECT *
    FROM curriculums 
    WHERE school_id='$school_id'
    GROUP BY grade
    ORDER BY grade ASC";


$curriculum_result = mysqli_query($db, $curriculum_query);
$total_curriculum = mysqli_num_rows($curriculum_result);
?>

                <h4 class="mb-4 text-primary fw-bold">
                    📚 Curriculum
                    <!-- <span class="badge bg-success rounded-pill">
                    (စုစုပေါင်း = <?php echo $total_curriculum; ?> ခု)
                </span> -->
                </h4>

                <div class="row">

                    <?php while($cur = mysqli_fetch_assoc($curriculum_result))

                    
                    { ?>

                    <div class="col-md-4 mb-4">
                        <div class="card curriculum-card border-0 shadow rounded-4 h-100">

                            <?php if(!empty($cur['image'])){ ?>



                            <img src="Admin/<?php echo $cur['image']; ?>" class="card-img-top"
                                style="height:200px; object-fit:cover;">
                            <?php } ?>

                            <div class="card-body text-center">
                                <h5 class="fw-bold text-primary">
                                    <?php echo $cur['grade']; ?>
                                </h5>

                                <a href="curriculum_detail.php?school_id=<?php echo $school_id; ?>&grade=<?php echo $cur['grade']; ?>"
                                    class="btn btn-gradient mt-3">
                                    View Detail →
                                </a>

                            </div>

                        </div>
                    </div>

                    <?php } ?>

                </div>
            </div>






            <div id="activity" class="tab-content-box" style="display:none;">
                <h5>🎯 Activities</h5>
                <p>School Activities Information Here...</p>
            </div>

            <div id="fee" class="tab-content-box" style="display:none;">
                <h5>💵 Payment Fee</h5>
                <p>School Fee Information Here...</p>
            </div>

            <div id="announcement" class="tab-content-box" style="display:none;">
                <h5>📢 Announcements</h5>
                <p>Latest Announcements Here...</p>
            </div>


            <!--Start Register Student Form -->
            <div id="registerStudent" class="tab-content-box" style="display:none;">

                <?php
$check_full = mysqli_query($db,"
SELECT gf.grade, gc.max_students
FROM grade_fee gf
JOIN grade_capacity gc 
ON gf.school_id = gc.school_id 
AND gf.grade = gc.grade
WHERE gf.school_id='$school_id'
");

$all_full = true;

while($row_full = mysqli_fetch_assoc($check_full)){
    $grade = $row_full['grade'];
    $max = $row_full['max_students'];

    $count = mysqli_fetch_assoc(mysqli_query($db,"
        SELECT COUNT(*) as total FROM studentregisters
        WHERE school_id='$school_id'
        AND grade='$grade'
        AND status='accepted'
    "))['total'];

    if($count < $max){
        $all_full = false;
        break;
    }
}
if($all_full){
    echo '<div class="alert alert-danger text-center">
          ယခုကျောင်းတွင် Grade အားလုံး လူဦးရေပြည့်နေပါပြီ။
          </div>';
} else {

?>


                <form method="POST" action="Student_register_process.php" enctype="multipart/form-data">

                    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">

                    <div class="mb-3">
                        <label>Student Name</label>
                        <input type="text" name="student_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Parent Name</label>
                        <input type="text" name="parent_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <!--Start For Grade -->
                    <div class="mb-3">
                        <label>Grade</label>
                        <select name="grade" id="gradeSelect" class="form-control" required>
                            <option value="">Select Grade</option>

                            <?php
$grade_q = mysqli_query($db,"
SELECT gf.grade, gc.max_students
FROM grade_fee gf
LEFT JOIN grade_capacity gc 
ON gf.school_id = gc.school_id 
AND gf.grade = gc.grade
WHERE gf.school_id='$school_id'
");

while($g = mysqli_fetch_assoc($grade_q)){

    $grade = $g['grade'];
    $max = $g['max_students'];

    // Accepted student count
    $count_q = mysqli_query($db,"
    SELECT COUNT(*) as total 
    FROM registers
    WHERE school_id='$school_id'
    AND grade='$grade'
    AND status='accepted'
    ");
    $count_row = mysqli_fetch_assoc($count_q);
    $current = $count_row['total'];

    if($current >= $max){
        echo "<option value='$grade' disabled>
              $grade (ပြည့်နေပါပြီ)
              </option>";
    } else {
        echo "<option value='$grade'>
              $grade ($current / $max)
              </option>";
    }
}
?>

                        </select>
                    </div>





                    <!-- End For Grade -->


                    <!-- ✅ Student Photo -->
                    <div class="mb-3">
                        <label>Student Photo</label>
                        <input type="file" name="student_photo" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label>Payment Screenshot</label>
                        <input type="file" name="payment_screenshot" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Submit Registration
                    </button>

                </form>

                <?php } ?>
                <!--Start alert message for greader than max student -->
                <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
                <?php endif; ?>






                <!--End alert message for greader than max student -->
            </div>

            <!-- End Student Register Form -->
        </div>
    </div>
    <script>
    function showTab(id) {
        let tabs = document.querySelectorAll('.tab-content-box');
        tabs.forEach(tab => tab.style.display = "none");
        document.getElementById(id).style.display = "block";
    }
    </script>

    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">© 2026 University of Computer Studies(Pathein). All Rights Reserved.</p>
    </footer>


</body>

</html>