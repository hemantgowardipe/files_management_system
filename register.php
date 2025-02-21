<?php 
    include('connect.php');
    if(isset($_POST['reg'])){
        $date = date('Y-m-d');
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $photo = $_FILES['photo']['name'];

        mysqli_query($con, "INSERT INTO register(date,name,mobile,email,photo,pass) VALUES('$date' , '$name' , '$mobile' , '$email' , '$photo' , '$pass')");

        $dir = 'profile_img/';
        $photo = $_FILES['photo']['name'];
        $size = $_FILES['photo']['size'];
        $tmp_photo = $_FILES['photo']['tmp_name'];
        $error = $_FILES['photo']['error'];

        $ext = explode('.',$photo);
        $actual = strtolower(end($ext));
        $allowed = array('jpg','png','jpeg');

        if(in_array($actual,$allowed))
        {
            if($error ===0)
            {
                if($size < 500000000)
                {
                    move_uploaded_file($tmp_photo,$dir.$photo);
                }
                else{
                    echo "Limit is 50 Mb";
                }
            }
            else{
                echo "Network Error";
            }
        }
        else{
            echo "Wrong file type";
        }

        echo"<script>
            alert('Registration Successful...');
            window.location.href='login.php';
        </script>";

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            padding: 15px;
        }

        .form-group .eye-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .btn-google {
            background-color: #db4437;
            color: white;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .btn-google i {
            margin-right: 10px;
        }

        .note {
            margin-top: 15px;
            font-size: 0.9rem;
            text-align: center;
        }

        .note a {
            color: #007bff;
            text-decoration: none;
        }

        .note a:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h3 class="text-center mb-4">Register</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Username Input -->
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="name" class="form-control" id="username" placeholder="Enter your username" required>
        </div>

        <!-- Mobile Number Input -->
        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter your mobile number" required>
        </div>

        <!-- Email Input -->
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>

        <!-- Profile Image Input -->
        <div class="form-group">
            <label for="profile_image">Profile Image</label>
            <input type="file" class="form-control" id="profile_image" name="photo" accept="image/jpg , image/jpeg , image/png" placeholder="Select your profile image" required>
        </div>

        <!-- Password Input with Eye Icon -->
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" name="pass" class="form-control" id="password" placeholder="Enter your password" required>
                <span class="input-group-text eye-icon" id="eyeIcon">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
        </div>

        <!-- Register Button -->
        <button type="submit" name="reg" class="btn btn-primary mb-3">Register</button>

        <!-- Registration Note -->
        <div class="note">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    eyeIcon.addEventListener('click', () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.innerHTML = '<i class="bi bi-eye"></i>';
        } else {
            passwordField.type = "password";
            eyeIcon.innerHTML = '<i class="bi bi-eye-slash"></i>';
        }
    });
</script>
</body>
</html>
