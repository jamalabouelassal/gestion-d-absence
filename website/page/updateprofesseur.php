<?php
require_once('identifier.php');

require_once('connection_db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
     $email = $_POST['email'];
   
   
    

    try {
        // Prepare the SQL statement to insert data into Etudiant table
        $sql = "INSERT INTO professeur (nom, prenom, email) VALUES (:nom, :prenom, :email   )";
        $statement = $pdo->prepare($sql);

        // Bind parameters
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':prenom', $prenom);
        $statement->bindParam(':email', $email);

       
        
       
        // Execute the SQL statement
        $statement->execute();

        // Redirect back to the page with success message
        header("Location: Professeur.php?success=1");
        exit();
    } catch (PDOException $e) {
        // If an error occurs, redirect back to the page with error message
        header("Location: add_professeur.php?error=1");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the page
    header("Location: add_professeur.php");
    exit();
}
?>