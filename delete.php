<?php
session_start();
include('connect.php');

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']);
    $user_id = $_SESSION['id'];

    // Fetch file details
    $file_query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");
    $file = mysqli_fetch_assoc($file_query);

    if ($file) {
        // Move file details to recently_deleted table
        $insert_query = "INSERT INTO recently_deleted (user_id, file_name, file_path) 
                         VALUES ('$user_id', '{$file['file_name']}', '{$file['file_path']}')";
        mysqli_query($con, $insert_query);

        // Delete file from uploads table
        $delete_query = "DELETE FROM uploads WHERE id = '$file_id'";
        mysqli_query($con, $delete_query);

        echo "<script>alert('File moved to Recently Deleted.'); window.location.href='managefiles.php';</script>";
    } else {
        echo "<script>alert('File not found!');</script>";
    }
}
?>
