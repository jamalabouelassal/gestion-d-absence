<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

require_once('connection_db.php');

$professor_code = $_SESSION['user']['code'];

$stmt = $pdo->prepare("SELECT p.*, GROUP_CONCAT(n.niveau SEPARATOR ',') AS niveaux FROM Professeur p LEFT JOIN ProfesseurNiveau n ON p.code = n.prof_id WHERE p.code = ? GROUP BY p.code");
$stmt->execute([$professor_code]);
$professor = $stmt->fetch();

if ($professor) {
    $niveauxArray = explode(',', $professor['niveaux']);
    $selectedNiveau = isset($_GET['niveau']) && in_array($_GET['niveau'], $niveauxArray) ? $_GET['niveau'] : '';
    if ($selectedNiveau) {
        $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE niveau = ?");
        $stmt->execute([$selectedNiveau]);
    } else {
        $placeholders = implode(',', array_fill(0, count($niveauxArray), '?'));
        $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE niveau IN ($placeholders)");
        $stmt->execute($niveauxArray);
    }
    $students = $stmt->fetchAll();
} else {
    $students = [];
    echo "No professor found or other error.";
}

// Profile edit section
try {
    $sql = "SELECT nom, prenom, email FROM Professeur WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':code', $professor_code);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $nom = $user['nom'];
        $prenom = $user['prenom'];
        $email = $user['email'];
    } else {
        $nom = 'default_nom';
        $prenom = 'default_prenom';
        $email = 'default_email@example.com';
        echo "No user found with code = " . htmlspecialchars($professor_code);
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    $nom = 'error_loading_nom';
    $prenom = 'error_loading_prenom';
    $email = 'error_loading_email';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar-custom {
            background-image: linear-gradient(to right, #AFAFAF, #337ab7);
            border-color: #000;
            padding: 5px 10px;
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: #fff;
            padding: 8px 12px;
            font-size: 14px;
        }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link:focus, .navbar-custom .nav-link.active {
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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 100px;
        }
        .profile-info {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .update-password {
            margin-top: 20px;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
        }
        h1, h2 {
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include("navprof.php"); ?>

    <div class="container">
        <h1>Bienvenue, <?= htmlspecialchars($nom) ?> <?= htmlspecialchars($prenom) ?></h1>
        <div class="profile-info">
            <img src="../img/fsacimage.jpg" alt="Profile Picture" class="profile-picture">
            <div class="name">
                <h2><?= htmlspecialchars($nom) ?> <?= htmlspecialchars($prenom) ?></h2>
                <p>Code: <?= htmlspecialchars($professor['code']) ?></p>
            </div>
        </div>
        <div class="update-password">
            <h3>Update Your Information</h3>
            <button class="btn btn-info" onclick="showForm('edit-nom')">Edit Last Name</button>
            <button class="btn btn-info" onclick="showForm('edit-prenom')">Edit First Name</button>
            <button class="btn btn-info" onclick="showForm('edit-email')">Edit Email</button>
            <button class="btn btn-info" onclick="showForm('edit-password')">Edit Password</button>
            <div id="edit-nom" class="form-edit mt-3" style="display:none;">
                <form action="update_nom.php  " method="post">
                    <input type="hidden" name="code" value="<?= htmlspecialchars($professor_code) ?>">
                    <input type="text" name="nom" placeholder="Enter new last name" required class="form-control">
                    <button type="submit" class="btn btn-success mt-2">Update Last Name</button>
                </form>
            </div>
            <div id="edit-prenom" class="form-edit mt-3" style="display:none;">
                <form action="update_prenom.php" method="post">
                    <input type="hidden" name="code" value="<?= htmlspecialchars($professor_code) ?>">
                    <input type="text" name="prenom" placeholder="Enter new first name" required class="form-control">
                    <button type="submit" class="btn btn-success mt-2">Update First Name</button>
                </form>
            </div>
            <div id="edit-email" class="form-edit mt-3" style="display:none;">
                <form action="update_email.php" method="post">
                    <input type="hidden" name="code" value="<?= htmlspecialchars($professor_code) ?>">
                    <input type="email" name="email" placeholder="Enter new email" required class="form-control">
                    <button type="submit" class="                    btn btn-success mt-2">Update Email</button>
                </form>
            </div>
            <div id="edit-password" class="form-edit mt-3" style="display:none;">
                <form action="update_passwordprof.php" method="post">
                    <input type="hidden" name="code" value="<?= htmlspecialchars($professor_code) ?>">
                    <input type="password" name="old_password" placeholder="Enter old password" required class="form-control">
                    <input type="password" name="new_password" placeholder="Enter new password" required class="form-control mt-2">
                    <button type="submit" class="btn btn-success mt-2">Update Password</button>
                </form>
            </div>
        </div>
        <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
            <div class="alert alert-success mt-3">
                Information updated successfully.
            </div>
        <?php elseif (isset($_GET['update']) && $_GET['update'] == 'failure'): ?>
            <div class="alert alert-danger mt-3">
                Failed to update information.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        function showForm(formId) {
            document.querySelectorAll('.form-edit').forEach(function(form) {
                form.style.display = 'none';
            });
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</body>
</html>

