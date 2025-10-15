<?php
require_once('identifier.php');
require_once('connection_db.php');

$iduser = $_SESSION['iduser'] ?? 1; // Use session user ID, fallback to 1 if not set

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && !empty(trim($_POST['username']))) {
    $username = trim($_POST['username']); // Trim spaces and sanitize

    try {
        // Update SQL query
        $sql = "UPDATE Utilisateur SET login = :username WHERE iduser = :iduser";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':iduser', $iduser);

        if ($stmt->execute()) {
            // Redirect to profile page if update was successful
            header("Location: Profile.php?success=username_updated");
            exit(); // Ensure no further execution
        } else {
            echo "Failed to update username.";
        }
    } catch (PDOException $e) {
        // Handle SQL errors safely
        echo "Error updating username: " . $e->getMessage();
    }
} else {
    echo "Invalid request or no username provided.";
}
?>
