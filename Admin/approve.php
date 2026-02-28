<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}

// Include PHPMailer from PHPMailer-master
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['id'])){
    $user_id = intval($_GET['id']);

    // Fetch user email and name
    $user_result = $db->query("SELECT email, name FROM users WHERE user_id=$user_id");
    if($user_result->num_rows > 0){
        $user = $user_result->fetch_assoc();
        $email = $user['email'];
        $name = $user['name'];

        // Generate random password
        function generateRandomPassword($length = 10){
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            $password = '';
            for($i=0; $i<$length; $i++){
                $password .= $chars[random_int(0, strlen($chars)-1)];
            }
            return $password;
        }

        $randomPassword = generateRandomPassword();
        $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);

        // Update user in database
        $stmt = $db->prepare("UPDATE users SET password=?, status='Accept', must_change_password=1 WHERE user_id=?");
        $stmt->bind_param("si", $hashedPassword, $user_id);

        if($stmt->execute()){
            // PHPMailer setup
            $mail = new PHPMailer(true);

            try {
                // Debug mode for troubleshooting
                $mail->SMTPDebug = 2; // 0 = off, 2 = detailed
                $mail->Debugoutput = 'html';

                // Gmail SMTP configuration
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'heinthuhtet2004@gmail.com'; // သင့် Gmail
                $mail->Password   = 'djtepvqfoxsudsyc';          // Gmail App Password (16-char)
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,        // Server certificate ကို verify မလုပ်ဘူး
        'verify_peer_name' => false,   // Server hostname ကို verify မလုပ်ဘူး
        'allow_self_signed' => true    // self-signed certificate (မယုံကြည်နိုင်တဲ့ certificate) ကိုလည်း allow
    ]
];

                // Email sender & recipient
                $mail->setFrom('heinthuhtet2004@gmail.com', 'Admin');
                $mail->addAddress($email, $name);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = "Your Account is Approved";
                $mail->Body    = "Hello $name,<br><br>"
                               . "Your account has been approved. Your login credentials are:<br><br>"
                               . "<strong>Email:</strong> $email<br>"
                               . "<strong>Password:</strong> $randomPassword<br><br>"
                               . "Please change your password after logging in.";

                $mail->send();

                echo "<script>alert('User approved, password generated and email sent.'); window.location.href='SuperAdminUserLists.php';</script>";
                exit;

            } catch (Exception $e) {
                // Debug message
                echo "<h3>User approved but email could not be sent</h3>";
                echo "<p>Error: {$mail->ErrorInfo}</p>";
                exit;
            }

        } else {
            echo "<script>alert('Failed to approve user.'); window.location.href='SuperAdminUserLists.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='SuperAdminUserLists.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No user ID provided.'); window.location.href='SuperAdminUserLists.php';</script>";
    exit;
}
?>