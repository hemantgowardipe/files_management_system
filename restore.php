<?php
session_start();
include('connect.php');

if (isset($_GET['file_name'])) {
    $file_name = mysqli_real_escape_string($con, $_GET['file_name']);

    // Fetch file details from recently_deleted
    $fileQuery = mysqli_query($con, "SELECT * FROM recently_deleted WHERE file_name = '$file_name'");
    $file = mysqli_fetch_assoc($fileQuery);

    if ($file) {
        $user_id = $file['user_id'];
        $file_path = mysqli_real_escape_string($con, $file['file_path']);
        $file_type = mysqli_real_escape_string($con, $file['file_type']);

        // Restore the file back to uploads
        $restoreQuery = "INSERT INTO uploads (user_id, file_name, file_path, file_type, upload_time) 
                         VALUES ('$user_id', '$file_name', '$file_path', '$file_type', NOW())";

        if (mysqli_query($con, $restoreQuery)) {
            // Remove from recently_deleted after restoring
            mysqli_query($con, "DELETE FROM recently_deleted WHERE file_name = '$file_name'");
            echo "<script>alert('File restored successfully!'); window.location.href='recently_deleted.php';</script>";
        } else {
            die("Error restoring file: " . mysqli_error($con));
        }
    } else {
        echo "<script>alert('File not found in trash!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.history.back();</script>";
}
?>
