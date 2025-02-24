<?php
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["croppedImage"])) {
    $id = $_SESSION['id'];
    $imageName = "profile_" . time() . ".png";
    $targetPath = "profile_img/" . $imageName;

    // Move the uploaded file
    if (move_uploaded_file($_FILES["croppedImage"]["tmp_name"], $targetPath)) {
        // Update the database
        $updateQuery = "UPDATE register SET photo='$imageName' WHERE id='$id'";
        if (mysqli_query($con, $updateQuery)) {
            echo json_encode(["success" => true, "filename" => $imageName]);
        } else {
            echo json_encode(["success" => false, "error" => "Database update failed"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "File upload failed"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
