<?php
require_once('identifier.php');
require_once('connection_db.php');


$iduser = $_SESSION['iduser'] ?? 1; // Use session user ID with a fallback to 1 if not set

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Update SQL query
    try {
        $sql = "UPDATE Utilisateur SET email = :email WHERE iduser = :iduser";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':iduser', $iduser);

        if ($stmt->execute()) {
            header("Location: Profile.php?success=email_updated");
            exit();
        } else {
            echo "Failed to update email.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "No email provided or invalid request.";
}
?>
