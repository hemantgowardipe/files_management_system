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

// Fetch the file to delete
$query = mysqli_query($con, "SELECT * FROM recently_deleted WHERE id = '$file_id' AND user_id = '$user_id'");
$file = mysqli_fetch_assoc($query);

if (!$file) {
    die("File not found or unauthorized access!");
}

$file_path = __DIR__ . '/' . $file['file_path']; // Get the full file path

// Delete the file from storage
if (file_exists($file_path)) {
    unlink($file_path); // Remove from server
}

// Remove from the database
$deleteQuery = "DELETE FROM recently_deleted WHERE id = '$file_id'";
if (mysqli_query($con, $deleteQuery)) {
    echo "<script>alert('File permanently deleted!'); window.location.href='recently_deleted.php';</script>";
} else {
    echo "<script>alert('Error deleting file.'); window.location.href='recently_deleted.php';</script>";
}
?>
