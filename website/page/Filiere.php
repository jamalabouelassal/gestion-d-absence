<?php 
require_once('identifier.php');
require_once('connection_db.php'); 

$nomf = isset($_GET['nomfiliere']) ? $_GET['nomfiliere'] : "";
$departement = isset($_GET['departement']) ? $_GET['departement'] : "all";

// Fetching unique departments for the dropdown from the 'departement' table
$requetedepartementx = "SELECT id_dep, nom_dep FROM departement ORDER BY nom_dep";
$resultatdepartementx = $pdo->query($requetedepartementx);

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'addFiliere') {
        $nom_filiere = $_POST['filiere_name'];
        $id_dep = $_POST['departement'];
        $sql = "INSERT INTO filiere (nom_filiere, id_dep) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$nom_filiere, $id_dep]);
        if ($result) {
            echo json_encode(['success' => 'Filière ajoutée avec succès']);
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'ajout de la filière']);
        }
        exit;
    } elseif ($_POST['action'] == 'addDepartement') {
        $nom_depart = $_POST['nom_depart'];
        $sql = "INSERT INTO departement (nom_dep) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$nom_depart]);
        if ($result) {
            echo json_encode(['id' => $pdo->lastInsertId(), 'success' => 'Département ajouté avec succès']);
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'ajout du département']);
        }
        exit;
    }
}

// Building queries based on the filter
if ($departement == "all") {
    $requete = "SELECT filiere.*, departement.nom_dep FROM filiere
                INNER JOIN departement ON filiere.id_dep = departement.id_dep
                WHERE filiere.nom_filiere LIKE '%$nomf%'";
    $requeteCount = "SELECT count(*) countF FROM filiere WHERE nom_filiere LIKE '%$nomf%'";
} else {
    $requete = "SELECT filiere.*, departement.nom_dep FROM filiere
                INNER JOIN departement ON filiere.id_dep = departement.id_dep
                WHERE filiere.nom_filiere LIKE '%$nomf%' AND departement.id_dep = '$departement'";
    $requeteCount = "SELECT count(*) countF FROM filiere
                     WHERE nom_filiere LIKE '%$nomf%' AND id_dep = '$departement'";
}

$resultatF = $pdo->query($requete);
$resultatCount = $pdo->query($requeteCount);
$tabCount = $resultatCount->fetch();
$nbrFiliere = $tabCount['countF'];
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des filières</title>
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .card.border-primary {
            border-color: #337ab7 !important; /* Couleur bleue de la barre de navigation */
            border-width: 1px !important; /* Réduit l'épaisseur de la bordure */
        }

        .card-header.bg-primary {
            background-color: #337ab7 !important; /* Couleur bleue pour le fond des en-têtes */
            color: #fff; /* Garde le texte blanc pour une bonne lisibilité */
        }

        /* Responsive behavior for forms */
        @media (max-width: 768px) {
            .form-control, .form-select, .btn {
                margin-bottom: 10px; /* Add some space between form elements */
            }
        }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">Gestion Des Filières</div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addFiliereModal">
                    Ajouter une Filière
                </button>
                <button type="button" class="btn btn-secondary mb-2" onclick="toggleDepartementForm()">
                    Ajouter un Département
                </button>
                <form method="get" action="filiere.php" class="row g-3 align-items-center justify-content-between">
                    <div class="col-auto">
                        <input type="text" placeholder="Entrer le nom de la filière" name="nomfiliere" class="form-control" value="<?php echo $nomf ?>">
                    </div>
                    <label for="departement" class="col-form-label col-auto">Département:</label>
                    <div class="col-auto">
                        <select class="form-select" name="departement" id="departement">
                            <option value="all">Tous les départements</option>
                            <?php while ($dep = $resultatdepartementx->fetch()) { ?>
                                <option value="<?php echo $dep['id_dep']; ?>"<?php if ($dep['id_dep'] == $departement) echo ' selected'; ?>>
                                    <?php echo htmlspecialchars($dep['nom_dep']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" style="background-color: #337ab7; border-color: #337ab7;">
                            Rechercher
                        </button>
                    </div>
                </form>
                <div id="addDepartementForm" style="display:none;" class="mt-3">
                    <input type="text" id="newDepartement" placeholder="Nom du nouveau département" class="form-control">
                    <button onclick="addDepartement()" class="btn btn-success">Ajouter</button>
                </div>
            </div>
        </div>

        <!-- Add Filiere Modal -->
        <div class="modal fade" id="addFiliereModal" tabindex="-1" aria-labelledby="addFiliereModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter une Nouvelle Filière</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addFiliereForm">
                            <div class="form-group">
                                <label for="filiere_name">Nom de la filière:</label>
                                <input type="text" class="form-control" id="filiere_name" name="filiere_name" required>
                            </div>
                            <div class="form-group">
                                <label for="departement_select">Département:</label>
                                <select id="departement_select" name="departement" class="form-select" required>
                                    <?php 
                                    // Re-fetch departments for the modal dropdown
                                    $resultatdepartementx->execute();
                                    while ($dep = $resultatdepartementx->fetch()) { ?>
                                        <option value="<?php echo $dep['id_dep']; ?>">
                                            <?php echo htmlspecialchars($dep['nom_dep']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">Liste des filières (<?php echo $nbrFiliere; ?> Filières)</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Département</th>
                            <th>Nom Filière</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($filiere = $resultatF->fetch()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($filiere['nom_dep']); ?></td>
                                <td><?php echo htmlspecialchars($filiere['nom_filiere']); ?></td>
                                <td>
                                    <a href="detailfiliere.php?idfiliere=<?php echo $filiere['id_filiere']; ?>" class="btn btn-info" style="background-color: #337ab7; border-color: #337ab7;">
                                        Détails
                                    </a>
                                    <a href="editfiliere.php?id_filiere=<?php echo $filiere['id_filiere']; ?>&id_dep=<?php echo $filiere['id_dep']; ?>" class="btn btn-warning">Modifier</a>
                                    <a onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')" href="removefiliere.php?idfiliere=<?php echo $filiere['id_filiere']; ?>" class="btn btn-danger">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleDepartementForm() {
            var form = document.getElementById('addDepartementForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function addDepartement() {
            var nomDep = document.getElementById('newDepartement').value;
            if (nomDep.trim() === '') {
                alert('Le nom du département ne peut pas être vide.');
                return;
            }
            $.ajax({
                type: 'POST',
                url: '', // The same script handles the request
                data: { action: 'addDepartement', nom_depart: nomDep },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert(result.success);
                        document.getElementById('newDepartement').value = ''; // Reset field
                        $('#departement, #departement_select').append($('<option>', {
                            value: result.id, // Assuming response contains the new department id
                            text: nomDep,
                            selected: true
                        }));
                        toggleDepartementForm(); // Hide form after adding
                    } else {
                        alert(result.error);
                    }
                },
                error: function() {
                    alert("Erreur lors de l'ajout du département.");
                }
            });
        }

        $(document).ready(function() {
            // Handle form submission for adding a filiere
            $('#addFiliereForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serializeArray(); // Serialize the form data.
                formData.push({name: 'action', value: 'addFiliere'}); // Add action type to form data

                $.ajax({
                    type: 'POST',
                    url: '', // Empty URL means this same script/file
                    data: $.param(formData),
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert(result.success);
                            $('#addFiliereModal').modal('hide'); // Hide the modal after successful submission
                            location.reload(); // Reload the page to see the updated list
                        } else {
                            alert(result.error);
                        }
                    },
                    error: function() {
                        alert('Erreur lors de l\'ajout de la filière.');
                    }
                });
            });
        });
    </script>
</body>
</html>