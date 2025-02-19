<?php
include('connect.php');

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']);

    // Fetch file details
    $query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id'");
    $file = mysqli_fetch_assoc($query);

    if ($file) {
        $file_path = "uploads/" . $file['file_name']; // Adjust path

        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            die("File not found!");
        }
    } else {
        die("Invalid file ID!");
    }
} else {
    die("Invalid request!");
}
?>
