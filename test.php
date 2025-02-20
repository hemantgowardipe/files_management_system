<?php
$file_name = "Round-1ProblemStatements.pdf";
$file_path = realpath(__DIR__ . "/uploads/" . $file_name);

if (!$file_path || !file_exists($file_path)) {
    die("Error: File not found at " . htmlspecialchars(__DIR__ . "/uploads/" . $file_name));
}

echo "File exists at: " . $file_path;
?>
