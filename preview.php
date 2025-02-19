<?php
    if (isset($_GET['file'])) {
        $fileName = basename($_GET['file']); // Securely get filename
        $filePath = __DIR__ . "../uploads/" . $fileName; // Full file path

        // DEBUG: Show the path in the browser
        echo "Checking file at path: " . $filePath . "<br>";

        // Check if file exists
        if (!file_exists($filePath)) {
            die("Error: File not found! File path: " . $filePath);
        }

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoTypes = ['mp4', 'webm', 'ogg'];
        $pdfTypes = ['pdf'];

        if (in_array($fileExtension, $imageTypes)) {
            header("Content-Type: imgage/$fileExtension");
            readfile($filePath);
        } elseif (in_array($fileExtension, $videoTypes)) {
            header("Content-Type: video/$fileExtension");
            readfile($filePath);
        } elseif (in_array($fileExtension, $pdfTypes)) {
            header("Content-Type: application/pdf");
            readfile($filePath);
        } else {
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            readfile($filePath);
        }
    } else {
        die("Error: No file specified!");
    }
?>
