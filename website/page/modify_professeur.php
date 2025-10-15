<?php
require_once('identifier.php');
require_once('connection_db.php');

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    try {
        $sql = "SELECT * FROM professeur WHERE code = :code";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':code', $code);
        $statement->execute();
        $prof = $statement->fetch(PDO::FETCH_ASSOC);

        $sqlNiveau = "SELECT niveau FROM ProfesseurNiveau WHERE prof_id = :code";
        $statementNiveau = $pdo->prepare($sqlNiveau);
        $statementNiveau->bindParam(':code', $code);
        $statementNiveau->execute();
        $currentNiveaux = $statementNiveau->fetchAll(PDO::FETCH_COLUMN);

        $sqlMatiere = "SELECT matiere FROM ProfesseurNiveau WHERE prof_id = :code";
        $statementMatiere = $pdo->prepare($sqlMatiere);
        $statementMatiere->bindParam(':code', $code);
        $statementMatiere->execute();
        $currentMatieres = $statementMatiere->fetchAll(PDO::FETCH_COLUMN);

    } catch (PDOException $e) {
        header("Location: professeur.php?error=1");
        exit();
    }
} else {
    header("Location: professeur.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Modifier un Professeur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">Modifier un Professeur</div>
            <div class="card-body">
                <form method="post" action="update_edit_professeur.php">
                    <input type="hidden" name="code" value="<?php echo htmlspecialchars($prof['code']); ?>">

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" name="nom" value="<?php echo htmlspecialchars($prof['nom']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" name="prenom" value="<?php echo htmlspecialchars($prof['prenom']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Niveaux qui enseigne:</label>
                        <ul class="list-group">
                            <?php foreach ($currentNiveaux as $niveau): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($niveau); ?>
                                    <a href="update_edit_professeur.php?action=remove_niveau&code=<?php echo htmlspecialchars($code); ?>&niveau=<?php echo htmlspecialchars($niveau); ?>" class="btn btn-danger btn-sm">Remove</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Matières qui enseigne:</label>
                        <ul class="list-group">
                            <?php foreach ($currentMatieres as $matiere): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($matiere); ?>
                                    <a href="update_edit_professeur.php?action=remove_matiere&code=<?php echo htmlspecialchars($code); ?>&matiere=<?php echo htmlspecialchars($matiere); ?>" class="btn btn-danger btn-sm">Remove</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                   

                    <button type="submit" class="btn btn-primary">Modifier Professeur</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
