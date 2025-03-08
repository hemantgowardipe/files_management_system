<?php
session_start();
require 'connect.php';
require 'vendor/autoload.php'; // PHPMailer
require 'vendor/vlucas/phpdotenv/src/Dotenv.php'; // Load .env file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

// Check if file_id is present in the URL
if (!isset($_GET['file_id'])) {
    die("Invalid request! No file selected.");
}

$file_id = intval($_GET['file_id']);
$user_id = $_SESSION['id'];

// Fetch file details
$query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");
$file = mysqli_fetch_assoc($query);

if (!$file) {
    die("File not found or unauthorized access!");
}

// Handle form submission for email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipient_email'])) {
    $recipient_email = filter_var($_POST['recipient_email'], FILTER_VALIDATE_EMAIL);

    if (!$recipient_email) {
        die("<script>alert('Invalid email address!');</script>");
    }

    $file_path = __DIR__ . '/' . $file['file_path']; // Full path
    $file_name = $file['file_name'];

    if (!file_exists($file_path)) {
        die("File not found!");
    }

    // Setup PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $mail->Port       = $_ENV['SMTP_PORT'];

        // Email content
        $mail->setFrom($_ENV['SMTP_USER'], 'File Share System');
        $mail->addAddress($recipient_email);
        $mail->Subject = "File Shared: $file_name";
        $sender_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Unknown';  
        $sender_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Anonymous User';

        $mail->Body = "Hello,\n\nA file has been shared with you. Please find the attachment.\n\nBest Regards,\n$sender_name ($sender_email)";

        $mail->addAttachment($file_path, $file_name);
        // Attach the file

        // Send email
        $mail->send();
        echo "<script>alert('File sent successfully to $recipient_email'); window.location.href='managefiles.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">
    <div class="container mt-5 text-center">
        <h2>Share File: <?php echo htmlspecialchars($file['file_name']); ?></h2>
        
        <form method="POST" class="mt-3">
            <label for="recipient_email" class="form-label">Enter recipient's email:</label>
            <input type="email" name="recipient_email" id="recipient_email" class="form-control mb-3" required>
            <button type="submit" class="btn btn-primary">Send via Gmail</button>
        </form>

        <a href="managefiles.php" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>
