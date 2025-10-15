<?php
session_start();
require_once('connection_db.php');

$login = isset($_POST['login']) ? trim($_POST['login']) : "";
$pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : "";

// Query for professors
$professorQuery = $pdo->prepare("SELECT code, nom, prenom FROM Professeur WHERE CONCAT(nom, '.', prenom) = :login AND password = MD5(:pwd)");
$professorQuery->execute([':login' => $login, ':pwd' => $pwd]);


if ($professor = $professorQuery->fetch()) {
    // Successful login as professor
    $_SESSION['user'] = $professor;
    header('location:professor_dashboard.php');
    exit(); // Ensure no further code is executed after redirect
} else {
    // Query for admins
    $adminQuery = $pdo->prepare("SELECT iduser, nom, prenom FROM Utilisateur WHERE CONCAT(nom, '.', prenom) = :login AND password = MD5(:pwd) ");
    $adminQuery->execute([':login' => $login, ':pwd' => $pwd]);

    if ($admin = $adminQuery->fetch()) {
        // Successful login as admin
        $_SESSION['user'] = $admin;
        header('location:dashboard.php');
        exit(); // Ensure no further code is executed after redirect
    } else {
        // Login failed for both professor and admin
        $_SESSION['erreurLogin'] = "<strong>Erreur!!</strong> Login ou mot de passe incorrect!";
        header('location:login1.php');
        exit(); // Ensure no further code is executed after redirect
    }
}
?>
