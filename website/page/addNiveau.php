<?php
require_once('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idfiliere = $_POST['idfiliere'];
    $niveau = $_POST['niveau'];

    if (!empty($niveau) && !empty($idfiliere)) {
        $query = $pdo->prepare("INSERT INTO niveau (id_filiere, nom_niveau) VALUES (?, ?)");
        $success = $query->execute([$idfiliere, $niveau]);

        if ($success) {
            echo "Niveau added successfully!";
        } else {
            echo "Failed to add niveau.";
        }
    } else {
        echo "Necessary data is missing.";
    }
} else {
    echo "Invalid request.";
}
?>

