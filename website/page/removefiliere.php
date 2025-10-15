<?php
require_once('identifier.php');
require_once('connection_db.php');

// Ensure the 'idfiliere' GET parameter is retrieved correctly without any spaces
$code = isset($_GET['idfiliere']) ? $_GET['idfiliere'] : 0;

// If $code is 0, redirect back since no valid id was provided
if ($code == 0) {
    header('Location: Filiere.php?error=nocodeprovided');
    exit();
}

// Prepare and execute the DELETE statement
$requete = "DELETE FROM Filiere WHERE id_filiere = ?";
$params = array($code);
$resultat = $pdo->prepare($requete);
$resultat->execute($params);

// Redirect back to the Filiere.php page
header('Location: Filiere.php?success=deletion');
exit();
?>
