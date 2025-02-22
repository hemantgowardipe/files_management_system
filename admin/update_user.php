<?php
include('connect.php');

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE register SET status='$status' WHERE id='$id'";
    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
