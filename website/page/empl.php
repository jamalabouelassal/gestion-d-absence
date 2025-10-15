<?php
require_once('connection_db.php');

// Handle Add Schedule Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'add':
            $niveau = $_POST['niveau'];
            $jour = $_POST['jour'];
            $heure_debut = $_POST['heure_debut'];
            $heure_fin = $_POST['heure_fin'];
            $matiere = $_POST['matiere'];
            $sql = "INSERT INTO emploi_du_temps (niveau, jour, heure_debut, heure_fin, matiere) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$niveau, $jour, $heure_debut, $heure_fin, $matiere]);
            echo "<script>alert('Horaire ajouté avec succès!'); window.location.href = window.location.href;</script>";
            break;
        case 'delete':
            $id = $_POST['id'];
            $sql = "DELETE FROM emploi_du_temps WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            echo "<script>alert('Horaire supprimé avec succès!'); window.location.href = window.location.href;</script>";
            break;
        case 'edit':
            $id = $_POST['id'];
            $niveau = $_POST['niveau'];
            $jour = $_POST['jour'];
            $heure_debut = $_POST['heure_debut'];
            $heure_fin = $_POST['heure_fin'];
            $matiere = $_POST['matiere'];
            $sql = "UPDATE emploi_du_temps SET niveau = ?, jour = ?, heure_debut = ?, heure_fin = ?, matiere = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$niveau, $jour, $heure_debut, $heure_fin, $matiere, $id]);
            echo "<script>alert('Horaire mis à jour avec succès!'); window.location.href = window.location.href;</script>";
            break;
        case 'fetch':
            $id = $_POST['id'];
            $sql = "SELECT * FROM emploi_du_temps WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($result);
            exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Emplois du Temps</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
     <?php include("menu.php"); ?>
<div class="container mt-3">
    <h2>Gestion des Emplois du Temps</h2>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Ajouter un Nouveau Horaire</button>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                
                <th>Niveau</th>
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Matière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM emploi_du_temps";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
              
                echo "<td>" . htmlspecialchars($row['niveau']) . "</td>";
                echo "<td>" . htmlspecialchars($row['jour']) . "</td>";
                echo "<td>" . htmlspecialchars($row['heure_debut']) . "</td>";
                echo "<td>" . htmlspecialchars($row['heure_fin']) . "</td>";
                echo "<td>" . htmlspecialchars($row['matiere']) . "</td>";
                echo "<td>
                        <button class='btn btn-success btn-sm edit-btn' data-id='{$row['id']}'>Modifier</button>
                        <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Supprimer</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Schedule Modal -->
<div class="modal" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un Nouveau Horaire</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addScheduleForm">
                    <div class="form-group">
                        <label for="niveau">Niveau:</label>
                        <input type="text" class="form-control" id="niveau" name="niveau" required>
                    </div>
                    <div class="form-group">
                        <label for="jour">Jour:</label>
                        <input type="text" class="form-control" id="jour" name="jour" required>
                    </div>
                    <div class="form-group">
                        <label for="heure_debut">Heure de début:</label>
                        <input type="time" class="form-control" id="heure_debut" name="heure_debut" required>
                    </div>
                    <div class="form-group">
                        <label for="heure_fin">Heure de fin:</label>
                        <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
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

<!-- Edit Schedule Modal -->
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Horaire</h4>
                <button type="button" the close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm">
                    <div class="form-group">
                        <label for="edit_niveau">Niveau:</label>
                        <input type="text" class="form-control" id="edit_niveau" name="niveau" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jour">Jour:</label>
                        <input type="text" class="form-control" id="edit_jour" name="jour" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_heure_debut">Heure de début:</label>
                        <input type="time" class="form-control" id="edit_heure_debut" name="heure_debut" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_heure_fin">Heure de fin:</label>
                        <input type="time" class="form-control" id="edit_heure_fin" name="heure_fin" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_matiere">Matière:</label>
                        <input type="text" class="form-control" id="edit_matiere" name="matiere" required>
                    </div>
                    <input type="hidden" id="edit_id" name="id">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle form submission for adding a schedule
    $('#addScheduleForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray(); // Serialize the form data.
        formData.push({name: 'action', value: 'add'}); // Add action type to form data

        $.ajax({
            type: 'POST',
            url: '', // Empty URL means this same script/file
            data: $.param(formData),
            success: function(response) {
                alert('Horaire ajouté avec succès!');
                $('#addModal').modal('hide'); // Hide the modal after successful submission
                location.reload(); // Reload the page to see the updated list
            },
            error: function() {
                alert('Erreur lors de l\'ajout de l\'horaire.');
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id'); // Get the ID from the data-id attribute

        if (confirm('Êtes-vous sûr de vouloir supprimer cet horaire?')) {
            $.ajax({
                type: 'POST',
                url: '', // Empty URL means this same script/file
                data: {id: id, action: 'delete'},
                success: function(response) {
                    alert('Horaire supprimé avec succès!');
                    location.reload(); // Reload the page to update the table
                },
                error: function() {
                    alert('Erreur lors de la suppression de l\'horaire.');
                }
            });
        }
    });

    // Event delegation to handle edit button click for dynamically loaded content
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id'); // Get the ID from the data-id attribute

        $.ajax({
            type: 'POST',
            url: '', // Empty URL means this same script/file
            data: {id: id, action: 'fetch'}, // Fetch action to get existing data for editing
            success: function(data) {
                var schedule = JSON.parse(data);
                $('#editModal #edit_niveau').val(schedule.niveau);
                $('#editModal #edit_jour').val(schedule.jour);
                $('#editModal #edit_heure_debut').val(schedule.heure_debut);
                $('#editModal #edit_heure_fin').val(schedule.heure_fin);
                $('#editModal #edit_matiere').val(schedule.matiere);
                $('#editModal #edit_id').val(schedule.id);
                $('#editModal').modal('show');
            },
            error: function() {
                alert('Erreur lors du chargement de l\'horaire.');
            }
        });
    });

    // Handle the edit modal form submission
    $('#editScheduleForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray(); // Serialize the form data including the ID
        formData.push({name: 'action', value: 'edit'}); // Add action type to form data

        $.ajax({
            type: 'POST',
            url: '', // Empty URL means this same script/file
            data: $.param(formData),
            success: function(response) {
                alert('Horaire mis à jour avec succès!');
                $('#editModal').modal('hide'); // Hide the modal after successful submission
                location.reload(); // Reload the page to see the updated list
            },
            error: function() {
                alert('Erreur lors de la mise à jour de l\'horaire.');
            }
        });
    });
});
</script>

</body>
</html>