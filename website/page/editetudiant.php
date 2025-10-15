<?php
require_once('identifier.php');

// Include the database connection file
require_once('connection_db.php');

// Check if student code is provcodeed in the URL
if(isset($_GET['code'])) {
    $code = $_GET['code'];

    try {
        // Prepare the SQL statement to select the student from the Etudiant table
        $sql = "SELECT * FROM Etudiant WHERE code = :code";
        $statement = $pdo->prepare($sql);

        // Bind parameter
        $statement->bindParam(':code', $code);

        // Execute the SQL statement
        $statement->execute();

        // Fetch the student record
        $student = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // If an error occurs, redirect back to the page with error message
        header("Location:listEtudiants.php?error=1");
        exit();
    }
} else {
    // If student code is not provcodeed, redirect back to the page
    header("Location:listEtudiants.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"> 
    <title>Modifier un étudiant</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="card border-primary mb-3 rounded-3">
            <div class="card-header bg-primary text-white">Modifier un étudiant</div>
            <div class="card-body">
                <form method="post" action="updateEtudiant.php">
                    <input type="hidden" name="code" value="<?php echo htmlspecialchars($student['code']); ?>">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($student['nom']); ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($student['prenom']); ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex:</label>
                        <input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($student['sex']); ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo:</label>
                        <input type="text" id="photo" name="photo" value="<?php echo htmlspecialchars($student['photo']); ?>" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Modifier étudiant
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
