<?php
require_once('connection_db.php');

if (isset($_POST['studentId']) && isset($_POST['newPassword'])) {
    $studentId = $_POST['studentId'];
    $newPassword = $_POST['newPassword'];

    // Hash the new password before saving it
    $hashedPassword = md5($newPassword);  // Note: It's generally recommended to use password_hash instead of md5 for security reasons.

    // Update the password in the database
    $stmt = $pdo->prepare("UPDATE Etudiant SET password = ? WHERE code = ?");
    if ($stmt->execute([$hashedPassword, $studentId])) {
        echo "Password updated successfully.";
    } else {
        echo "Failed to update password.";
    }
} else {
    echo "Required data not provided.";
}
?>
