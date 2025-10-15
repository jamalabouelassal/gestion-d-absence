<?php
require_once('identifier.php');
require_once('connection_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_filiere = $_POST['id_filiere'];
    $nom_filiere = $_POST['nom_filiere'];
    $id_dep = $_POST['id_dep']; // Department ID from the form

    try {
        // Prepare the SQL statement to update the filière details
        $sqlUpdate = "UPDATE Filiere SET nom_filiere = :nom_filiere, id_dep = :id_dep WHERE id_filiere = :id_filiere";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        
        // Bind parameters
        $stmtUpdate->bindParam(':nom_filiere', $nom_filiere);
        $stmtUpdate->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id_filiere', $id_filiere, PDO::PARAM_INT);
        
        // Execute the statement
        $stmtUpdate->execute();

        // Redirect to the filiere page with a success message
        header("Location: filiere.php?success=1");
        exit();
    } catch (PDOException $e) {
        // Handle SQL errors (e.g., key constraints, missing fields, etc.)
        $errorMessage = $e->getMessage();
        header("Location: editfiliere.php?id_filiere=$id_filiere&error=" . urlencode($errorMessage));
        exit();
    }
} else {
    // Redirect back if no data was posted
    header("Location: filiere.php?error=invalid_access");
    exit();
}
?>
