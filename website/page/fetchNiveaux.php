<?php
require_once('identifier.php');
require_once('connection_db.php');

$departement = isset($_GET['departement']) ? $_GET['departement'] : "";
$filiere = isset($_GET['filiere']) ? $_GET['filiere'] : "";

$query = "SELECT DISTINCT niveau FROM Filiere WHERE departement = ? AND nomfiliere = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$departement, $filiere]);
$niveaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($niveaux);
?>