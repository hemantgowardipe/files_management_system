<?php
session_start();
include('connect.php');

if (isset($_GET['file_name'])) {
    $file_name = mysqli_real_escape_string($con, $_GET['file_name']);

    // Delete the file permanently from recently_deleted
    $deleteQuery = "DELETE FROM recently_deleted WHERE file_name = '$file_name'";

    if (mysqli_query($con, $deleteQuery)) {
        echo "<script>alert('File permanently deleted!'); window.location.href='recently_deleted.php';</script>";
    } else {
        die("Error deleting file: " . mysqli_error($con));
    }
} else {
    echo "<script>alert('Invalid request!'); window.history.back();</script>";
}
?>
