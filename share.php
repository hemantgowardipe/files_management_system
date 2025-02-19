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
            <script>
                function copyLink() {
                    var copyText = document.getElementById("shareLink");
                    copyText.select();
                    document.execCommand("copy");
                    alert("Link copied to clipboard!");
                }
            </script>
        </head>
        <body class="bg-light text-dark">
            <div class="container mt-5">
                <h2>Share File: <?php echo $file_name; ?></h2>
                <input type="text" id="shareLink" class="form-control" value="<?php echo $shareable_link; ?>" readonly>
                <button class="btn btn-primary mt-2" onclick="copyLink()">Copy Link</button>
                <a href="managefiles.php" class="btn btn-secondary mt-2">Back</a>
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
