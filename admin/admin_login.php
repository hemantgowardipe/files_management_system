<?php
    session_start();
    include('connect.php');

   if(isset($_POST['login']))
   {
       $user = $_POST['user'];
       $pass = $_POST['pass'];

       if($user=='rajugowardipe0@gmail.com' && $pass='hemant@2005')
        {
            $_SESSION['aname'] = $user;
            header('location:admin_dashboard.php');
        }
        else
        {
            echo "<script>
                alert('Invalid Entry');
            </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            position: relative;
        }

        .form-group .eye-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
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

<div class="login-container">
    <h3 class="text-center mb-4">Admin Login</h3>
    <form method="post">
        <!-- Email Input -->
        <div class="form-group mb-3">
            <label for="email">Email address</label>
            <input type="email" name="user" class="form-control" id="email" placeholder="Enter your email" required>
        </div>

        <!-- Password Input with Eye Icon -->
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" name="pass" class="form-control" id="password" placeholder="Enter your password" required>
                <span class="input-group-text eye-icon" id="eyeIcon">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
        </div>

        <!-- Login Button -->
        <button type="submit" name="login" class="btn btn-primary mb-3">Login</button>

        <!-- Registration Note -->
        <div class="note">
            <p>Don't have an account? <a href="register.php" target="_blank">Register here</a></p>
            <p>User Login<a href="../login.php"> Login</a></p>
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
