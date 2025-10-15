<?php



require_once('identifier.php');


// Include the database connection file
require_once('connection_db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $code = $_POST['code'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sex = $_POST['sex'];
    $photo = $_POST['photo'];

    try {
        // Prepare the SQL statement to update the student record in the Etudiant table
        $sql = "UPDATE Etudiant SET nom = :nom, prenom = :prenom, sex = :sex, photo = :photo WHERE code = :code";
        $statement = $pdo->prepare($sql);

        // Bind parameters
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':prenom', $prenom);
        $statement->bindParam(':sex', $sex);
        $statement->bindParam(':photo', $photo);
        $statement->bindParam(':code', $code);

        // Execute the SQL statement
        $statement->execute();

        // Redirect back to the page with success message
        header("Location:listEtudiants.php?success=1");
        exit();
    } catch (PDOException $e) {
        // If an error occurs, redirect back to the page with error message
        header("Location: updateEtudiant.php?code=$code&error=1");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the page
    header("Location: updateEtudiant.php?code=$code");
    exit();
}
?>