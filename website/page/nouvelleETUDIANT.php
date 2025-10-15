<?php
require_once('identifier.php');
require_once('connection_db.php');

// Fetching available filieres
$queryFilieres = $pdo->prepare("SELECT idfiliere, nomfiliere FROM Filiere");
$queryFilieres->execute();
$filieres = $queryFilieres->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"> 
    <title>Ajouter un nouvel étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">Ajouter un nouvel étudiant</div>
            <div class="card-body">
                <form method="post" action="addEtudiant.php">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" name="nom" placeholder="Nom de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" name="prenom" placeholder="Prénom de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="niveau" class="form-label">Niveau:</label>
                        <input type="text" name="niveau" placeholder="Niveau de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="sexe" class="form-label">Sexe:</label>
                        <input type="text" name="sexe" placeholder="Sexe de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date de naissance:</label>
                        <input type="text" name="date" placeholder="Date de naissance de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lieu" class="form-label">Lieu de naissance:</label>
                        <input type="text" name="lieu" placeholder="Lieu de naissance de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cin" class="form-label">CIN:</label>
                        <input type="text" name="cin" placeholder="CIN de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Password:</label>
                        <input type="password" name="pwd" placeholder="Mot de passe de l'étudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo:</label>
                        <input type="text" name="photo" placeholder="URL de la photo de l'étudiant" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="filiere" class="form-label">Filiere:</label>
                        <select name="idfiliere" class="form-control" required>
                            <?php foreach ($filieres as $filiere): ?>
                                <option value="<?php echo htmlspecialchars($filiere['idfiliere']); ?>"><?php echo htmlspecialchars($filiere['nomfiliere']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Ajouter étudiant
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
