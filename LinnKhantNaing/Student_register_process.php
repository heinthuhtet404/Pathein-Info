<?php
include("Admin/db.php");

$school_id    = $_POST['school_id'];
$student_name = $_POST['student_name'];
$parent_name  = $_POST['parent_name'];
$phone        = $_POST['phone'];
$grade        = $_POST['grade'];

/* 1️⃣ Capacity Check */
$capacity_q = mysqli_query($db,"
SELECT max_students FROM grade_capacity
WHERE school_id='$school_id' AND grade='$grade'
");
$cap_row = mysqli_fetch_assoc($capacity_q);
$max = $cap_row['max_students'];

$count_q = mysqli_query($db,"
SELECT COUNT(*) as total FROM studentregisters
WHERE school_id='$school_id'
AND grade='$grade'
AND status='accepted'
");
$count_row = mysqli_fetch_assoc($count_q);
$current = $count_row['total'];

if($current >= $max){
    echo "<script>
    alert('လူဦးရေပြည့်နေပါပြီ');
    window.location='schoolDetail.php?id=$school_id';
    </script>";
    exit();
}

/* 2️⃣ Fee Calculate */
$getFee = mysqli_query($db,"
SELECT (general_fee + document_fee + uniform_fee) AS total
FROM grade_fee
WHERE school_id='$school_id'
AND grade='$grade'
");

$feeRow = mysqli_fetch_assoc($getFee);
$total_fee = $feeRow['total'];

/* 3️⃣ Upload Files */
$photo_dir = "uploads/students/";
if(!is_dir($photo_dir)){ mkdir($photo_dir,0777,true); }

$photo_name = time()."_photo_".$_FILES['student_photo']['name'];
move_uploaded_file($_FILES['student_photo']['tmp_name'],$photo_dir.$photo_name);

$pay_dir = "uploads/payments/";
if(!is_dir($pay_dir)){ mkdir($pay_dir,0777,true); }

$pay_name = time()."_pay_".$_FILES['payment_screenshot']['name'];
move_uploaded_file($_FILES['payment_screenshot']['tmp_name'],$pay_dir.$pay_name);

/* 4️⃣ Insert (ONE TIME ONLY) */
mysqli_query($db,"
INSERT INTO studentregisters
(school_id, student_name, parent_name, phone, grade, student_photo, payment_screenshot, fee, payment, status)
VALUES
('$school_id','$student_name','$parent_name','$phone','$grade','$photo_name','$pay_name','$total_fee','pending','pending')
");

echo "<script>
alert('Registration Submitted Successfully');
window.location='schoolDetail.php?id=$school_id';
</script>";
?>