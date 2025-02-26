<?php
    session_start();
    include('connect.php');

   if(isset($_POST['login']))
   {
       $user = $_POST['user'];
       $pass = $_POST['pass'];

       $sql = mysqli_query($con,"SELECT * FROM `register` WHERE `email` = '$user' AND `pass` = '$pass' ");
       $row = mysqli_num_rows($sql);
       while($result = mysqli_fetch_assoc($sql))
       {
           // session used to fix the data 
          $_SESSION['id'] = $result['id'];
          $_SESSION['name'] = $result['name'];
       }
       if($row>0)
       {
           echo "<script>
               window.top.location.href='dashboard.php';
           </script>";
       }
       else
       {
           echo "<script>
               alert('Invalid Username or Password')
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="card w-full max-w-sm bg-white shadow-xl p-8 rounded-lg">
    <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">Login</h2>
    
    <form method="post" class="space-y-4">
        <!-- Email Input -->
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Email Address</span>
            </div>
            <input type="email" name="user" class="input input-bordered w-full" placeholder="Enter your email" required />
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

        <!-- Login Button -->
        <button type="submit" name="login" onsubmit="showSuccessMessage(event)" class="btn btn-primary w-full">Login</button>

        <!-- Success Message -->
        <div id="successMessage" class="hidden alert alert-success mt-4">Login Successful! Redirecting...</div>

        <!-- Registration Note -->
        <p class="text-center text-sm text-gray-600">Don't have an account? <a href="register.php" target="_blank" class="text-blue-500">Register here</a></p>
        <p class="text-center text-sm text-gray-600">Admin Login <a href="admin/admin_login.php" target="_blank" class="text-blue-500">Admin Panel</a></p>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }

    function showSuccessMessage(event) {
        event.preventDefault(); // Prevent actual form submission for demo
        const successMessage = document.getElementById("successMessage");
        successMessage.classList.remove("hidden");
        setTimeout(() => {
            window.location.href = "dashboard.php";
        }, 2000); // Redirect after 2 seconds
    }
</script>
</body>
</html>
