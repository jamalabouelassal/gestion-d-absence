<?php
require_once('identifier.php');
require_once('connection_db.php');

function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

// Handle search and niveau filter
$search = isset($_POST['search']) ? $_POST['search'] : '';
$selectedNiveau = isset($_POST['niveau']) ? $_POST['niveau'] : '';

// Fetch all distinct niveau options
$niveauQuery = "SELECT DISTINCT niveau FROM ProfesseurNiveau";
$niveauStmt = $pdo->query($niveauQuery);
$niveauOptions = $niveauStmt->fetchAll(PDO::FETCH_COLUMN);

// Construct the query and parameters
$query = "SELECT p.*, 
            GROUP_CONCAT(DISTINCT n.niveau SEPARATOR ', ') AS niveaux,
            GROUP_CONCAT(DISTINCT n.matiere SEPARATOR ', ') AS matieres
          FROM Professeur p
          LEFT JOIN ProfesseurNiveau n ON p.code = n.prof_id
          WHERE (p.nom LIKE ? OR p.prenom LIKE ? OR p.code LIKE ?)";
$params = ["%$search%", "%$search%", "%$search%"];

if ($selectedNiveau !== '') {
    $query .= " AND n.niveau = ?";
    $params[] = $selectedNiveau;
}

$query .= " GROUP BY p.code";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$professeur = $stmt->fetchAll();

// Handle removal request
if (isset($_GET['remove'])) {
    $codeToRemove = $_GET['remove'];
    $deleteNiveauQuery = "DELETE FROM ProfesseurNiveau WHERE prof_id = ?";
    $deleteNiveauStmt = $pdo->prepare($deleteNiveauQuery);
    $deleteNiveauStmt->execute([$codeToRemove]);

    $deleteProfQuery = "DELETE FROM Professeur WHERE code = ?";
    $deleteProfStmt = $pdo->prepare($deleteProfQuery);
    $deleteProfStmt->execute([$codeToRemove]);

    header("Location:Professeur.php"); // Redirect to avoid resubmission
    exit();
}

