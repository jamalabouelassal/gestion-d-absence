<?php
session_start();
require_once('connection_db.php');

$login = isset($_POST['login']) ? trim($_POST['login']) : "";
$pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : "";

// Query for students
$studentQuery = $pdo->prepare("SELECT code, nom, prenom, niveau, photo, etat, cin FROM Etudiant WHERE CONCAT(nom, '.', prenom) = :login AND password = MD5(:pwd)");
$studentQuery->execute([':login' => $login, ':pwd' => $pwd]);

if ($student = $studentQuery->fetch()) {
    if ($student['etat'] == 1) {
        // Successful login as active student
        $_SESSION['user'] = $student;
        header('location:Etudiantdashboard.php');
        exit();
    } else {
        // Student exists but account is inactive, show activation form
        $_SESSION['inactive_user'] = $student; // Store student data for activation
        header('location:activate_account.php');
        exit();
    }
} else {
    $_SESSION['erreurLogin'] = "<strong>Erreur!!</strong> Login ou mot de passe incorrect!";
    header('location:login3.php');
    exit();
}
?>
