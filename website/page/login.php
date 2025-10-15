<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Selector</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* styles.css */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #AFAFAF, #337ab7);
            overflow: hidden; /* Prevents scrolling */
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(211, 211, 208, 0.7); /* Semi-transparent background */
            z-index: -1; /* Ensure it is behind the login-container */
            animation: backgroundAnimation 15s infinite alternate;
        }

        @keyframes backgroundAnimation {
            0% { background-color: rgba(211, 211, 208, 0.7); }
            100% { background-color: rgba(255, 255, 255, 0.7); }
        }

        .background-overlay img {
            max-width: 50%; /* Adjust as needed */
            height: auto;
        }

        .header-logo {
            position: absolute;
            top: -3px; /* Move closer to the top */
            left: 25%;
            transform: translateX(-50%);
            z-index: 2;
            animation: logoAnimation 2s ease-in-out forwards;
        }

        .header-logo img {
            width: 700px; /* Adjust size as needed */
            height: auto;
            transform: scale(0.8);
        }

        @keyframes logoAnimation {
            0% {
                opacity: 0;
                transform: translateY(-20px) scale(0.8);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            background-color: rgba(255, 255, 255, 0.8); /* Adjust background color and transparency */
            border-radius: 20px;
            z-index: -1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow effect */
        }

        .login-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100vh;
            padding: 20px;
            position: relative; /* Ensure it stays above the background */
            z-index: 1; /* Ensure it is above the overlay */
            animation: containerAnimation 1s ease-out;
        }

        @keyframes containerAnimation {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-area {
            width: 250px;
            height: 250px;
            padding: 20px;
            text-align: center;
            border: 5px solid #000;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 0 0 5px black;
            background-blend-mode: darken; /* To ensure text visibility */
            border-radius: 50%;
            position: relative;
            overflow: hidden;
        }

        .login-area::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Overlay color */
            z-index: 0;
            transition: background-color 0.3s ease;
        }

        .login-area:hover::before {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .login-area:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .login-area h2 {
            position: relative;
            z-index: 1;
        }

        .login-area + .tooltip {
            display: none;
            position: absolute;
            top: 280px; /* Position below the circle */
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            z-index: 2;
            white-space: nowrap; /* Prevents text wrapping */
        }

        .login-area:hover + .tooltip {
            display: block;
        }

        #admin-prof-login {
            border-color: blue;
            background-image: url('http://localhost/gestion_website/img/prof2.jpg');
        }

        #student-login {
            border-color: green;
            background-image: url('http://localhost/gestion_website/img/student5.jpg');
        }

        footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: #fff;
            text-shadow: 0 0 5px black;
        }
    </style>
</head>
<body>
    
    <div class="header-logo">
        <img src="http://localhost/gestion_website/img/FSAC LOGO.png" alt="Website Logo">
    </div>
    <div class="login-background"></div>
    <div class="login-container">
        <div class="login-area" id="admin-prof-login">
            <h2>Admin/Professor Login</h2>
        </div>
        <div class="tooltip">Click to login as Admin or Professor</div>
        <div class="login-area" id="student-login">
            <h2>Student Login</h2>
        </div>
        <div class="tooltip">Click to login as Student</div>
    </div>
    <footer>
        <p>© 2024  Face Recognition. All rights reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
<script>
    // script.js
    document.getElementById('admin-prof-login').addEventListener('click', function() {
        window.location.href = 'login1.php';  // Redirect to admin/professor login
    });

    document.getElementById('student-login').addEventListener('click', function() {
        window.location.href = 'login3.php';  // Redirect to student login
    });

    // Add some interactive effects with JavaScript
    document.querySelectorAll('.login-area').forEach(function(element) {
        element.addEventListener('mouseenter', function() {
            element.style.boxShadow = '0 0 20px rgba(0, 0, 0, 0.5)';
        });

        element.addEventListener('mouseleave', function() {
            element.style.boxShadow = 'none';
        });
    });
</script>
</html>