// Handle AJAX requests
// Before accessing $_POST['action'], check if it is set
if (isset($_POST['action']) && $_POST['action'] == 'addProfesseur') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email']; // Make sure you have an input for email in your form
    $password = generateRandomPassword();

    // Store the new professor in the database
    $sql = "INSERT INTO Professeur (nom, prenom, password, email) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$nom, $prenom, $password, $email]);
    if ($result) {
        // If the insertion was successful, send the password by email
        sendPasswordEmail($email, $password);

        echo json_encode(['success' => 'Professeur ajouté avec succès']);
    } else {
        echo json_encode(['error' => 'Erreur lors de l\'ajout du professeur']);
    }
    exit;
} else if (isset($_POST['action']) && $_POST['action'] == 'addProfesseurNiveau') {
    $code = $_POST['code'];
    $niveau = $_POST['niveau'];
    $matiere = $_POST['matiere'];

    $sql = "INSERT INTO ProfesseurNiveau (prof_id, niveau, matiere) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$code, $niveau, $matiere]);
    if ($result) {
        echo json_encode(['success' => 'Niveau ajouté au professeur avec succès']);
    } else {
        echo json_encode(['error' => 'Erreur lors de l\'ajout du niveau au professeur']);
    }
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Professeurs</title>
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .card.border-primary {
            border-color: #337ab7 !important;
            border-width: 1px !important;
        }

        .card-header.bg-primary {
            background-color: #337ab7 !important;
            color: #fff;
        }

        @media (max-width: 768px) {
            .form-control, .form-select, .btn {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body class="bbb">
    <?php include("menu.php"); ?>
    <div class="container mt-5 margetop">
        <h2 class="mb-3">Liste des Professeurs</h2>
        <div class="mb-3">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addProfesseurModal" style="background-color: #337ab7; border-color: #337ab7;">Ajouter un Professeur</button>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNiveauModal" style="background-color: #337ab7; border-color: #337ab7;">Ajouter un Niveau au Professeur</button>
        </div>
        <form method="POST" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Rechercher des Professeurs" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-4">
                <select name="niveau" class="form-select">
                    <option value="">Tous les Niveaux</option>
                    <?php foreach ($niveauOptions as $niveau): ?>
                        <option value="<?= htmlspecialchars($niveau) ?>" <?= $niveau == $selectedNiveau ? 'selected' : '' ?>><?= htmlspecialchars($niveau) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-success w-100">Rechercher</button>
            </div>
        </form>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Niveaux</th>
                    <th>Matières</th>
                    <th>Mot de passe</th>
                    <th>Actions</th>         
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professeur as $prof): ?>
                <tr>
                    <td><?= htmlspecialchars($prof['code']); ?></td>
                    <td><?= htmlspecialchars($prof['nom']); ?></td>
                    <td><?= htmlspecialchars($prof['prenom']); ?></td>
                    <td><?= htmlspecialchars($prof['niveaux']); ?></td>
                    <td><?= htmlspecialchars($prof['matieres']); ?></td>
                    <td>
                        <button onclick="generatePassword(<?= $prof['code']; ?>);" class="btn btn-warning" style="background-color: #337ab7; border-color: #337ab7;">Générer un Nouveau Mot de Passe</button>
                    </td>
                    <td>
                        <a href="modify_professeur.php?code=<?= $prof['code']; ?>" class="btn btn-primary" style="background-color: #337ab7; border-color: #337ab7;">Modifier</a>
                        <a href="Professeur.php?remove=<?= $prof['code']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Professor Modal -->
    <div class="modal fade" id="addProfesseurModal" tabindex="-1" aria-labelledby="addProfesseurModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProfesseurModalLabel">Ajouter un Nouveau Professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProfesseurForm">
                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="form-group">
                            <label for="email">e_mail:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Niveau Modal -->
    <div class="modal fade" id="addNiveauModal" tabindex="-1" aria-labelledby="addNiveauModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNiveauModalLabel">Ajouter un Niveau au Professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addNiveauForm">
                        <div class="form-group">
                            <label for="code">Code du Professeur:</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="niveau">Niveau:</label>
                            <input type="text" class="form-control" id="niveau" name="niveau" required>
                        </div>
                        <div class="form-group">
                            <label for="matiere">Matière:</label>
                            <input type="text" class="form-control" id="matiere" name="matiere" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generatePassword(profId) {
            if (confirm('Êtes-vous sûr de modifier le mot de passe?')) {
                var newPassword = '<?= generateRandomPassword(); ?>'; // Server-side generation
                alert("Nouveau Mot de Passe pour le Professeur ID " + profId + ": " + newPassword);

                // Send new password to server for update via AJAX
                $.ajax({
                    url: 'update_prof_password.php',
                    type: 'POST',
                    data: {
                        profId: profId,
                        newPassword: newPassword
                    },
                    success: function(response) {
                        alert(response);
                    },
                    error: function() {
                        alert('Erreur lors de la mise à jour du mot de passe');
                    }
                });
            }
        }

        $(document).ready(function() {
    $('#addProfesseurForm').on('submit', function(e) {
        e.preventDefault();  // Prevent the actual form submission
        var formData = $(this).serializeArray();
        formData.push({name: 'action', value: 'addProfesseur'});

        console.log("Form data being sent:", formData); // Check what data is being sent

        $.ajax({
            type: 'POST',
            url: '', // Consider using a full path if relative path doesn't work
            data: $.param(formData),
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert(result.success);
                    $('#addProfesseurModal').modal('hide');
                    location.reload(); // Reload the page to see new data
                } else {
                    alert(result.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error in AJAX request:", status, error);
                alert('Erreur lors de l\'ajout du professeur.');
            }
        });
    });
});

            // Handle form submission for adding a niveau to professor
            $('#addNiveauForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serializeArray();
                formData.push({name: 'action', value: 'addProfesseurNiveau'});

                $.ajax({
                    type: 'POST',
                    url: '', // Empty URL means this same script/file
                    data: $.param(formData),
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert(result.success);
                            $('#addNiveauModal').modal('hide');
                            location.reload();
                        } else {
                            alert(result.error);
                        }
                    },
                    error: function() {
                        alert('Erreur lors de l\'ajout du niveau au professeur.');
                    }
                });
            });
        
    </script>
</body>
</html>