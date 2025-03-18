<?php
session_start();
include('connect.php');

if (!isset($_SESSION['id'])) {
    die("Unauthorized access!");
}

$user_id = $_SESSION['id'];

// Fetch shared files
$query = mysqli_query($con, "SELECT sf.id, sf.file_id, sf.sender_id, 
                            sf.shared_at,  
                            u.name AS sender_name, u.photo AS sender_photo, 
                            f.file_name, f.file_path
                            FROM shared_files sf
                            INNER JOIN register u ON sf.sender_id = u.id
                            INNER JOIN uploads f ON sf.file_id = f.id
                            WHERE sf.recipient_id = '$user_id' 
                            ORDER BY sf.shared_at DESC");

$shared_files = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Files</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f7f8fa; }
        .file-card {
            transition: transform 0.2s ease-in-out;
        }
        .file-card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-4">

    <div class="w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">📂 Shared Files</h2>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="search" placeholder="Search files..." class="w-full p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block">
            <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="p-3 text-left">Sender</th>
                        <th class="p-3 text-left">File Name</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="fileList">
                    <?php if (empty($shared_files)): ?>
                        <tr><td colspan="4" class="text-center p-4">No shared files found</td></tr>
                    <?php else: ?>
                        <?php foreach ($shared_files as $file): ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="p-3 flex items-center">
                                    <img src="profile_img/<?php echo $file['sender_photo'] ?: 'default.png'; ?>" class="w-10 h-10 rounded-full mr-3">
                                    <span><?php echo htmlspecialchars($file['sender_name']); ?></span>
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($file['file_name']); ?></td>
                                <td class="p-3"><?php echo date("d M, Y", strtotime($file['shared_at'])); ?></td>
                                <td class="p-3 text-center">
                                    <a href="<?php echo htmlspecialchars($file['file_path']); ?>" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="block md:hidden w-full">
            <?php if (empty($shared_files)): ?>
                <p class="text-center text-gray-500">No shared files found</p>
            <?php else: ?>
                <div id="fileListMobile">
                    <?php foreach ($shared_files as $file): ?>
                        <div class="file-card bg-white p-4 mb-3 rounded-lg shadow-lg">
                            <div class="flex items-center mb-2">
                                <img src="profile_img/<?php echo $file['sender_photo'] ?: 'default.png'; ?>" class="w-12 h-12 rounded-full mr-3">
                                <div>
                                    <p class="text-lg font-semibold"><?php echo htmlspecialchars($file['sender_name']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo date("d M, Y", strtotime($file['shared_at'])); ?></p>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-3"><?php echo htmlspecialchars($file['file_name']); ?></p>
                            <a href="<?php echo htmlspecialchars($file['file_path']); ?>" class="block bg-blue-500 text-white py-2 rounded-lg text-center shadow-md hover:bg-blue-600 transition">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="text-blue-500 hover:underline"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>

    <script>
        document.getElementById("search").addEventListener("keyup", function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll("#fileList tr");
            let cards = document.querySelectorAll("#fileListMobile .file-card");

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? "" : "none";
            });

            cards.forEach(card => {
                let text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchValue) ? "" : "none";
            });
        });
    </script>

</body>
</html>
