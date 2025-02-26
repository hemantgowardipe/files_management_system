<?php 
    session_start();
    include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
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

        .profile-section {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-item.dark-mode-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        table th {
            background-color: #495057;
            color: white;
        }

        table td {
            background-color: #f8f9fa;
        }

        table tr:hover td {
            background-color: #e9ecef;
        }

        table .file-logo {
            font-size: 1.5rem;
        }

        /* Light mode styles */
        body.bg-light {
            background: #f9f9f9;
            color: #343a40;
        }

        /* Dark mode styles */
        body.bg-dark {
            background: linear-gradient(135deg, #2b2b2b, #1a1a1a);
            color: #e4e4e4;
        }

        table th {
            background-color: #3d3d3d;
        }

        table td {
            background-color: #2d2d2d;
            color: #d3d3d3;
        }

        /* Dropdown and Dark Mode */
        .dropdown-menu {
            background-color: #343a40;
            border: none;
            transition: background-color 0.3s ease;
        }

        .dropdown-menu .dropdown-item {
            color: #e4e4e4;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #495057;
            color: #ffffff;
        }

        .form-check-input {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .form-check-input:checked {
            background-color: #007bff;
            transform: scale(1.2);
        }

        /* Three-dot button (minimal, no bg, no border) */
        .three-dot-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
        }

        /* Remove focus border when clicked */
        .three-dot-btn:focus {
            outline: none;
            box-shadow: none;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border: none;
            min-width: 150px;
            z-index: auto;
        }

        /* Dropdown item hover effect */
        .dropdown-item {
            padding: 10px;
            font-size: 14px;
            transition: background 0.2s ease-in-out;
            z-index: auto;
        }

        .dropdown-item:hover {
            background: #f0f0f0;
        }

        /* Delete button in red */
        .text-danger {
            color: red !important;
        }


        /* Media Queries for Mobile and Tablet Views */
        @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .sidebar.minimized {
            width: 70px;
        }

        .content {
            margin-left: 200px;
        }

        .content.minimized {
            margin-left: 70px;
        }

        table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    table th, table td {
        padding: 10px;
        font-size: 0.9rem;
    }

    .toggle-btn {
        top: 15px;
        right: -15px;
    }
}

@media (max-width: 576px) {
    .sidebar {
        width: 150px;
    }

    .sidebar.minimized {
        width: 60px;
    }

    .content {
        margin-left: 150px;
    }

    .content.minimized {
        margin-left: 60px;
    }

    table th, table td {
        padding: 8px;
        font-size: 0.8rem;
    }

    .file-logo {
        font-size: 1rem;
    }

    .toggle-btn {
        top: 10px;
        right: -10px;
    }

    .profile-section {
        position: static;
        width: 100%;
        text-align: center;
    }

    .dropdown-menu {
        width: 100%;
        text-align: center;
    }
}
    </style>
</head>
<body class="bg-light text-dark">

<div class="sidebar" id="sidebar">
    <h4>File Manager</h4>
    <a href="dashboard.php" class="active"><i class="bi bi-house"></i> <span class="link-text">Dashboard</span></a>
    <a href="upload.php"><i class="bi bi-upload"></i> <span class="link-text">Upload Files</span></a>
    <a href="managefiles.php"><i class="bi bi-folder"></i> <span class="link-text">Manage Files</span></a>
    <button class="toggle-btn" id="toggle-btn">&#x25C0;</button>
</div>

<div class="content" id="content">
    <!-- Calling the email from database -->
    <?php 
        $sql = mysqli_query($con,"SELECT * FROM register WHERE id = '".$_SESSION['id']."' ");
        while($abc = mysqli_fetch_array($sql)){
    ?>
    <div class="d-flex justify-content-between align-items-center">
        <h2>Manage Files</h2>
        <div class="dropdown profile-section">
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
    <hr>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Sr. No</th>
            <th>File Type</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
    <?php 
    $user_id = $_SESSION['id'];

    // Fetch all uploaded files by the user
    $query = mysqli_query($con, "SELECT * FROM uploads WHERE user_id = '$user_id'");

    $srNo = 1;

    if(mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $fileId = $row['id'];
            $fileName = $row['file_name'];
            $fileType = $row['file_type'];
            $filePath = $row['file_path'];
            $fileSizeMB = number_format($row['file_size'] / 1048576,2) . 'MB'; 

            // Determine file type icon
            $iconClass = "bi-file-earmark"; 
            if (strpos($fileType, "image") !== false) {
                $iconClass = "bi-file-earmark-image";
            } elseif (strpos($fileType, "video") !== false) {
                $iconClass = "bi-file-earmark-play";
            } elseif (strpos($fileType, "pdf") !== false) {
                $iconClass = "bi-file-earmark-pdf";
            } elseif (strpos($fileType, "doc") !== false) {
                $iconClass = "bi-file-earmark-word";
            }
        ?>
    <tr id="file-row-<?php echo $fileId; ?>">
        <td><?php echo $srNo++; ?></td>
        <td><i class="bi <?php echo $iconClass; ?>"></i></td>
        <td>
            <span id="file-name-<?php echo $fileId; ?>">
                <?php echo htmlspecialchars($fileName) . "    ($fileSizeMB) "; ?>
            </span>
        </td>
        <td>
            <!-- Three-dot menu for actions -->
            <div class="dropdown">
                <button class="three-dot-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo $filePath; ?>" download>📥 Download</a></li>
                    <li><a class="dropdown-item text-danger delete-file" href="delete.php?file_id=<?php echo $fileId; ?>" onclick="return confirm('Are you sure you want to delete this file?');">🗑️ Delete</a></li>
                    <li><a class="dropdown-item" href="share.php?file_id=<?php echo $fileId; ?>">🔗 Share</a></li>
                    <li><button class="dropdown-item rename-btn" data-id="<?php echo $fileId; ?>" data-filename="<?php echo htmlspecialchars($fileName); ?>">✏️ Rename</button></li>
                </ul>
            </div>
        </td>
    </tr>
    <?php 
        } 
    } else {
        echo "<tr><td colspan='4' class='text-center'>No files uploaded yet.</td></tr>";
    }
    ?>
</tbody>

    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Slide bar toggle script -->
<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');
    const darkModeSwitch = document.getElementById('darkModeSwitch');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('minimized');
        content.classList.toggle('minimized');
    });

    darkModeSwitch.addEventListener('change', () => {
        document.body.classList.toggle('bg-dark');
        document.body.classList.toggle('text-dark');
        document.body.classList.toggle('bg-light');
    });
</script>
<!-- Rename Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".rename-btn").click(function() {
        let fileId = $(this).data("id");
        let oldName = $(this).data("filename");
        let newName = prompt("Enter new file name:", oldName);

        if (newName && newName !== oldName) {
            $.ajax({
                url: "rename.php",
                type: "POST",
                data: { file_id: fileId, new_name: newName },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#file-name-" + fileId).text(newName); // Update UI dynamically
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Error renaming file. Try again.");
                }
            });
        }
    });
});
</script>


</body>
</html>
