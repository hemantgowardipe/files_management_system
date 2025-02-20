<?php
session_start();
include('connect.php');

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']); // Sanitize input
    $user_id = $_SESSION['id']; // Ensure user can only share their own files

    // Fetch file details
    $query = mysqli_query($con, "SELECT * FROM uploads WHERE id = '$file_id' AND user_id = '$user_id'");
    $file = mysqli_fetch_assoc($query);

    if ($file) {
        $file_name = $file['file_name'];
        $shareable_link = "http://localhost/file_system/download.php?file_id=" . $file_id; // Adjust for your server

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Share File</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
            <script>
                function copyLink() {
                    var copyText = document.getElementById("shareLink");
                    copyText.select();
                    document.execCommand("copy");
                    alert("Link copied to clipboard!");
                }
            </script>
            <style>
                .share-buttons a {
                    margin: 5px;
                    text-decoration: none;
                }
            </style>
        </head>
        <body class="bg-light text-dark">
            <div class="container mt-5 text-center">
                <h2>Share File: <?php echo htmlspecialchars($file_name); ?></h2>
                <input type="text" id="shareLink" class="form-control my-3 text-center" value="<?php echo $shareable_link; ?>" readonly>
                <button class="btn btn-primary" onclick="copyLink()"><i class="bi bi-clipboard"></i> Copy Link</button>
                
                <hr>
                <h4>Share via:</h4>
                <div class="share-buttons">
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('Check out this file: ' . $shareable_link); ?>" target="_blank" class="btn btn-success">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                    <!-- Gmail -->
                    <a href="mailto:?subject=Sharing a File&body=Here is the file link: <?php echo urlencode($shareable_link); ?>" class="btn btn-danger">
                        <i class="bi bi-envelope"></i> Gmail
                    </a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($shareable_link); ?>" target="_blank" class="btn btn-primary">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    <!-- Instagram (Direct Message Sharing) -->
                    <a href="https://www.instagram.com/direct/new/" target="_blank" class="btn btn-warning text-white">
                        <i class="bi bi-instagram"></i> Instagram
                    </a>
                </div>

                <a href="managefiles.php" class="btn btn-secondary mt-3">Back</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        die("File not found or unauthorized access!");
    }
} else {
    die("Invalid request!");
}
?>
