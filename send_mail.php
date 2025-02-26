<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Load dependencies
include('connect.php');

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendConfirmationEmail($user_email) {
    global $con; // Use database connection

    // Fetch user details from the `register` table
    $query = mysqli_query($con, "SELECT * FROM register WHERE email = '$user_email'");
    $user = mysqli_fetch_assoc($query);

    if (!$user) {
        return "User not found!";
    }

    $userName = $user['name'];
    $userMobile = $user['mobile'];
    $registrationDate = $user['date'];
    $status = $user['status'];
    $userPassword = $user['pass']; // Consider hashing passwords instead of sending plain text!
    $profilePhoto = "http://localhost/file_system/profile_img/" . $user['photo']; // Adjust the path if needed

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
        $mail->Subject = 'Welcome to Our Platform!';
        $mail->isHTML(true);

        // Email Body with Registration Details
        $mail->Body = "
            <h3>Hi, $userName!</h3>
            <p>Thank you for registering on our platform.</p>
            <p><strong>Registration Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> $userName</li>
                <li><strong>Email:</strong> $user_email</li>
                <li><strong>Mobile:</strong> $userMobile</li>
            </ul>
            <p>We are excited to have you onboard!</p>
            <P>Best Regars! <br>Hemant Gowardipe</br></p>
        ";

        return $mail->send() ? true : "Mailer Error: " . $mail->ErrorInfo;
    } catch (Exception $e) {
        return "Exception Error: " . $e->getMessage();
    }
}
?>
