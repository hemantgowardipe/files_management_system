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
    <style>
        body {
            background: linear-gradient(135deg, #000000, #2c2c2c, #ffffff);
            color: white;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            padding: 15px;
            transition: all 0.4s ease-in-out;
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
        .section {
            padding: 100px 20px;
            transition: transform 0.3s ease-in-out;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-attachment: fixed;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .parallax {
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Enables the parallax effect */
            background-repeat: no-repeat;
        }

        .footer {
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
        }
        .blur-bg {
            filter: blur(10px);
            transition: filter 0.4s ease-in-out;
        }
        .btn-primary {
            background: linear-gradient(135deg, #ffffff, #cccccc);
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 10px;
            transition: background 0.3s, transform 0.2s ease-in-out;
            color: black;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #bbbbbb, #ffffff);
            transform: scale(1.05);
        }
        .navbar-nav {
            margin: 0 auto;
        }
        .loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loader i {
            font-size: 50px;
            color: white;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% {transform: rotate(0deg);}
            100% {transform: rotate(360deg);}
        }
        #services .tilt-card {
            background: rgba(55, 50, 50, 0.18);
            border-radius: 20px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="loader">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home"><i class="fa fa-cloud"></i> File Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn btn-outline-light me-2">Login</a>
                    <a href="register.php" class="btn btn-light text-dark">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div id="content">
        <div class="background-animation">
            <i class="fa fa-file icon-animation" style="top: 10%; left: 20%; animation-duration: 6s;"></i>
            <i class="fa fa-folder icon-animation" style="top: 30%; left: 50%; animation-duration: 8s;"></i>
            <i class="fa fa-video icon-animation" style="top: 50%; left: 70%; animation-duration: 10s;"></i>
            <i class="fa fa-file-alt icon-animation" style="top: 70%; left: 30%; animation-duration: 7s;"></i>
            <i class="fa fa-folder-open icon-animation" style="top: 85%; left: 60%; animation-duration: 9s;"></i>
        </div>
        <section id="home" class="section parallax">
            <div class="hero">
                <h1 class="fw-bold">Manage Your Files in Real-Time, Anywhere!</h1>
                <p class="lead">Secure, Fast, and Intuitive Cloud Storage for modern users.</p>
                <a href="#" class="btn btn-primary" id="getStartedBtn">Get Started</a>
            </div>
        </section>
        
        <section id="about" class="section parallax">
            <div class="hero">
            <h1>About Us</h1>
            <p>File Manager is a cloud storage service that allows you to store your files securely and access them from anywhere in the world.</p>
            <p>Our platform is designed to be user-friendly and intuitive, making it easy for you to manage your files and collaborate with others in real-time.</p>
            <div class="container d-flex flex-wrap justify-content-center mt-5">
                <div class="tilt-card col-md-3" data-tilt>
                    <i class="fa fa-users fa-3x mb-3"></i>
                    <h3>File Manager</h3> <h4>Secure, Seamless, and Smart Cloud Collaboration</h4>
                    <p>At File Manager, we believe in the power of seamless cloud storage and real-time collaboration. Our mission is to provide a secure, efficient, and user-friendly platform that helps individuals and teams manage their files with ease.</p>
                </div>
                <div class="tilt-card col-md-3" data-tilt>
                    <i class="fa fa-lock fa-3x mb-3"></i>
                    <h3>Secure & Fast </h3><h4>End-to-End Encryption for Hassle-Free Access</h4>
                    <p>Our system offers end-to-end encryption, ensuring that your files are always protected. With our fast and optimized performance, you can access and share your data from anywhere in the world without any hassle.</p>
                </div>
                <div class="tilt-card col-md-3" data-tilt>
                    <i class="fa fa-bolt fa-3x mb-3"></i>
                    <h3>Continuous Innovation for Smarter Cloud File Management</h3>
                    <p>We are constantly innovating and enhancing our services to make cloud file management as simple and efficient as possible.</p>
                </div>
            </div>
        </div>
        </section>
        
        <section id="services" class="section parallax">
            <div class="hero">
            <h1>Our Services</h1>
            <div class="container d-flex flex-wrap justify-content-center mt-5">
                <div class="tilt-card col-md-3" data-tilt>
                    <i class="fa fa-sync fa-3x mb-3"></i>
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
        </div>
        </section>
    </div>
    
    <footer class="footer" style="background: rgba(31, 31, 31, 0.586);">
        <p>Contact Us: Miniproject6thsemgroup1@gmail.com | Phone: +1234567890</p>
        <p>&copy; 2025 File Management System</p>
    </footer>
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
         // Loader fadeout
         $(".loader").fadeOut(1000);
        $(document).ready(function () {
            $('.navbar-toggler').click(function () {
                $('#content').toggleClass('blur-bg');
            });
        });
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
    <script>
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scrolling down
                navbar.style.top = '-80px'; // Adjust the value based on your navbar height
            } else {
                // Scrolling up
                navbar.style.top = '0';
            }

            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For mobile or negative scrolling
        });
    </script>
    <!-- <script>
    let lastScrollTop = 0;
    const sections = document.querySelectorAll('.section'); // Select all sections

    window.addEventListener('scroll', function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        sections.forEach(section => {
            if (scrollTop > lastScrollTop) {
                // Scrolling down
                section.style.opacity = '0'; // Hide the section
                section.style.transform = 'translateY(50px)'; // Add a downward motion
            } else {
                // Scrolling up
                section.style.opacity = '1'; // Show the section
                section.style.transform = 'translateY(0)'; // Reset the position
            }
        });

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For mobile or negative scrolling
    });
</script> -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

