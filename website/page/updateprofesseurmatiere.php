<?php
require_once('identifier.php');
require_once('connection_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $code = $_POST['code'];
    $niveau = $_POST['matiere'];

    try {
        // Prepare the SQL statement to insert data into professeurniveau table
        $sql = "INSERT INTO professeurmatiere (prof_id, matiere) VALUES (:code, :matiere)";
        $statement = $pdo->prepare($sql);

        // Bind parameters
        $statement->bindParam(':code', $code);
        $statement->bindParam(':matiere', $matiere);

        // Execute the SQL statement
        $statement->execute();

        // Redirect back to the page with success message
        header("Location: Professeur.php?success=1");
        exit();
    } catch (PDOException $e) {
        // If an error occurs, redirect back to the page with error message
        header("Location: add_professeurniveau.php?error=1&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the page
    header("Location: add_professeurniveau.php");
    exit();
}
?>
