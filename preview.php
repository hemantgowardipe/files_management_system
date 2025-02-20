<?php 
    include('connect.php'); 

    if(isset($_GET['file'])) {
        $fileName = $_GET['file'];
        $filePath = "uploads/" . $fileName;
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $fileSize = filesize($filePath);
        $fileSizeMB = number_format($fileSize / 1048576, 2) . ' MB'; 
    } else {
        die("Invalid file.");
    }

    if(isset($_POST['rename'])) {
        $newName = $_POST['new_name'];
        $newPath = "uploads/" . $newName;
        
        if(rename($filePath, $newPath)) {
            $fileName = $newName;
            $filePath = $newPath;
            echo "<script>alert('File renamed successfully!'); window.location='preview.php?file=$newName';</script>";
        } else {
            echo "<script>alert('Failed to rename file!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - <?php echo $fileName; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>File Preview</h3>
<p><strong>Name:</strong> <?php echo $fileName; ?></p>
<p><strong>Size:</strong> <?php echo $fileSizeMB; ?></p>
<p><strong>Type:</strong> <?php echo strtoupper($fileExtension); ?></p>

<div class="preview-container">
    <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
        <img src="<?php echo $filePath; ?>" class="img-fluid" style="max-width: 100%; height: auto;">
    
    <?php elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])): ?>
        <video controls style="width: 100%;">
            <source src="<?php echo $filePath; ?>" type="video/<?php echo $fileExtension; ?>">
            Your browser does not support video playback.
        </video>
    
    <?php elseif ($fileExtension === 'pdf'): ?>
        <iframe src="<?php echo $filePath; ?>" width="100%" height="600px"></iframe>
    
    <?php else: ?>
        <p>Preview not available for this file type.</p>
    <?php endif; ?>
</div>

<hr>

<!-- Action Buttons -->
<a href="<?php echo $filePath; ?>" download class="btn btn-success">Download</a>
<button onclick="renameFile()" class="btn btn-warning">Rename</button>
<a href="delete.php?file=<?php echo urlencode($fileName); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>

<!-- Rename Form (Hidden) -->
<form id="renameForm" method="POST" style="display: none;">
    <input type="text" name="new_name" id="newNameInput" required>
    <button type="submit" name="rename" class="btn btn-primary">Confirm</button>
</form>

<script>
function renameFile() {
    let newName = prompt("Enter new file name:", "<?php echo pathinfo($fileName, PATHINFO_FILENAME); ?>");
    if (newName) {
        document.getElementById('newNameInput').value = newName + ".<?php echo $fileExtension; ?>";
        document.getElementById('renameForm').submit();
    }
}
</script>

</body>
</html>
