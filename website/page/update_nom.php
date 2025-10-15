
<?php
require_once('connection_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $nom = $_POST['nom'];

    $stmt = $pdo->prepare("UPDATE Professeur SET nom = ? WHERE code = ?");
    if ($stmt->execute([$nom, $code])) {
        header('Location: professor_dashboard.php?update=success');
    } else {
        header('Location: professor_dashboard.php?update=failure');
    }
}
?>