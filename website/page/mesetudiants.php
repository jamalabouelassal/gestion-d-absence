<?php
session_start();
require_once('connection_db.php');

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

$professor_code = $_SESSION['user']['code'];

$stmt = $pdo->prepare("SELECT p.*, GROUP_CONCAT(n.niveau SEPARATOR ',') AS niveaux FROM Professeur p LEFT JOIN ProfesseurNiveau n ON p.code = n.prof_id WHERE p.code = ?");
$stmt->execute([$professor_code]);
$professor = $stmt->fetch();

$students = [];

$records_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

if ($professor) {
    $niveauxArray = explode(',', $professor['niveaux']);
    $selectedNiveau = isset($_GET['niveau']) && in_array($_GET['niveau'], $niveauxArray) ? $_GET['niveau'] : '';

    $placeholders = implode(',', array_fill(0, count($niveauxArray), '?'));

    // Count total students for pagination
    if ($selectedNiveau) {
        $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM Etudiant WHERE niveau = ?");
        $count_stmt->execute([$selectedNiveau]);
    } else {
        $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM Etudiant WHERE niveau IN ($placeholders)");
        $count_stmt->execute($niveauxArray);
    }
    $total_rows = $count_stmt->fetchColumn();
    $total_pages = ceil($total_rows / $records_per_page);

    // Fetch students for the current page
    if ($selectedNiveau) {
        $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE niveau = ? LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $selectedNiveau);
        $stmt->bindValue(2, $records_per_page, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE niveau IN ($placeholders) LIMIT ? OFFSET ?");
        foreach ($niveauxArray as $index => $value) {
            $stmt->bindValue($index + 1, $value);
        }
        $stmt->bindValue(count($niveauxArray) + 1, $records_per_page, PDO::PARAM_INT);
        $stmt->bindValue(count($niveauxArray) + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();
    }
    $students = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
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
            margin-top: 80px; /* Ensure content is below the navbar */
        }

        .table {
            width: 100%;
        }

        th {
            background-color: #f0f0f0;
        }

        .form-control {
            margin-right: 200px;
            margin-left: -50px;
        }

        .row > [class^="col-"] {
            padding-left: 50px;
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
    margin-left:-24px ;"><img src="../img/image2fsac4.jpg" alt="FSAC Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="professor_dashboard.php"><i class="fas fa-home"></i> HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="mesetudiants.php">MES ETUDIANTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="ABSENCEPROF.php">AbSENCE/PRESENCE</a></li>
                </ul>
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="SeDeconnecter.php" id="logout-link"><i class="fa fa-sign-out-alt"></i> Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <h2 style="margin-top :60px;">My Students</h2 >
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="nomFilter" class="form-control mb-2" placeholder="Nom...">
            </div>
            <div class="col-md-3">
                <input type="text" id="codeFilter" class="form-control mb-2" placeholder="Code...">
            </div>
            <div class="col-md-3">
                <select id="niveauFilter" class="form-control mb-2">
                    <option value="">All Niveaux</option>
                    <?php foreach ($niveauxArray as $niveau): ?>
                        <option value="<?= htmlspecialchars($niveau) ?>"><?= htmlspecialchars($niveau) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <!-- Optional: Add another element here or adjust for symmetry -->
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Niveau</th>
                </tr>
            </thead>
            <tbody id="studentsBody">
                <?php if ($students): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['code']) ?></td>
                            <td><?= htmlspecialchars($student['nom']) ?></td>
                            <td><?= htmlspecialchars($student['prenom']) ?></td>
                            <td><?= htmlspecialchars($student['niveau']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No students found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="mesetudiants.php?page=<?= $i ?>&niveau=<?= $selectedNiveau ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#nomFilter, #codeFilter, #niveauFilter").on("keyup change", function() {
                var nomVal = $("#nomFilter").val().toLowerCase();
                var codeVal = $("#codeFilter").val().toLowerCase();
                var niveauVal = $("#niveauFilter").val().toLowerCase();

                $("#studentsBody tr").filter(function() {
                    $(this).toggle(
                        $(this).find("td:eq(1)").text().toLowerCase().indexOf(nomVal) > -1 &&
                        $(this).find("td:eq(0)").text().toLowerCase().indexOf(codeVal) > -1 &&
                        ($(this).find("td:eq(3)").text().toLowerCase().indexOf(niveauVal) > -1 || niveauVal === "")
                    );
                });
            });
        });
    </script>
</body>
</html>