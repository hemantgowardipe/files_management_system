<?php
session_start();
include('connect.php');

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']); 
    $user_id = $_SESSION['id']; 

    $query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");
    $file = mysqli_fetch_assoc($query);

    if ($file) {
        $file_name = $file['file_name'];
        $file_path = realpath(__DIR__ . "/uploads/" . $file_name);

        if (!$file_path || !file_exists($file_path)) {
            die("Error: File not found at " . htmlspecialchars(__DIR__ . "/uploads/" . $file_name));
        }

        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($file_name) . "\"");
        header("Content-Length: " . filesize($file_path));

        readfile($file_path);
        exit;
    } else {
        die("File not found or unauthorized access!");
    }
} else {
    die("Invalid request!");
}
?>
