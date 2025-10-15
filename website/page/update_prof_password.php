<?php
require_once('connection_db.php');

if (isset($_POST['profId']) && isset($_POST['newPassword'])) {
    $profId = $_POST['profId'];
    $newPassword = $_POST['newPassword'];

    // Hash the new password before saving it
    $hashedPassword = md5($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $pdo->prepare("UPDATE Professeur SET password = ? WHERE code = ?");
    if ($stmt->execute([$hashedPassword, $profId])) {
        echo "Password updated successfully.";
    } else {
        echo "Failed to update password.";
    }
} else {
    echo "Required data not provided.";
}
?>
