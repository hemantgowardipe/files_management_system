<?php
include('connect.php');
session_start();

$user_id = $_SESSION['id']; // Get logged-in user ID

// Fetch total file size in MB
$query = mysqli_query($con, "SELECT SUM(file_size) AS total_size FROM uploads WHERE user_id = '$user_id'");
$row = mysqli_fetch_assoc($query);
$totalSizeMB = $row['total_size'] ? round($row['total_size'] / (1024 * 1024), 2) : 0; // Convert bytes to MB

echo $totalSizeMB; // Output total storage in MB
?>
