<?php
require_once('identifier.php');
require_once('connection_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Usual update code...
} elseif (isset($_GET['action']) && $_GET['action'] == 'remove_niveau' && isset($_GET['code']) && isset($_GET['niveau'])) {
    $code = $_GET['code'];
    $niveau = $_GET['niveau'];

    try {
        $sql = "DELETE FROM ProfesseurNiveau WHERE prof_id = :code AND niveau = :niveau";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':code', $code);
        $statement->bindParam(':niveau', $niveau);
        $statement->execute();

        header("Location: modify_professeur.php?code=$code&success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: modify_professeur.php?code=$code&error=1&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: professeur.php");
    exit();
}
?>
