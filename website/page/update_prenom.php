<?php
require_once('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $prenom = $_POST['prenom'];

    $stmt = $pdo->prepare("UPDATE Professeur SET prenom = ? WHERE code = ?");
    if ($stmt->execute([$prenom, $code])) {
        header('Location: professor_dashboard.php?update=success');
    } else {
        header('Location: professor_dashboard.php?update=failure');
    }
}
?>