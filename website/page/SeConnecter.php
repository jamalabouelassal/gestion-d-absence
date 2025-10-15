<?php
session_start();
require_once('connection_db.php');

$login = isset($_POST['login']) ? trim($_POST['login']) : "";
$pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : "";

// Query for professors
$professorQuery = $pdo->prepare("SELECT code, nom,  prenom FROM Professeur WHERE nom = :login AND password = MD5(:pwd)");
$professorQuery->execute([':login' => $login, ':pwd' => $pwd]);

if ($professor = $professorQuery->fetch()) {
    // Successful login as professor
    $_SESSION['user'] = $professor;
    header('location:professor_dashboard.php');
    exit(); // Ensure no further code is executed after redirect
} else {
    // Query for students
    $studentQuery = $pdo->prepare("SELECT code, nom, prenom, niveau, photo FROM Etudiant WHERE nom = :login AND password = MD5(:pwd)");
    $studentQuery->execute([':login' => $login, ':pwd' => $pwd]);

    if ($student = $studentQuery->fetch()) {
        // Successful login as student
        $_SESSION['user'] = $student;
        header('location:Etudiantdashboard.php');
        exit(); // Ensure no further code is executed after redirect
    } else {
        // If not a professor or a student, check if it's a general user
        $userQuery = $pdo->prepare("SELECT iduser, login, email, etat FROM Utilisateur WHERE login = :login AND password = MD5(:pwd)");
        $userQuery->execute([':login' => $login, ':pwd' => $pwd]);

        if ($user = $userQuery->fetch()) {
            if ($user['etat'] == 1) {
                $_SESSION['user'] = $user;
                header('location:../index.php');
                exit(); // Ensure no further code is executed after redirect
            } else {
                $_SESSION['erreurLogin'] = "<strong>Erreur!!</strong> Votre compte est désactivé.<br> Veuillez contacter l'administrateur";
                header('location:login.php');
                exit(); // Ensure no further code is executed after redirect
            }
        } else {
            // Login failed for professor, student, and general user
            $_SESSION['erreurLogin'] = "<strong>Erreur!!</strong> Login ou mot de passe incorrect!";
            header('location:login.php');
            exit(); // Ensure no further code is executed after redirect
        }
    }
}
?>
