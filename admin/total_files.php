<?php
session_start();
include('connect.php');

// Fetch all files along with user details
$query = "
    SELECT uploads.id AS file_id, uploads.file_name, uploads.file_size, uploads.file_type, uploads.file_path, uploads.uploaded_at, 
           register.id AS user_id, register.name, register.email
    FROM uploads
    JOIN register ON uploads.user_id = register.id
    ORDER BY uploads.uploaded_at DESC";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            font-weight: bold;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s;
        }
        .table thead {
            background: linear-gradient(135deg, #343a40, #495057);
            color: white;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }
            .profile-img {
                width: 30px;
                height: 30px;
            }
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Total Files</h2>
        <button class="btn btn-secondary mb-3" onclick="window.location.href='admin_dashboard.php'">Back</button>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                    <th>User ID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>File ID</th>
                        <th>File Name</th>
                        <th>File Size (MB)</th>
                        <th>File Type</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo $row['file_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                        <td><?php echo number_format($row['file_size'], 2); ?></td>
                        <td>
                            <?php 
                                $fileExt = strtolower(pathinfo($row['file_name'], PATHINFO_EXTENSION));
                                $fileIcons = [
                                    'pdf' => '📄 PDF',
                                    'docx' => '📝 DOCX',
                                    'xlsx' => '📊 XLSX',
                                    'png' => '🖼️ PNG',
                                    'jpg' => '🖼️ JPG',
                                    'jpeg' => '🖼️ JPEG',
                                    'mp4' => '🎥 MP4',
                                    'mp3' => '🎵 MP3',
                                    'zip' => '📦 ZIP',
                                    'txt' => '📜 TXT'
                                ];
                                echo isset($fileIcons[$fileExt]) ? $fileIcons[$fileExt] : '📁 ' . strtoupper($fileExt);
                            ?>
                        </td>
                        <td><?php echo $row['uploaded_at']; ?></td>

                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
