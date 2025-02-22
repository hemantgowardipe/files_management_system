<?php
session_start();
include('connect.php');

// Fetch statistics from the database
$totalUsersQuery = mysqli_query($con, "SELECT COUNT(*) AS total_users FROM register");
$totalUsers = mysqli_fetch_assoc($totalUsersQuery)['total_users'];

$totalFilesQuery = mysqli_query($con, "SELECT COUNT(*) AS total_files FROM uploads");
$totalFiles = mysqli_fetch_assoc($totalFilesQuery)['total_files'];

$totalStorageQuery = mysqli_query($con, "SELECT SUM(file_size) AS total_storage FROM uploads");
$totalStorage = mysqli_fetch_assoc($totalStorageQuery)['total_storage'] / (1024 * 1024); // Convert bytes to MB

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - File Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1s ease-out forwards;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            color: white;
            position: fixed;
            padding-top: 20px;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar a {
            color: white;
            padding: 12px;
            display: block;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        .content {
            margin-left: 260px;
            padding: 30px;
        }
        .stats-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
        }
        .stat-box {
            position: relative;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            width: 250px;
            height: 250px;
            border-radius: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            margin: 15px;
            font-size: 20px;
            font-weight: bold;
            overflow: hidden;
            opacity: 0;
            transform: scale(0.9);
            animation: fadeInScale 1s ease-out forwards;
        }
        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        .stat-box span {
            font-size: 40px;
            font-weight: bold;
            margin-top: 10px;
        }
        .floating-icon {
            position: absolute;
            width: 60px;
            opacity: 0.3;
            animation: floatAnimation 4s infinite ease-in-out;
        }
        @keyframes floatAnimation {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        .table-responsive {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: center;
        }
        .table thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .table tbody tr:hover {
            background: rgba(103, 119, 239, 0.1);
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                text-align: center;
                padding-bottom: 10px;
            }
            .content {
                margin-left: 0;
            }
            .sidebar a {
                display: inline-block;
                padding: 10px 15px;
            }
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_user.php">File Management</a>
        <a href="admin_logout.php">Logout</a>
    </div>
    
    <div class="content">
        <div id="dashboard" class="container">
            <h2 style="text-align: center; font-style: italic;">Dashboard</h2>
            <div class="stats-container">
                <div class="stat-box" style="animation-delay: 0.1s; cursor: pointer;" onclick="window.location.href='total_files.php'">
                    <img src="https://cdn-icons-png.flaticon.com/512/2991/2991128.png" class="floating-icon" alt="File Icon">
                    <p>Total Files</p>
                    <span id="totalFiles"><?php echo $totalFiles; ?></span>
                </div>
                <div class="stat-box" style="background: linear-gradient(135deg, #ff758c, #ff7eb3); animation-delay: 0.2s; cursor: pointer;" onclick="window.location.href='total_users.php'">
                    <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" class="floating-icon" alt="User Icon">
                    <p>Active Users</p>
                    <span id="activeUsers"><?php echo $totalUsers; ?></span>
                </div>
                <div class="stat-box" style="background: linear-gradient(135deg, #43cea2, #185a9d); animation-delay: 0.3s;">
                    <img src="https://cdn-icons-png.flaticon.com/512/1554/1554406.png" class="floating-icon" alt="Storage Icon">
                    <p>Storage Used</p>
                    <span id="storageUsed"><?php echo round($totalStorage, 2); ?> MB</span>
                </div>
            </div>
            <h3 class="mt-4">Recent File Activities</h3>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>File ID</th>
                                <th>User ID</th>
                                <th>File Name</th>
                                <th>File Type</th>
                                <th>Size</th>
                                <th>Upload Time</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php
            $filesQuery = mysqli_query($con, "SELECT * FROM uploads ORDER BY upload_time DESC LIMIT 5");
            while ($file = mysqli_fetch_assoc($filesQuery)) {
                echo "<tr>
                        <td>{$file['id']}</td>
                        <td>{$file['user_id']}</td>
                        <td>{$file['file_name']}</td>
                        <td>{$file['file_type']}</td>
                        <td>" . round($file['file_size'] / 1024, 2) . " KB</td>
                        <td>{$file['upload_time']}</td>
                      </tr>";
            }
            ?>
        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
