<?php 
    session_start();
    include('connect.php');

    // Get the logged-in user ID
    $user_id = $_SESSION['id'];

    // Fetch recent files query
    $recentFilesQuery = mysqli_query($con, "
    SELECT file_name, file_type, file_size, uploaded_at 
FROM uploads 
WHERE user_id = '$user_id' 
ORDER BY uploaded_at DESC 
LIMIT 5

    ");

    // Fetch file counts from uploads table based on user_id
    $countQuery = mysqli_query($con, "
        SELECT file_type, COUNT(*) AS total 
        FROM uploads 
        WHERE user_id = '$user_id' 
        GROUP BY file_type
    ");

    // Initialize counts
    $imageCount = 0;
    $videoCount = 0;
    $folderCount = 0;

    // Process query results
    while ($row = mysqli_fetch_assoc($countQuery)) {
        if ($row['file_type'] == 'image') {
            $imageCount = $row['total'];
        } elseif ($row['file_type'] == 'video') {
            $videoCount = $row['total'];
        } elseif ($row['file_type'] == 'folder') {
            $folderCount = $row['total'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
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


        .card {
            margin-top: 20px;
            position: relative;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .add-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-button:hover {
            background-color: #0056b3;
        }

        .card-logo {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #fff;
        }

        .card-logo.img {
            color: #FF5733;
        }

        .card-logo.video {
            color: #33C1FF;
        }

        .card-logo.doc {
            color: #28A745;
        }

        .table-responsive {
            overflow-x: auto;
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

            .table {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar.minimized {
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                position: absolute;
                top: 10px;
                left: 10px;
            }
        }
    </style>
</head>
<body>
<div class="sidebar" id="sidebar">
    <h4>File Manager</h4>
    <a href="dashboard.php" class="active"><i class="bi bi-house"></i> <span class="link-text">Dashboard</span></a>
    <a href="upload.php"><i class="bi bi-upload"></i> <span class="link-text">Upload Files</span></a>
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
        <h2>Dashboard</h2>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"> </i> Profile
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item"><?php echo $abc['email']?></a></li>
                <?php } ?>
                <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <!-- Card for Images -->
        <div class="col-md-4">
            <div class="card text-center" onclick="location.href='managefiles.php';" style="cursor: pointer;">
                <div class="card-body">
                    <i class="bi bi-image card-logo img"></i>
                    <h5 class="card-title">Images</h5>
                    <p class="card-text fs-1"><?php echo $imageCount; ?></p>
                    <button class="add-button" onclick="event.stopPropagation(); location.href='upload.php';">+</button>
                </div>
            </div>
        </div>
    
        <!-- Card for Videos -->
        <div class="col-md-4">
            <div class="card text-center" onclick="location.href='managefiles.php';" style="cursor: pointer;">
                <div class="card-body">
                    <i class="bi bi-camera-video card-logo video"></i>
                    <h5 class="card-title">Videos</h5>
                    <p class="card-text fs-1"><?php echo $videoCount; ?></p>
                    <button class="add-button" onclick="event.stopPropagation(); location.href='upload.php';">+</button>
                </div>
            </div>
        </div>
    
        <!-- Card for Documents -->
        <div class="col-md-4">
            <div class="card text-center" onclick="location.href='managefiles.php';" style="cursor: pointer;">
                <div class="card-body">
                    <i class="bi bi-file-earmark-text card-logo doc"></i>
                    <h5 class="card-title">Documents</h5>
                    <p class="card-text fs-1"><?php echo $folderCount; ?></p>
                    <button class="add-button" onclick="event.stopPropagation(); location.href='upload.php';">+</button>
                </div>
            </div>
        </div>
    </div>  
    <hr>
<h3>Recent Uploads</h3>
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
            <th>SR.No</th>
            <th>File Name</th>
            <th>File Type</th>
            <th>Uploaded At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $count = 1;
    while ($row = mysqli_fetch_assoc($recentFilesQuery)) {
        $filePath = "uploads/" . urlencode($row['file_name']);
        $fileSizeMB = number_format($row['file_size'] / 1048576, 2) . ' MB'; // Convert bytes to MB
        ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo htmlspecialchars($row['file_name']) . " ($fileSizeMB)"; ?></td>
            <td><?php echo htmlspecialchars($row['file_type']); ?></td>
            <td><?php echo $row['uploaded_at']; ?></td>
            <td>
                <!-- Download Button -->
                <a href="<?php echo $filePath; ?>" download class="btn btn-info">Preview</a>

                <!-- Rename Button -->
                <button class="btn btn-default rename-btn" data-filename="<?php echo htmlspecialchars($row['file_name']); ?>">Rename</button>
            </td>
        </tr>
    <?php } ?>
</tbody>
</table>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('minimized');
        content.classList.toggle('minimized');
        toggleBtn.innerHTML = sidebar.classList.contains('minimized') ? '&#x25BA;' : '&#x25C0;';
    });
</script>
<script>
document.querySelectorAll('.rename-btn').forEach(button => {
    button.addEventListener('click', function() {
        let oldName = this.getAttribute('data-filename');
        let newName = prompt("Enter the new file name:", oldName);

        if (newName && newName.trim() !== "" && newName !== oldName) {
            let formData = new FormData();
            formData.append("old_name", oldName);
            formData.append("new_name", newName);

            fetch("rename.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === "success") {
                    location.reload(); // Refresh page on success
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });
});
</script>

</body>
</html>
