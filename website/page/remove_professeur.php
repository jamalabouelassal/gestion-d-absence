<?php


require_once('identifier.php');

// Include the database connection file
require_once('connection_db.php');
$code=isset($_GET['code'])?$_GET['code']:0;

$requete="DELETE from professeur where code=?";
$params=array($code);
$resultat=$pdo->prepare($requete);
$resultat->execute($params);


header('location:professeur.php');



?>