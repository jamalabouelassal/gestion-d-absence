<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('connection_db.php');

// Assume data comes directly from the form
$code = isset($_POST['code']) ? trim($_POST['code']) : '';
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
$cin = isset($_POST['cin']) ? trim($_POST['cin']) : '';
$new_email = isset($_POST['email']) ? trim($_POST['email']) : '';
$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($code && $new_email && $new_password) { // Minimal check to ensure form was submitted
    try {
        // First, check the current state of the account
        $checkQuery = $pdo->prepare("SELECT etat FROM Etudiant WHERE code = ?");
        $checkQuery->execute([$code]);
        $result = $checkQuery->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['etat'] == 1) {
            echo "Account is already active and cannot be activated again.";
            exit;
        }

        $hashed_password = md5($new_password, PASSWORD_DEFAULT);

        $pdo->beginTransaction();
        $updateQuery = $pdo->prepare("UPDATE Etudiant SET email = ?, password = ?, etat = 1 WHERE code = ?");
        $success = $updateQuery->execute([$new_email, $hashed_password, $code]);

        if ($updateQuery->rowCount() > 0) {
            $pdo->commit();
            echo "Account activated successfully.";
            
        } else {
            $pdo->rollBack();
            echo "No changes were made to the database. Please check your details.";
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error during the update: " . $e->getMessage();
    }
} else {
    echo "Please fill all required fields.";
}
?>
