<?php
require_once('identifier.php');
require_once('connection_db.php');

$iduser = $_SESSION['iduser'] ?? 1;  // Use session user ID with a fallback to 1 if not set

// Check if the request is POST and required fields are provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['old_password'], $_POST['new_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    try {
        // Fetch current password
        $sql = "SELECT password FROM Utilisateur WHERE iduser = :iduser";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':iduser', $iduser);
        $stmt->execute();
        $user = $stmt->fetch();

        // Check if the MD5 hash of the provided old password matches the stored hash
        if ($user && $user['password'] === md5($old_password)) {
            $hashedPassword = md5($new_password);  // Hash the new password with MD5

            // Update SQL query to set the new MD5 hashed password
            $sql = "UPDATE Utilisateur SET password = :password WHERE iduser = :iduser";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':iduser', $iduser);

            if ($stmt->execute()) {
                header("Location: Profile.php?success=password_updated");
                exit();
            } else {
                echo "Failed to update password. Please try again later.";
            }
        } else {
            echo "Old password does not match our records.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();  // Handle errors more securely, especially in production
    }
} else {
    echo "Please provide both old and new passwords.";
}
?>
