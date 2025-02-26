<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Load dependencies

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendConfirmationEmail($user_email, $user_name) {
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
        $mail->addAddress($user_email, $user_name);
        $mail->Subject = 'Welcome to Our Platform!';
        $mail->isHTML(true);
        $mail->Body = "<h3>Hi, $user_name!</h3><p>Thank you for registering.</p>";

        return $mail->send() ? true : "Mailer Error: " . $mail->ErrorInfo;
    } catch (Exception $e) {
        return "Exception Error: " . $e->getMessage();
    }
}
?>
