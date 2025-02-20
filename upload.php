<?php
session_start();
include('connect.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    die("Unauthorized access");
}

$user_id = $_SESSION['id']; // Get the logged-in user ID

// Function to handle file upload
function uploadFile($fileInputName, $fileType, $dbCon, $userId) {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES[$fileInputName]['name'];
        $fileTmpName = $_FILES[$fileInputName]['tmp_name'];
        $fileSize = $_FILES[$fileInputName]['size'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $uploadDir = 'uploads/'; // Relative directory to store files
        
        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFileName = time() . "_" . basename($fileName);
        $uploadPath = $uploadDir . $newFileName;
        
        // Move file to upload directory
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            $query = "INSERT INTO uploads (user_id, file_name, file_path, file_type, file_size, upload_time) 
                      VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($dbCon, $query);
            mysqli_stmt_bind_param($stmt, 'isssi', $userId, $fileName, $uploadPath, $fileType, $fileSize);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>File uploaded successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Database error: " . mysqli_error($dbCon) . "</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Failed to move uploaded file.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>No file selected or upload error.</div>";
    }
}


// Handling folder upload
if (isset($_POST['ufolder'])) {
    uploadFile('folder', 'folder', $con, $user_id);
}

// Handling video upload
if (isset($_POST['uvideo'])) {
    uploadFile('video', 'video', $con, $user_id);
}

// Handling image upload
if (isset($_POST['uimgage'])) {
    uploadFile('image', 'image', $con, $user_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files - File Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
}

.uploading {
    display: none;
    text-align: center;
    margin-top: 20px; /* Push it below the form */
    position: relative; /* Keep it in proper alignment */
    z-index: 1; /* Prevents it from going behind other elements */
}


.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    background-color: #343a40;
    color: white;
    padding-top: 20px;
    transition: width 0.3s ease-in-out;
}

.sidebar.minimized {
    width: 80px;
}

.sidebar h4 {
    text-align: center;
    transition: opacity 0.3s ease-in-out;
}

.sidebar.minimized h4 {
    opacity: 0;
}

.sidebar a {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 10px 20px;
    margin: 10px 0;
    border-radius: 4px;
    transition: background-color 0.3s, padding 0.3s;
}

.sidebar a i {
    margin-right: 10px;
    font-size: 1.2rem;
}

.sidebar.minimized a {
    justify-content: center;
    padding: 10px;
}

.sidebar.minimized a .link-text {
    display: none;
}

.sidebar a:hover {
    background-color: #495057;
}


.content {
    margin-left: 250px;
    padding: 20px;
    width: 100%;
    transition: margin-left 0.3s ease-in-out;
}

.content.minimized {
    margin-left: 80px;
}

.toggle-btn {
    position: absolute;
    top: 20px;
    right: -20px;
    background-color: #343a40;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
}

.toggle-btn:hover {
    transform: rotate(90deg);
}

.form-check-input:checked {
    background-color: #ffcc00;
    border-color: #ffcc00;
    box-shadow: 0 0 5px #ffcc00, 0 0 10px #ffcc00;
    transition: all 0.3s ease-in-out;
}

.form-check-input {
    transition: all 0.3s ease-in-out;
}

.profile-section {
    position: absolute;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-dropdown {
    margin-right: 10px;
}

.dropdown-menu {
    min-width: 200px;
}

.dropdown-item.dark-mode-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.upload-options {
    margin-top: 20px;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.upload-options h4 {
    margin-bottom: 15px;
}

.upload-button {
    padding: 10px 20px;
    background-color: #0d6efd;
    color: white;
    border: none;
    border-radius: 5px;
    margin: 5px;
    cursor: pointer;
}

.upload-button:hover {
    background-color: #0056b3;
}

.file-input {
    display: none;
}

.uploading {
            display: none;
            text-align: center;
            margin-top: 10px;
        }

        .dot-animation span {
            animation: blink 1.5s infinite;
        }

        .dot-animation span:nth-child(2) {
            animation-delay: 0.3s;
        }

        .dot-animation span:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes blink {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .sidebar.minimized {
                width: 60px;
            }
            .content {
                margin-left: 200px;
            }
            .content.minimized {
                margin-left: 60px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h4>File Manager</h4>
    <a href="index.php"><i class="bi bi-house"></i> <span class="link-text">Dashboard</span></a>
    <a href="upload.php" class="active"><i class="bi bi-upload"></i> <span class="link-text">Upload Files</span></a>
    <a href="managefiles.php"><i class="bi bi-folder"></i> <span class="link-text">Manage Files</span></a>
    <a href="login.php"><i class="bi bi-box-arrow-in-right"></i> <span class="link-text">Login</span></a>
    <button class="toggle-btn" id="toggle-btn">&#x25C0;</button>
</div>

<div class="content" id="content">
    <!-- Calling the email from database -->
    <?php 
        $sql = mysqli_query($con,"SELECT * FROM register WHERE id = '".$_SESSION['id']."' ");
        while($abc = mysqli_fetch_array($sql)){
    ?>
    <div class="d-flex justify-content-between align-items-center">
        <h2>Upload Files</h2>
        <div class="dropdown profile-section">
            <div class="profile-dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> Profile
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><span class="dropdown-item"><?php echo $abc['email']?></span></li>
                    <?php } ?>
                    <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <hr>

    <div class="upload-options">
        <h4>Select Upload Type</h4>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Input for Folder -->
             <label for="folder"><b>Upload Folder :</b></label>
             <input type="file" name="folder" required>
             <button type="submit" name="ufolder" class="upload-button btn btn-sm"><i class="bi bi-file-earmark"></i> Upload Folder</button>
        </form>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Input for Video -->
             <label for="folder"><b>Upload Video :</b></label>
             <input type="file" name="video" required>
             <button type="submit" name="uvideo" class="upload-button btn btn-sm"><i class="bi bi-file-earmark-play"></i> Upload Video</button>
        </form>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Input for Folder -->
             <label for="folder"><b>Upload Image :</b></label>
             <input type="file" name="image" required>
             <button type="submit" name="uimgage" class="upload-button btn btn-sm"><i class="bi bi-file-earmark-image"></i> Upload Image</button>
        </form>
    <div class="uploading" id="uploading">
        <p>Uploading<span class="dot-animation"><span>.</span><span>.</span><span>.</span></span></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function startUploading() {
        document.getElementById('uploading').style.display = 'block';
    }
    
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('minimized');
        content.classList.toggle('minimized');
        toggleBtn.innerHTML = sidebar.classList.contains('minimized') ? '&#x25BA;' : '&#x25C0;';
    });
</script>

</body>
</html>
