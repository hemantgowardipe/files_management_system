<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Load dependencies
include('connect.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendOTPEmail($user_email) {
    global $con;

    // Generate 6-digit OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp; // Store OTP in session

    $query = mysqli_query($con, "SELECT * FROM register WHERE email = '$user_email'");
    $user = mysqli_fetch_assoc($query);

    if (!$user) {
        return "User not found!";
    }

    $userName = $user['name'];
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Email Details
        $mail->setFrom($_ENV['SMTP_USER'], 'File_System');
        $mail->addAddress($user_email, $userName);
        $mail->Subject = 'Password Reset OTP';
        $mail->isHTML(true);

        // Email Body
        $mail->Body = "
            <h3>Hi, $userName!</h3>
            <p>You requested to reset your password.</p>
            <p><strong>Your OTP is: <span style='color: red;'>$otp</span></strong></p>
            <p>Please enter this OTP to reset your password.</p>
            <p>If you did not request this, please ignore this email.</p>
            <p>Best Regards, <br>Hemant Gowardipe</p>
        ";

        return $mail->send() ? true : "Mailer Error: " . $mail->ErrorInfo;
    } catch (Exception $e) {
        return "Exception Error: " . $e->getMessage();
    }
}
?>