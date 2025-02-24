<?php
include('connect.php');

if (isset($_POST['reg'])) {
    $date = date('Y-m-d');
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']); // Store plain-text password

    $dir = 'profile_img/';
    $photoName = "default.png"; // Default profile image

    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $size = $_FILES['photo']['size'];
        $tmp_photo = $_FILES['photo']['tmp_name'];
        $error = $_FILES['photo']['error'];

        $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION)); // Get file extension
        $allowed = array('jpg', 'png', 'jpeg');

        if (in_array($ext, $allowed)) {
            if ($error === 0) {
                if ($size < 50000000) { // 50MB limit
                    $photoName = "profile_" . time() . "." . $ext; // Unique filename
                    move_uploaded_file($tmp_photo, $dir . $photoName);
                } else {
                    echo "<script>alert('File size exceeds 50MB!');</script>";
                    exit();
                }
            } else {
                echo "<script>alert('File upload error!');</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid file type! Only JPG, PNG, JPEG allowed.');</script>";
            exit();
        }
    }

    // Insert user data into the database
    $stmt = $con->prepare("INSERT INTO register (date, name, mobile, email, photo, pass) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $date, $name, $mobile, $email, $photoName, $pass);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Database Error: Registration Failed.');</script>";
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="card w-full max-w-sm bg-white shadow-xl p-8 rounded-lg">
    <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">Register</h2>
    
    <form action="" method="post" enctype="multipart/form-data" class="space-y-4">
        <!-- Username Input -->
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Username</span>
            </div>
            <input type="text" name="name" class="input input-bordered w-full" placeholder="Enter your username" required />
        </label>
        
        <!-- Mobile Number Input -->
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Mobile Number</span>
            </div>
            <input type="text" name="mobile" class="input input-bordered w-full" placeholder="Enter your mobile number" required />
        </label>
        
        <!-- Email Input -->
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Email Address</span>
            </div>
            <input type="email" name="email" class="input input-bordered w-full" placeholder="Enter your email" required />
        </label>
        
        <!-- Profile Image Input -->
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Profile Image</span>
            </div>
            <input type="file" class="file-input file-input-bordered w-full" name="photo" accept="image/jpg, image/jpeg, image/png" required />
        </label>
        
        <!-- Password Input -->
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Password</span>
            </div>
            <div class="relative">
                <input type="password" name="pass" class="input input-bordered w-full pr-10" id="password" placeholder="Enter your password" required />
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3" onclick="togglePassword()">
                    <svg id="eyeIcon" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm8 0c0 4-4 8-8 8s-8-4-8-8 4-8 8-8 8 4 8 8z" />
                    </svg>
                </button>
            </div>
        </label>
        
        <!-- Register Button -->
        <button type="submit" name="reg" class="btn btn-primary w-full">Register</button>
        
        <!-- Already have an account -->
        <p class="text-center text-sm text-gray-600">Already have an account? <a href="login.php" class="text-blue-500">Login here</a></p>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm8 0c0 4-4 8-8 8s-8-4-8-8 4-8 8-8 8 4 8 8z" />';
        } else {
            passwordField.type = "password";
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm8 0c0 4-4 8-8 8s-8-4-8-8 4-8 8-8 8 4 8 8z" />';
        }
    }
</script>
</body>
</html>
