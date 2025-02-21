<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time File Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt"></script>
    <style>
        body {
            background: linear-gradient(135deg, #2b5876, #4e4376);
            color: white;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            overflow-x: hidden;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }
        .icon-animation {
            position: absolute;
            width: 50px;
            height: 50px;
            opacity: 0.3;
            animation: floatAnimation linear infinite;
        }
        .file-animation {
            position: absolute;
            width: 60px;
            opacity: 1;
            transition: all 0.7s ease-in-out;
        }
        .bin {
            position: absolute;
            bottom: 10%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 70px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        @keyframes floatAnimation {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-50px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 15px;
        }
        .hero {
            padding: 100px 20px;
            position: relative;
        }
        .tilt-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease-in-out;
        }
        .tilt-card:hover {
            transform: translateY(-10px) scale(1.05);
        }
        .modal-dialog {
            max-width: 400px;
        }
        .modal-content {
            background: #333;
            color: white;
            border-radius: 10px;
            padding: 20px;
        }
        @keyframes vibrate {
            0% { transform: translate(0, 0); }
            25% { transform: translate(-2px, 2px); }
            50% { transform: translate(2px, -2px); }
            75% { transform: translate(-2px, 2px); }
            100% { transform: translate(0, 0); }
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff7eb3, #ff758c);
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 30px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #ff758c, #ff7eb3);
        }
        .footer {
            position: relative;
            z-index: 1;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
        }
        @media (max-width: 768px) {
            .tilt-card {
                width: 90%;
            }
            .navbar .btn {
                font-size: 14px;
                padding: 5px 10px;
            }
            .hero h1 {
                font-size: 24px;
            }
            .hero p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
    <div class="background-animation">
        <i class="fa fa-file icon-animation" style="top: 10%; left: 20%; animation-duration: 6s;"></i>
        <i class="fa fa-folder icon-animation" style="top: 30%; left: 50%; animation-duration: 8s;"></i>
        <i class="fa fa-video icon-animation" style="top: 50%; left: 70%; animation-duration: 10s;"></i>
        <i class="fa fa-file-alt icon-animation" style="top: 70%; left: 30%; animation-duration: 7s;"></i>
        <i class="fa fa-folder-open icon-animation" style="top: 85%; left: 60%; animation-duration: 9s;"></i>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fa fa-cloud"></i> File Manager</a>
            <div class="ms-auto d-flex align-items-center">
                <?php if (isset($_SESSION['user_email'])): ?>
                    <span class="text-white me-3"><?= htmlspecialchars($_SESSION['user_email']); ?></span>
                    <img src="<?= isset($_SESSION['user_profile']) ? htmlspecialchars($_SESSION['user_profile']) : 'default-profile.png'; ?>" 
                         alt="Profile" class="profile-pic me-3">
                    <a href="logout.php" class="btn btn-outline-light">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light me-2">Login</a>
                    <a href="register.php" class="btn btn-light text-dark">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="hero">
        <h1 class="fw-bold">Manage Your Files in Real-Time, Anywhere!</h1>
        <p class="lead">Secure, Fast, and Intuitive Cloud Storage for modern users.</p>
        <a href="#" class="btn btn-primary" id="getStartedBtn">Get Started</a>
    </div>
    
    <div class="container d-flex flex-wrap justify-content-center mt-5">
        <div class="tilt-card col-md-3" data-tilt>
            <i class="fa fa-users fa-3x mb-3"></i>
            <h3>Live Collaboration</h3>
            <p>Share and edit files in real-time with your team.</p>
        </div>
        <div class="tilt-card col-md-3" data-tilt>
            <i class="fa fa-lock fa-3x mb-3"></i>
            <h3>Secure Storage</h3>
            <p>End-to-end encryption keeps your data safe.</p>
        </div>
        <div class="tilt-card col-md-3" data-tilt>
            <i class="fa fa-bolt fa-3x mb-3"></i>
            <h3>Fast Access</h3>
            <p>Optimized performance for instant file retrieval.</p>
        </div>
    </div>
    
    <footer class="footer">
        <p>&copy; 2025 File Management System | <a href="#" class="text-light">Privacy Policy</a></p>
    </footer>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Required</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="loginFrame" src="login.php" width="100%" height="400px" style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    
    
    <script>
        $(document).ready(function () {
            let checkLoginInterval;

            $("#getStartedBtn").click(function () {
                $.ajax({
                    url: "check_login.php",
                    type: "GET",
                    cache: false,
                    success: function (response) {
                        if (response.trim() === "logged_in") {
                            window.location.href = "dashboard.php";
                        } else {
                            $("#loginModal").modal("show");

                            // Periodically check if the user has logged in
                            checkLoginInterval = setInterval(function () {
                                $.ajax({
                                    url: "check_login.php",
                                    type: "GET",
                                    cache: false,
                                    success: function (response) {
                                        if (response.trim() === "logged_in") {
                                            clearInterval(checkLoginInterval); // Stop checking
                                            $("#loginModal").modal("hide"); // Hide the modal
                                            window.location.href = "dashboard.php"; // Redirect
                                        }
                                    }
                                });
                            }, 2000); // Check every 2 seconds
                        }
                    },
                    error: function () {
                        alert("Error checking login status. Please try again.");
                    }
                });
            });

            // Stop checking when modal is closed manually
            $("#loginModal").on("hidden.bs.modal", function () {
                clearInterval(checkLoginInterval);
            });
        });
    </script>
    <!-- Titl card hover script -->
     <script>
        $(document).ready(function() {
            VanillaTilt.init(document.querySelectorAll(".tilt-card"), {
                max: 25,
                speed: 400,
                glare: true,
                "max-glare": 0.5
            });
        });
     </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
