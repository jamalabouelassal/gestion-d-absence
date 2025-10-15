<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/monstyle.css">
    <style>
        .dashboard {
            margin-top: 70px;
            display: flex;
            gap: 40px;
        }
        .profile {
            flex: 1;
        }
        .attendance-list {
            flex: 2;
        }
        .profile-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .navbar-custom {
            background-image: linear-gradient(to right, #AFAFAF, #337ab7);
            border-color: #000;
            padding: 5px 10px;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff;
            padding: 8px 12px;
            font-size: 14px;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link:focus,
        .navbar-custom .nav-link.active {
            background-color: #505050;
            color: #fff;
        }
        .extraordinaire {
            font-weight: bold;
            color: #AFAFAF;
            background-color: #424242;
        }
        #logout-link {
            color: #fff;
        }
        #logout-link:hover {
            color: #A9A9A9;
        }
        .navbar-brand img {
            width: 150px;
            height: 55px;
            border-radius: 0;
            margin-top: -17px;
            margin-bottom: -15px;
            margin-left: -24px;
        }
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 5px 10px;
            }
            .navbar-nav {
                margin-top: 0;
            }
            .navbar-collapse.collapse {
                display: none !important;
            }
            .collapse.show {
                display: block !important;
            }
            .navbar-toggler {
                display: block;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top" style="height: 55px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="Etudiantdashboard.php" style="width: 130px; height: 30px; border-radius: 0; margin-top: -12px; margin-bottom: -2px; margin-left:-24px;">
            <img src="../img/image2fsac4.jpg" alt="FSAC Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Etudiantdashboard.php"><i class="fas fa-home"></i> HOME</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="ABSCENCEETUDIANT.php">PRESENCE/ABSENCE</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="SeDeconnecter.php" id="logout-link"><i class="fa fa-sign-out-alt"></i> Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var logoutLink = document.getElementById('logout-link');
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            var logoutUrl = this.getAttribute("href");
            this.style.display = 'none';
            window.location.href = logoutUrl;
        });

        var navLinks = document.querySelectorAll('.navbar-nav > li > a');
        navLinks.forEach(function(link) {
            link.addEventListener('mouseover', function() { this.classList.add('extraordinaire'); });
            link.addEventListener('mouseout', function() { this.classList.remove('extraordinaire'); });
        });
    });
</script>
</body>
</html>
