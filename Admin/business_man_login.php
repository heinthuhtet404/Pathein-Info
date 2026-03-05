<?php
session_start();
include("db.php");

if(isset($_POST['login'])){

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if(empty($email) || empty($password)){
echo "<script>alert('Email နှင့် Password ဖြည့်ပါ');</script>";
}

else{

$email = mysqli_real_escape_string($db,$email);

$query = "SELECT * FROM users WHERE email='$email' AND role_id=1 LIMIT 1";
$result = mysqli_query($db,$query);

if(mysqli_num_rows($result) == 1){

$user = mysqli_fetch_assoc($result);

/* Superadmin approve check */
if($user['status'] != 'Accept'){

echo "<script>alert('Superadmin မှ approve မလုပ်သေးပါ');</script>";

}

else{

/* password verify */
if(password_verify($password,$user['password'])){

$_SESSION['business_id']   = $user['user_id'];
$_SESSION['business_name'] = $user['business_name'];
$_SESSION['category_id']   = $user['category_id'];

$category = $user['category_id'];

/* Redirect based on business category */

switch($category){

case 1:
header("Location: school_dashboard.php");
break;

case 2:
header("Location: thantzinhtay.php");
break;

case 3:
header("Location: busline_dashboard.php");
break;

case 4:
header("Location: hotel_dashboard.php");
break;

case 5:
header("Location: product_dashboard.php");
break;

default:
header("Location: business_dashboard.php");
break;

}

exit();

}

else{

echo "<script>alert('Password မှားနေပါသည်');</script>";

}

}

}

else{

echo "<script>alert('Email မရှိပါ');</script>";

}

}

}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Business Man Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header text-center text-primary fw-bold">
<h3>Business Login</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="d-grid">
<button type="submit" name="login" class="btn btn-primary">
Login
</button>
</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>