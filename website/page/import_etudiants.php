<?php
require_once('connection_db.php');

if ($_FILES['csv_file']['error'] == 0) {
    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');

    // Skip the first line if it contains headers
    fgetcsv($file, 1000, ";");

    // Reading each line of the file, specifying the delimiter ';'
    while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
        // Display data for debugging
        echo "<pre>"; print_r($data); echo "</pre>";

        $code = $data[0];
        $nom = $data[1];
        $prenom = $data[2];
        $sex = $data[3];
        $nom_niveau = $data[4];  // Name of the niveau
        $photo = $data[5];
        $date_naissance = $data[6];
        $lieu_naissance = $data[7];
        $cin = $data[8];
        $nom_filiere = $data[9];  // Name of the filiere

        // Retrieve id_niveau from the niveau table
        $stmtNiveau = $pdo->prepare("SELECT id_niveau FROM niveau WHERE nom_niveau = ?");
        $stmtNiveau->execute([$nom_niveau]);
        $niveau_id = $stmtNiveau->fetchColumn();  // Fetches the first column of the next row

        // Retrieve id_filiere from the filiere table
        $stmtFiliere = $pdo->prepare("SELECT id_filiere FROM filiere WHERE nom_filiere = ?");
        $stmtFiliere->execute([$nom_filiere]);
        $filiere_id = $stmtFiliere->fetchColumn();  // Fetches the first column of the next row

        // Insert the student data into Etudiant
        $stmt = $pdo->prepare("INSERT INTO Etudiant (code, nom, prenom, sex, niveau, niveau_id, id_filiere, photo, date_naissance, lieu_naissance, cin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt->execute([$code, $nom, $prenom, $sex, $nom_niveau, $niveau_id, $filiere_id, $photo, $date_naissance, $lieu_naissance, $cin])) {
            echo "<pre>Erreur lors de l'insertion : "; print_r($stmt->errorInfo()); echo "</pre>";
        }
    }

    fclose($file);

    // Redirect to the list of students
    header('Location: listEtudiants.php');
} else {
    echo "Erreur lors du téléchargement du fichier.";
}
?>
