<?php
require_once('connection_db.php');

// Enable detailed error reporting for debugging (remove or disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Debugging: Output received parameters
echo "Received id_niveau: " . (isset($_GET['id_niveau']) ? $_GET['id_niveau'] : 'Not provided') . "<br/>";
echo "Received id_filiere: " . (isset($_GET['id_filiere']) ? $_GET['id_filiere'] : 'Not provided') . "<br/>";

// Check if necessary parameters are provided
if (empty($_GET['id_niveau']) || empty($_GET['id_filiere'])) {
    echo "Error: No Filiere ID or Niveau ID provided or incorrect.<br/>";
    exit; // Stop further execution if required data is missing
}

$id_niveau = $_GET['id_niveau'];
$id_filiere = $_GET['id_filiere'];

try {
    // Prepare and execute the deletion query
    $query = $pdo->prepare("DELETE FROM niveau WHERE id_niveau = ? AND id_filiere = ?");
    $query->execute([$id_niveau, $id_filiere]);

    // Check how many rows were affected by the deletion
    $affectedRows = $query->rowCount();
    if ($affectedRows > 0) {
        echo "Deleted $affectedRows rows. Redirecting to details page...<br/>";
        // Redirect to detailfiliere.php with a success message
        header("Refresh: 5; url=detailfiliere.php?success=deleted");
    } else {
        echo "No rows deleted. Redirecting back...<br/>";
        // Redirect back with an error message if no rows were affected
        header("Refresh: 5; url=detailfiliere.php?error=nothing_deleted");
    }
} catch (PDOException $e) {
    // Output error message if an exception occurs
    echo "Database error: " . $e->getMessage() . "<br/>";
}
?>
