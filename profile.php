<?php 
    session_start();
    include('connect.php');

    // Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $id = $_SESSION['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $updateQuery = "UPDATE register SET name='$name', email='$email', mobile='$mobile', pass='$password' WHERE id='$id'";

    // Handle profile image upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $target = "profile_img/" . basename($photo);

        // Check if the file was uploaded
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $updateQuery = "UPDATE register SET name='$name', email='$email', mobile='$mobile', pass='$password', photo='$photo' WHERE id='$id'";
        } else {
            echo "<script>alert('Error uploading image!');</script>";
        }
    }

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Include CropperJS CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

<!-- Include CropperJS JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    
    <style>
        body {
            background: #f4f6f9;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }
        /* Styling */
        .modal-fullscreen { 
            position: fixed; 
            top: 0; 
            left: 0;
            width: 100%; 
            height: 100%; 
            background: rgba(0, 0, 0, 0.6); 
            display: none; 
            align-items: center; 
            justify-content: center; 
        }
        .modal-content { 
            background: #fff; 
            padding: 20px; 
            border-radius: 10px; 
            width: 90%; 
            max-width: 500px; 
        }
        .crop-container {
            max-width: 100%;
            height: auto;
        }
        #preview {
            max-width: 100%;
            height: auto;
        }
        /*  */
        .profile-container {
            max-width: 450px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: 0.3s;
            position: relative;
        }
        .profile-container:hover {
            transform: translateY(-5px);
        }
        .edit-btn {
            position: absolute;
            top: 0px;
            right: 0px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color:black;
            transition: 0.3s;
        }
        .edit-btn i {
            font-size: 22px;
        }
        .edit-btn:hover {
            color: #0056b3;
        }
        .edit-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .edit-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
        .profile-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
        }
        .info-section {
            font-size: 16px;
            color: #555;
            padding: 12px 0;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .info-section:last-child {
            border-bottom: none;
        }
        .password-field {
            -webkit-text-security: disc;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .info-label {
            font-weight: bold;
            color: #333;
        }
        .profile-card {
            background: linear-gradient(135deg, #007bff, #0056b3);
            padding: 20px;
            border-radius: 15px 15px 0 0;
            color: white;
        }
        .profile-name {
            font-size: 22px;
            font-weight: bold;
        }
        .extra-info {
            background: #ffffff;
            padding: 20px;
            margin-top: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .modal-fullscreen { 
            position: fixed; 
            top: 0; 
            left: 0;
            width: 100%; 
            height: 100%; 
            background: rgba(0, 0, 0, 0.6); 
            display: none; 
            align-items: center; 
            justify-content: center; 
        }
        .modal-content { 
            background: #fff; 
            padding: 30px; 
            border-radius: 10px; 
            width: 90%; 
            max-width: 500px; 
        }
        .storage-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }
        .progress {
            height: 12px;
            border-radius: 6px;
            overflow: hidden;
            background: #e9ecef;
        }
        .progress-bar {
            background: linear-gradient(90deg, #ff8c00, #ff3d00);
        }
        @media (max-width: 768px) {
            .profile-container {
                max-width: 90%;
                padding: 20px;
                margin: 30px auto;
            }
            .profile-photo {
                width: 100px;
                height: 100px;
            }
            .info-section {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <?php 
        $sql = mysqli_query($con,"SELECT * FROM register WHERE id = '".$_SESSION['id']."' ");
        while($abc = mysqli_fetch_array($sql)){
    ?>
        <div class="profile-container">
            <button class="edit-btn" id="openEditModal"><i class="bi bi-pencil-fill bi-sm"></i></button>
            <div class="profile-card">
                <img src="<?php echo "profile_img/" . $abc['photo']?>" alt="Profile Photo" class="profile-photo">
                <h3><?php echo $abc['name']?></h3>
            </div>
            <p class="info-section"><strong>Email:</strong> <?php echo $abc['email']?></p>
            <p class="info-section"><strong>Phone: +91</strong> <?php echo $abc['mobile']?></p>
            <p class="info-section"><strong>Password:</strong> <?php echo $abc['pass']?></p>
        </div>
    <?php } ?>
</div>

<div class="container">
<div class="extra-info text-center mt-4 p-3 bg-white shadow-sm rounded">
    <p><strong>Total Documents Uploaded</strong></p>
    <h4 class="text-primary" id="fileCount">Loading...</h4>
    <div class="storage-section">
        <span><strong>Storage Usage</strong></span>
        <span class="text-muted">Loading...</span>
    </div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<br><br>
</div>


<!-- Edit Profile Modal -->
<div class="modal-fullscreen" id="editModal">
    <div class="modal-content">
        <h4 class="mb-3">Edit Profile</h4>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="update_profile" value="1">
            <div class="mb-2">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Phone</label>
                <input type="text" name="mobile" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Profile Image</label>
                <input type="file" name="photo" id="imageInput" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-danger" id="closeEditModal">Cancel</button>
        </form>
    </div>
</div>

<!-- Crop Image Modal -->
<div class="modal-fullscreen" id="cropModal">
    <div class="modal-content">
        <h4>Crop Image</h4>
        <div class="crop-container">
            <img id="cropImage" src="">
        </div>
        <button id="cropButton" class="btn btn-success mt-2">Crop</button>
        <button class="btn btn-danger mt-2" id="closeCropModal">Cancel</button>
    </div>
</div>


    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        
    </script>
    <!-- Total file count script -->
    <script>
    $(document).ready(function() {
        $("#openEditModal").click(function() {
            $("#editModal").fadeIn();
        });

        $("#closeEditModal").click(function() {
            $("#editModal").fadeOut();
        });

        function fetchFileCount() {
    $.ajax({
        url: 'get_file_count.php',
        type: 'GET',
        success: function(response) {
            let fileCount = parseInt(response);
            $("#fileCount").text(fileCount);

            // Assuming max 100 files as full storage for example
            let percentage = (fileCount / 100) * 100;
            $("#fileProgressBar").css("width", percentage + "%");
        }
    });
}
fetchFileCount();

    });
</script>
<!-- Storage script -->
 <script>
    function fetchStorageUsage() {
    $.ajax({
        url: 'get_total_storage.php',
        type: 'GET',
        success: function(response) {
            let totalStorageUsedMB = parseFloat(response); // Convert response to a number
            if (isNaN(totalStorageUsedMB)) totalStorageUsedMB = 0; // Handle NaN case

            let maxStorageMB = 10240; // 10GB = 10240MB
            let percentage = (totalStorageUsedMB / maxStorageMB) * 100;

            // Update storage usage text
            $(".storage-section span.text-muted").text(totalStorageUsedMB.toFixed(2) + "MB / 10GB");

            // Update progress bar width
            $(".progress-bar").css("width", percentage + "%").attr("aria-valuenow", percentage);
        }
    });
}

// Fetch storage usage on page load
fetchStorageUsage();

 </script>
 <!-- Cropping script -->
</body>
</html>
