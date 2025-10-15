<?php
require_once('identifier.php');

// Vérification si les données ont été soumises via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclusion du fichier de connexion à la base de données
    require_once('connection_db.php');

    // Récupération des données du formulaire
    $nomFiliere = isset($_POST['fname']) ? $_POST['fname'] : "";
    $departementID = isset($_POST['departement']) ? $_POST['departement'] : null;  // Assuming departement ID is passed

    // Préparation de la requête SQL d'insertion
    // Make sure to insert into correct columns and consider foreign keys
    $sql = "INSERT INTO filiere (nom_filiere, id_dep) VALUES (:nomFiliere, :departementID)";

    // Préparation de la déclaration SQL
    $stmt = $pdo->prepare($sql);

    if ($stmt) {
        // Liaison des paramètres
        $stmt->bindParam(':nomFiliere', $nomFiliere);
        $stmt->bindParam(':departementID', $departementID);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Redirection vers la page de liste des filières après l'insertion
            header("Location: Filiere.php");
            exit();
        } else {
            // En cas d'échec de l'exécution de la requête
            echo "Erreur lors de l'insertion de la filière.";
        }
    } else {
        // En cas d'échec de la préparation de la déclaration SQL
        echo "Erreur lors de la préparation de la requête.";
    }
} else {
    // Redirection vers la page d'ajout de filière si les données ne sont pas soumises via POST
    header("Location: nouvellefiliere.php");
    exit();
}
?>
