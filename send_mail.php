<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer
include('connect.php');

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendConfirmationEmail($user_email) {
    global $con; // Use the database connection

    // Fetch user details from the `register` table
    $query = mysqli_query($con, "SELECT * FROM register WHERE email = '$user_email'");
    $user = mysqli_fetch_assoc($query);

    if (!$user) {
        return "User not found!";
    }

    // User details
    $userName = $user['name'];
    $userMobile = $user['mobile'];
    $registrationDate = $user['date'];  // Ensure 'date' column exists or use `registration_date`
    $status = $user['status'];
    $userPassword = $user['pass']; // ⚠️ Avoid sending plaintext passwords via email
    $profilePhoto = "http://localhost/file_system/profile_img/" . $user['photo']; // Adjust path if needed

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST'); 
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER'); 
        $mail->Password   = getenv('SMTP_PASS'); 
        $mail->SMTPSecure = getenv('SMTP_SECURE') === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = getenv('SMTP_PORT'); 

        // Sender details
        $mail->setFrom(getenv('SMTP_USER'), 'File_System');
        $mail->addAddress($user_email, $userName);
        $mail->Subject = 'Welcome to Our Platform!';
        $mail->isHTML(true);

        // Email body
        $mail->Body = "
            <h3>Hi, $userName! 👋</h3>
            <p>Thank you for registering on our platform.</p>
            <p><strong>Registration Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> $userName</li>
                <li><strong>Email:</strong> $user_email</li>
                <li><strong>Mobile:</strong> $userMobile</li>
            </ul>
            <p>We are excited to have you onboard!</p>
            <p>Best Regards!<br>Hemant Gowardipe</p>
        ";

        return $mail->send() ? true : "Mailer Error: " . $mail->ErrorInfo;
    } catch (Exception $e) {
        return "Exception Error: " . $e->getMessage();
    }
}
?>
