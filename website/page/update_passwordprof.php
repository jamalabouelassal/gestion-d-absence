<?php
require_once('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Fetch the current password from the database
    $stmt = $pdo->prepare("SELECT password FROM Professeur WHERE code = ?");
    $stmt->execute([$code]);
    $professor = $stmt->fetch();

    // Verify the old password
    if ($professor && md5($old_password) === $professor['password']) {
        // Update the password
        $new_password_hashed = md5($new_password);
        $stmt = $pdo->prepare("UPDATE Professeur SET password = ? WHERE code = ?");
        if ($stmt->execute([$new_password_hashed, $code])) {
            header('Location: professor_dashboard.php?update=success');
        } else {
            header('Location: professor_dashboard.php?update=failure');
        }
    } else {
        header('Location: professor_dashboard.php?update=failure');
    }
}
?>
