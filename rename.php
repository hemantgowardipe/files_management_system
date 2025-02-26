<?php
session_start();
include('connect.php'); // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id']; // Get logged-in user ID
    $file_id = intval($_POST['file_id']);
    $newName = trim($_POST['new_name']);

    // Validate input
    if (empty($newName)) {
        echo json_encode(["status" => "error", "message" => "File name cannot be empty."]);
        exit();
    }

    // Prevent SQL Injection
    $newName = mysqli_real_escape_string($con, $newName);

    // Check if file exists in DB
    $query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");
    $file = mysqli_fetch_assoc($query);

    if (!$file) {
        echo json_encode(["status" => "error", "message" => "File not found in database."]);
        exit();
    }

    // Update database (Only change name in DB, not in storage)
    $updateQuery = "UPDATE uploads SET file_name = '$newName' WHERE id = '$file_id' AND user_id = '$user_id'";
    if (mysqli_query($con, $updateQuery)) {
        echo json_encode(["status" => "success", "message" => "File name updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed."]);
    }
}
?>
