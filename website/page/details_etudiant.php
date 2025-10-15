<?php
require_once('identifier.php');
require_once('connection_db.php');

function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

// Check if a student ID has been passed via URL
if (isset($_GET['code'])) {
    $id_etudiant = $_GET['code'];

    // Query to retrieve the student's information
    $requete = "SELECT * FROM Etudiant WHERE code = ?";
    $stmt = $pdo->prepare($requete);
    $stmt->execute([$id_etudiant]);
    $etudiant = $stmt->fetch();

    // Query to retrieve the student's attendance records
    $requete_attendance = "SELECT time FROM attendance WHERE code = ?";
    $stmt_attendance = $pdo->prepare($requete_attendance);
    $stmt_attendance->execute([$id_etudiant]);
    $attendance_records = $stmt_attendance->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Code de l'étudiant non fourni.";
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Détails de l'Étudiant</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <?php include("menu.php"); ?>

    <div class="container mt-5" >
        <h2 style="margin-top :60px;">Informations de l'étudiant</h2>
        <table class="table">
            <tr>
                <th>Code</th>
                <td><?php echo htmlspecialchars($etudiant['code']); ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?php echo htmlspecialchars($etudiant['nom']); ?></td>
            </tr>
            <tr>
                <th>Prénom</th>
                <td><?php echo htmlspecialchars($etudiant['prenom']); ?></td>
            </tr>
            <tr>
                <th>Niveau Actuel</th>
                <td><?php echo htmlspecialchars($etudiant['niveau']); ?></td>
            </tr>
            <tr>
                <th>Photo</th>
                <td><img src="<?php echo htmlspecialchars($etudiant['photo']); ?>" alt="Student Photo" class="img-thumbnail"></td>
            </tr>
            <tr>
                <th>Date de naissance</th>
                <td><?php echo htmlspecialchars($etudiant['date_naissance']); ?></td>
            </tr>
            <tr>
                <th>Lieu de naissance</th>
                <td><?php echo htmlspecialchars($etudiant['lieu_naissance']); ?></td>
            </tr>
            <tr>
                <th>CIN</th>
                <td><?php echo htmlspecialchars($etudiant['cin']); ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td>
                    <button class="btn btn-warning" onclick="generatePassword(<?php echo htmlspecialchars($etudiant['code']); ?>)">Generate New Password</button>
                </td>
            </tr>
            <tr>
                <th>Présence</th>
                <td>
                    <ul>
                        <?php foreach ($attendance_records as $attendance): ?>
                            <li><?php echo htmlspecialchars($attendance['time']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
    <script>
    function generatePassword(studentId) {
        var newPassword = '<?= generateRandomPassword(); ?>'; // Server-side generation
        alert("New Password for Student ID " + studentId + ": " + newPassword);

        // Send new password to server for update via AJAX
        $.ajax({
            url: 'updatepassword_etudiant.php',
            type: 'POST',
            data: {
                studentId: studentId,
                newPassword: newPassword
            },
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert('Error updating password');
            }
        });
    }
    </script>
</body>
</html>

