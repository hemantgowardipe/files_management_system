<?php
session_start();
include('connect.php'); // Ensure the database connection is established

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id']; // Get logged-in user ID
    $oldName = trim($_POST['old_name']);
    $newName = trim($_POST['new_name']);

    // Validate input
    if (empty($oldName) || empty($newName)) {
        echo json_encode(["status" => "error", "message" => "Invalid file name."]);
        exit();
    }

    // Prevent directory traversal attacks
    $oldName = basename($oldName);
    $newName = basename($newName);

    // Define file paths
    $uploadDir = "uploads/"; // Ensure this directory is correct
    $oldFilePath = $uploadDir . $oldName;
    $newFilePath = $uploadDir . $newName;

    // Debugging: Check if file exists
    if (!file_exists($oldFilePath)) {
        echo json_encode(["status" => "error", "message" => "File not found."]);
        exit();
    }

    // Debugging: Check if new file name already exists
    if (file_exists($newFilePath)) {
        echo json_encode(["status" => "error", "message" => "A file with this name already exists."]);
        exit();
    }

    // Rename file
    if (rename($oldFilePath, $newFilePath)) {
        // Update database record
        $updateQuery = "UPDATE uploads SET file_name = '$newName' WHERE file_name = '$oldName' AND user_id = '$user_id'";
        
        if (mysqli_query($con, $updateQuery)) {
            echo json_encode(["status" => "success", "message" => "File renamed successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database update failed."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "File rename failed due to permission issues."]);
    }
}
?>
