<?php
require_once('identifier.php');
require_once('connection_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $niveau = $_POST['niveau'];
    $sexe = $_POST['sexe'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $cin = $_POST['cin'];
    $pwd = $_POST['pwd'];
    $photo = $_POST['photo'];
    $idfiliere = $_POST['idfiliere']; // Added filiere field

    try {
        $sql = "INSERT INTO Etudiant (nom, prenom, niveau, sex, date_naissance, lieu_naissance, cin, password, photo, idfiliere) VALUES (:nom, :prenom, :niveau, :sexe, :date_naissance, :lieu_naissance, :cin, :pwd, :photo, :idfiliere)";
        $statement = $pdo->prepare($sql);

        // Bind parameters to values
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':prenom', $prenom);
        $statement->bindParam(':niveau', $niveau);
        $statement->bindParam(':sexe', $sexe);
        $statement->bindParam(':date_naissance', $date);
        $statement->bindParam(':lieu_naissance', $lieu);
        $statement->bindParam(':cin', $cin);
        $statement->bindParam(':pwd', $pwd);
        $statement->bindParam(':photo', $photo);
        $statement->bindParam(':idfiliere', $idfiliere); // Bind filiere

        // Execute query
        $statement->execute();
        header("Location: listEtudiants.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: nouvelleETUDIANT.php?error=1&message=".urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: nouvelleETUDIANT.php");
    exit();
}
?>
