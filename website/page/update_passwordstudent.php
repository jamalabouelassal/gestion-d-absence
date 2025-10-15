<?php
session_start();
require_once('connection_db.php');

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

$etudiant_code = $_SESSION['user']['code'];
$new_password = $_POST['new_password'];

// Hash le nouveau mot de passe avant de l'enregistrer
$hashedPassword = MD5($new_password, PASSWORD_DEFAULT);

// Mise à jour du mot de passe dans la base de données
$stmt = $pdo->prepare("UPDATE Etudiant SET password = ? WHERE code = ?");
if ($stmt->execute([$hashedPassword, $etudiant_code])) {
    echo "Password updated successfully.";
    // Rediriger vers le tableau de bord ou afficher un message de succès
    header("Location: Etudiantdashboard.php?password_update=success");
} else {
    echo "Failed to update password.";
}
?>
