<?php
require_once('identifier.php');
require_once('connection_db.php');

if(isset($_POST['nomDepartement'])) {
    $nomDepartement = $_POST['nomDepartement'];

    // Inserting the new department into the `departement` table
    $sql = "INSERT INTO departement (nom_dep) VALUES (:nomDepartement)";
    $stmt = $pdo->prepare($sql);

    // Execute the query and check if the insertion was successful
    if ($stmt->execute(['nomDepartement' => $nomDepartement])) {
        $newDepId = $pdo->lastInsertId(); // Get the ID of the newly inserted department
        echo json_encode([
            'status' => 'success',
            'message' => 'Département ajouté avec succès',
            'id_dep' => $newDepId,
            'nom_dep' => $nomDepartement
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur lors de l\'ajout du département'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Aucun nom de département fourni'
    ]);
}
?>
