<?php


function addSchedule($niveau, $jour, $heure_debut, $heure_fin, $matiere) {
    require_once('connection_db.php'); // Ensure the database connection is available

    $sql = "INSERT INTO emploi_du_temps (niveau, jour, heure_debut, heure_fin, matiere) VALUES (:niveau, :jour, :heure_debut, :heure_fin, :matiere)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':niveau' => $niveau,
        ':jour' => $jour,
        ':heure_debut' => $heure_debut,
        ':heure_fin' => $heure_fin,
        ':matiere' => $matiere
    ]);
    return $pdo->lastInsertId(); // Returns the ID of the inserted record
}

?>