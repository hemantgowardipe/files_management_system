<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

$user_id = $_SESSION['id'];

// Fetch deleted files
$query = mysqli_query($con, "SELECT *, DATEDIFF(NOW(), deleted_at) AS days_since_deleted FROM recently_deleted WHERE user_id = '$user_id' ORDER BY deleted_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recently Deleted Files</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Scrollbar for better mobile experience */
        .scroll-container {
            overflow-x: auto;
            white-space: nowrap;
        }

        /* Premium Table Styling */
        .custom-table {
            border-radius: 10px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .custom-table thead {
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
        }

        .custom-table tbody tr {
            transition: background 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .table thead {
                display: none; /* Hide headers for small screens */
            }
            .table tr {
                display: block;
                margin-bottom: 10px;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 10px;
                background: white;
            }
            .table td {
                display: block;
                text-align: left;
                font-size: 14px;
            }
            .table td:before {
                content: attr(data-label);
                font-weight: bold;
                color: #007bff;
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-dark">
    <!-- Modern Back Button -->
    <div class="fixed top-4 left-4">
        <a href="dashboard.php" class="text-xl text-gray-700 hover:text-gray-900 flex items-center">
            <span class="text-2xl">&larr;</span> <!-- Left Arrow Icon -->
            <span class="ml-2 text-lg font-semibold">Back</span>
        </a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center text-3xl font-bold text-gray-800">Recently Deleted Files</h2>

        <div class="scroll-container mt-4">
            <table class="table table-hover custom-table w-100">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Deleted At</th>
                        <th>Days Left</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query) > 0) { ?>
                        <?php while ($file = mysqli_fetch_assoc($query)) { 
                            $days_left = 30 - $file['days_since_deleted'];
                            $badge_class = ($days_left > 15) ? "bg-success text-white" : (($days_left > 5) ? "bg-warning text-dark" : "bg-danger text-white");
                        ?>
                            <tr>
                                <td data-label="File Name"><?php echo htmlspecialchars($file['file_name']); ?></td>
                                <td data-label="Deleted At"><?php echo $file['deleted_at']; ?></td>
                                <td data-label="Days Left">
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo $days_left . " days"; ?>
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <a href="restore.php?file_id=<?php echo $file['id']; ?>" class="btn btn-outline-success btn-sm">Restore</a>
                                    <a href="delete_permanent.php?file_id=<?php echo $file['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this file?');">Delete Permanently</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center text-gray-600 py-4">No recently deleted files found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
