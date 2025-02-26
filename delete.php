<?php
session_start();
include('connect.php');

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']); // Sanitize input
    $user_id = $_SESSION['id']; // Ensure user can only delete their own files

    // Fetch file details
    $query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");
    $file = mysqli_fetch_assoc($query);

    if ($file) {
        $file_path = "uploads/" . $file['file_name']; // Adjust path if needed

        // Delete file from storage
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Remove record from database
        mysqli_query($con, "DELETE FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");

        // Reorder IDs (Optional, only if you want to reset them)
        mysqli_query($con, "SET @num := 0");
        mysqli_query($con, "UPDATE uploads SET id = @num := (@num+1)");
        mysqli_query($con, "ALTER TABLE uploads AUTO_INCREMENT = 1");

        // Redirect with success message
        header("Location: managefiles.php?message=File deleted successfully");
        exit();
    } else {
        die("File not found or unauthorized access!");
    }
} else {
    die("Invalid request!");
}
?>
