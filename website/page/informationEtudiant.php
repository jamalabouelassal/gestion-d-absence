<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

require_once('connection_db.php');

// Assuming $_SESSION['user'] includes user details as an array and 'code' is the identifier
$student_code = $_SESSION['user']['code'];

// Fetch the student's profile
$stmt = $pdo->prepare("SELECT nom, prenom, code, cin, niveau, password, sex, photo, date_naissance, lieu_naissance FROM Etudiant WHERE code = ?");
$stmt->execute([$student_code]);
$student = $stmt->fetch();

if (!$student) {
    echo "No student found or other error.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/monstyle.css">
    <style>
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .hidden {
            display: none;
        }

        /* Base navigation styling */
        .navbar-custom {
            background-image: linear-gradient(to right, #AFAFAF, #337ab7); /* Gradient from light gray to blue */
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
            }
            .navbar-toggler {
                display: block; /* Ensuring the toggler is visible */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" style="height: 55px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="Etudiantdashboard.php" style="width: 130px; 
    height: 30px; 
    border-radius: 0; 
    margin-top: -12px; 
    margin-bottom: -2px; 
    margin-left:-24px ;"><img src="../img/image2fsac4.jpg" alt="FSAC Logo" >
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="Etudiantdashboard.php"><i class="fas fa-home"></i> HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="informationEtudiant.php">MES INFORMATIONS</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="ABSCENCEETUDIANT.php">PRESENCE/ABSENCE</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="SeDeconnecter.php" id="logout-link"><i class="fa fa-sign-out-alt"></i> Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 style="margin-top :60px;">Informations de l'étudiant</h2>
        <div class="profile-info">
            <img src="../img/<?= htmlspecialchars($student['photo']) ?>" alt="Student Photo" class="profile-picture">
            <div>
                <p><strong>Nom:</strong> <?= htmlspecialchars($student['nom']) ?></p>
                <p><strong>Prénom:</strong> <?= htmlspecialchars($student['prenom']) ?></p>
                <p><strong>Code:</strong> <?= htmlspecialchars($student['code']) ?></p>
            </div>
        </div>
        <table class="table">
            <tr><th>CIN</th><td><?= htmlspecialchars($student['cin']) ?></td></tr>
            <tr><th>Niveau</th><td><?= htmlspecialchars($student['niveau']) ?></td></tr>
            <tr>
                <th>Password</th>
                <td>
                    <div class="update-password">
                        <button class="btn btn-info" onclick="togglePasswordForm()">Update Password</button>
                        <form method="POST" action="update_passwordstudent.php" class="hidden" id="password-form">
                            <input type="password" name="new_password" placeholder="Enter New Password" required class="form-control"/>
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>
                    <?php if (isset($_GET['password_update'])): ?>
                        <div class="alert alert-<?= $_GET['password_update'] == 'success' ? 'success' : 'danger'; ?>">
                            Password <?= $_GET['password_update'] == 'success' ? 'updated successfully.' : 'failed to update.'; ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr><th>Sexe</th><td><?= htmlspecialchars($student['sex']) ?></td></tr>
            <tr><th>Date de naissance</th><td><?= htmlspecialchars($student['date_naissance']) ?></td></tr>
            <tr><th>Lieu de naissance</th><td><?= htmlspecialchars($student['lieu_naissance']) ?></td></tr>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        function togglePasswordForm() {
            var form = document.getElementById("password-form");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>
