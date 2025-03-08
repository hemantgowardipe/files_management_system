<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

if (!isset($_GET['file_id'])) {
    die("Invalid request!");
}

$file_id = intval($_GET['file_id']);
$user_id = $_SESSION['id'];

// Get the deleted file details
$query = mysqli_query($con, "SELECT * FROM recently_deleted WHERE id = '$file_id' AND user_id = '$user_id'");
$file = mysqli_fetch_assoc($query);

if (!$file) {
    die("File not found or unauthorized access!");
}

// Restore file to the main uploads table
$restoreQuery = "INSERT INTO uploads (user_id, file_name, file_path, uploaded_at) 
                 VALUES ('$user_id', '{$file['file_name']}', '{$file['file_path']}', NOW())";

if (mysqli_query($con, $restoreQuery)) {
    // Remove from recently_deleted table
    mysqli_query($con, "DELETE FROM recently_deleted WHERE id = '$file_id'");
    echo "<script>alert('File restored successfully!'); window.location.href='recently_deleted.php';</script>";
} else {
    echo "<script>alert('Error restoring file.'); window.location.href='recently_deleted.php';</script>";
}
?>
