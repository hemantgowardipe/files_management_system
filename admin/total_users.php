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
    <title>Total Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            text-align: center;
        }
        td {
            vertical-align: middle !important; /* Align content vertically */
            text-align: center; /* Align content horizontally */
        }


        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            align-content: center;
            display: block;
            margin: 0 auto; /* Center the image horizontally */
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
        <h2 class="mb-4 text-center">Total Users</h2>
        <button class="btn btn-secondary mb-3" onclick="window.location.href='admin_dashboard.php'">Back</button>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Password</th>
                        <th>Timestamp</th>
                        <th>Profile Photo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($usersQuery)): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['mobile']; ?></td>
                        <td>********</td> <!-- Mask password for security -->
                        <td><?php echo $user['date']; ?></td>
                        <td>
    <?php 
        $profilePath = "../profile_img/" . $user['photo'];
        if (!empty($user['photo']) && file_exists($profilePath)) {
            $profileImage = $profilePath;
        } else {
            $profileImage = 'https://via.placeholder.com/40'; // Default placeholder
        }
    ?>
    <img src="<?php echo $profileImage; ?>" alt="Profile" class="profile-img">
</td>

                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
