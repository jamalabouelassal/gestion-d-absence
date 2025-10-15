<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        .navbar-brand img {
            width: 150px;
            height: 55px;
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
            <a href="professor_dashboard.php" class="navbar-brand" style="width: 130px; 
    height: 30px; 
    border-radius: 0; 
    margin-top: -12px; 
    margin-bottom: -2px; 
    margin-left:-24px ;"><img src="../img/image2fsac4.jpg" alt="FSAC Logo" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="professor_dashboard.php"><i class="fas fa-home"></i> HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="mesetudiants.php">MES ETUDIANTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="ABSENCEPROF.php">ABSENCE/PRESENCE</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="SeDeconnecter.php" id="logout-link"><i class="fa fa-sign-out-alt"></i> Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
