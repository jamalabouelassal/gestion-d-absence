<?php
require_once('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE Professeur SET email = ? WHERE code = ?");
    if ($stmt->execute([$email, $code])) {
        header('Location: professor_dashboard.php?update=success');
    } else {
        header('Location: professor_dashboard.php?update=failure');
    }
}
?>
