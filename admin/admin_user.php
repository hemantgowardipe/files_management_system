<?php
session_start();
include('connect.php');

// Fetch all users from the database
$usersQuery = mysqli_query($con, "SELECT * FROM register");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
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
        .table-responsive {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .search-box {
            margin-bottom: 20px;
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
                padding: 15px;
            }
            .sidebar a {
                display: inline-block;
                padding: 10px 15px;
            }
            .table-responsive {
                overflow-x: auto;
                padding: 20px;
                width: 100%;
            }
            .table {
                font-size: 1rem;
            }
        }
    </style>
    <script>
        $(document).ready(function () {
            $("#searchUser").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".table tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_user.php">User Management</a>
        <a href="admin_logout.php">Logout</a>
    </div>
    
    <div class="content">
        <div class="container">
            <h2>User Management</h2>
            <div class="search-box">
                <input type="text" id="searchUser" class="form-control" placeholder="Search users...">
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($usersQuery)): ?>
                        <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                                <span class="badge bg-<?php echo $user['status'] === 'Active' ? 'success' : 'secondary'; ?>">
                                    <?php echo $user['status']; ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm toggle-status"
                                    data-id="<?php echo $user['id']; ?>"
                                    data-status="<?php echo $user['status']; ?>">
                                    <?php echo $user['status'] === 'Active' ? 'Deactivate' : 'Activate'; ?>
                                </button>
                                <button class="btn btn-danger btn-sm delete-user" data-id="<?php echo $user['id']; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<!-- User actions script -->
<script>
        $(document).ready(function () {
            $("#searchUser").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".table tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Toggle User Status (Activate / Deactivate)
            $(".toggle-status").click(function () {
                var userId = $(this).data("id");
                var newStatus = $(this).data("status") === "Active" ? "Inactive" : "Active";

                $.post("update_user.php", { id: userId, status: newStatus }, function (response) {
                    if (response === "success") {
                        location.reload();
                    } else {
                        alert("Error updating user status.");
                    }
                });
            });

            // Delete User
            $(".delete-user").click(function () {
                if (!confirm("Are you sure you want to delete this user?")) return;
                var userId = $(this).data("id");

                $.post("delete_user.php", { id: userId }, function (response) {
                    if (response === "success") {
                        alert("User deleted successfully!");
                        location.reload();
                    } else {
                        alert("Error deleting user.");
                    }
                });
            });
        });
</script>