<?php
session_start();
include('connect.php'); // Ensure this file contains a valid DB connection

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "0";
    exit;
}

// Use correct table name (change `documents` to your actual table name)
$user_id = $_SESSION['id'];
$query = "SELECT COUNT(*) AS file_count FROM uploads WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['file_count']; // Output the count
} else {
    echo "0"; // If query fails, return 0
}
?>
