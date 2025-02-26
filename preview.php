<?php
include('connect.php');

if (isset($_GET['id'])) {
    $fileId = intval($_GET['id']);
    $result = $con->query("SELECT file_name, file_path, file_type FROM uploads WHERE id = $fileId");

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        $filePath = $file['file_path'];
        $fileType = $file['file_type'];
    } else {
        die("File not found!");
    }
} else {
    die("Invalid file request!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Preview</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        .preview-container {
            width: 90%;
            max-width: 1000px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        img, video {
            width: 100%;
            max-height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        iframe {
            width: 100%;
            height: 80vh; /* Increased height for better PDF view */
            border: none;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <h2>File Preview</h2>
        <?php
        if ($fileType === 'image') {
            echo "<img src='$filePath' alt='Image Preview'>";
        } elseif ($fileType === 'video') {
            echo "<video controls><source src='$filePath' type='video/mp4'>Your browser does not support the video tag.</video>";
        } elseif (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf') {
            echo "<iframe src='$filePath' width='100%' height='90vh'></iframe>";
        }
        else {
            echo "<p>Unsupported file type!</p>";
        }
        ?>
    </div>
</body>
</html>
