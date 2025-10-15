<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base navigation styling */
        .navbar-custom {
            background-image: linear-gradient(to right, #AFAFAF, #337ab7); /* Dégradé de gris clair à bleu (Bootstrap 3 style) */
            border-color: #000;
            padding: 5px 10px; /* Reduced padding for a more compact navbar */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff; /* White color for text */
            padding: 8px 12px; /* Adjusted padding for compactness */
            font-size: 14px; /* Adjust font size if necessary */
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link:focus,
        .navbar-custom .nav-link.active {
            background-color: #505050; /* Gray background on hover/active */
            color: #fff; /* Ensuring text is still white for contrast */
        }

        .extraordinaire {
            font-weight: bold;
            color: #AFAFAF;
            background-color: #424242;
        }

        #logout-link {
            color: #fff; /* White color for better visibility */
        }

        #logout-link:hover {
            color: #A9A9A9; /* Gray color on hover */
        }

        /* Adjustments for the navbar brand image */
        .navbar-brand img {
            width: 150px; /* Adjust width as needed */
            height: 55px; /* Adjust height to maintain a rectangle */
            border-radius: 0; /* Remove rounding to make it rectangular */
            margin-top: -17px; /* Adjust top margin to align image vertically */
            margin-bottom: -15px; /* Adjust bottom margin to align image vertically */
            margin-left: -24px;
        }

        /* Responsive behavior */
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 5px 10px; /* Adjusting padding for smaller screens */
            }
            .navbar-nav {
                margin-top: 0; /* Adjust margin for nav items on mobile */
            }
            .navbar-collapse.collapse {
                display: none !important; /* Ensuring collapse is not displayed */
            }
            .collapse.show {
                display: block !important; /* Ensuring expanded menu is displayed */
                background-color: #337ab7; /* Background color for the collapsed menu */
            }
            .navbar-toggler {
                display: block; /* Ensuring the toggler is visible */
            }
            .navbar-nav .nav-link {
                color: #fff; /* White color for the collapsed menu links */
            }
            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link:focus {
                background-color: #505050; /* Gray background on hover/active in the collapsed menu */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" style="height: 55px;">
        <div class="container-fluid">
            <a href="../index.php" class="navbar-brand" style="width: 130px; height: 30px; border-radius: 0; margin-top: -12px; margin-bottom: -2px; margin-left: -24px;">
                <img src="../img/image2fsac4.jpg" alt="FSAC Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="Dashboard.php">DASHBOARD</a></li>
                    <li class="nav-item"><a class="nav-link" href="Filiere.php">FILIERE</a></li>
                    <li class="nav-item"><a class="nav-link" href="Professeur.php">PROFESSEUR</a></li>
                    <li class="nav-item"><a class="nav-link" href="PROPOS.php">PRESENCE/ABSCENSE</a></li>
                    <li class="nav-item"><a class="nav-link" href="empl.php">SEANCES</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="Profile.php"><i class="fa fa-user"></i> PROFILE</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="SeDeconnecter.php" id="logout-link"><i class="fa fa-sign-out-alt"></i> Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var logoutLink = document.getElementById('logout-link');
            logoutLink.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior
                var logoutUrl = this.getAttribute("href"); // Get the href attribute
                this.style.display = 'none'; // Hide the link
                window.location.href = logoutUrl; // Redirect to the logout URL
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
