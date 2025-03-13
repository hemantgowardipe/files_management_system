<?php
session_start();
include('connect.php');

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']);
    
    // Fetch file details before deletion
    $fileQuery = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id'");
    $file = mysqli_fetch_assoc($fileQuery);

    if ($file) {
        $user_id = $file['user_id'];
        $file_name = mysqli_real_escape_string($con, $file['file_name']);
        $file_path = mysqli_real_escape_string($con, $file['file_path']);
        $file_type = mysqli_real_escape_string($con, $file['file_type']);

        // ✅ Insert into recently_deleted without file_id
        $insertQuery = "INSERT INTO recently_deleted (user_id, file_name, file_path, file_type, deleted_at) 
                        VALUES ('$user_id', '$file_name', '$file_path', '$file_type', NOW())";
        
        if (mysqli_query($con, $insertQuery)) {
            // ✅ If insertion successful, delete from uploads
            $deleteQuery = "DELETE FROM uploads WHERE id = '$file_id'";
            if (mysqli_query($con, $deleteQuery)) {
                echo "<script>alert('File moved to trash!'); window.location.href='dashboard.php';</script>";
            } else {
                die("❌ Error deleting from uploads: " . mysqli_error($con));
            }
        } else {
            die("❌ Error inserting into recently_deleted: " . mysqli_error($con));
        }
    } else {
        echo "<script>alert('File not found!'); window.history.back();</script>";
    }
}
?>
