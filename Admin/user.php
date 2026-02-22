<?php



include 'db.php';

// Get data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';
$role = $_POST['role'] ?? '';

// 1️⃣ Required fields
if (!$name || !$email || !$password || !$confirm || !$role) {
header("Location: register.php?error=All+required+fields+must+be+filled");
exit;
}

// 2️⃣ Email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
header("Location: register.php?error=Invalid+email+format");
exit;
}

// 3️⃣ Strong password
$strong =
strlen($password) >= 8 &&
preg_match('/[A-Z]/', $password) &&
preg_match('/[a-z]/', $password) &&
preg_match('/[0-9]/', $password);

if (!$strong) {
header("Location: register.php?error=Password+is+not+strong+enough");
exit;
}

// 4️⃣ Password match
if ($password !== $confirm) {
header("Location: register.php?error=Passwords+do+not+match");
exit;
}

// 5️⃣ Email duplicate
$check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
header("Location: register.php?error=Email+already+exists");
exit;
}
$check->close();

// 6️⃣ Hash password
$hashed = password_hash($password, PASSWORD_BCRYPT);

// 7️⃣ Insert
$sql = "INSERT INTO users (name, email, phone, password, role, created_at)
VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $phone, $hashed, $role);

if ($stmt->execute()) {
header("Location: login.php?success=1");
} else {
header("Location: register.php?error=Something+went+wrong");
}

$stmt->close();
$conn->close();

?>