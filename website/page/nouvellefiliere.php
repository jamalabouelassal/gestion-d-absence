<?php 
require_once('identifier.php');
require_once('connection_db.php'); 

// Query to retrieve departments directly from the `departement` table
$query = "SELECT id_dep, nom_dep FROM departement ORDER BY nom_dep";
$statement = $pdo->prepare($query);
$statement->execute();
$departements = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"> 
    <title>Nouvelle filière</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstylenouvelle.css">
</head>
<body>
    <?php include("menu.php"); ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Ajout d'une filière</div>
            <div class="card-body">
                <form method="post" action="insertFiliere.php">
                    <div class="mb-3">
                        <label for="fname" class="form-label">Nom de la filière:</label>
                        <input type="text" id="fname" name="fname" placeholder="Entrer le nom de votre filière" class="form-control" />
                    </div>
                    
                    <div class="mb-3">
                        <label for="departement" class="form-label">Département:</label>
                        <select id="departement" name="departement" class="form-select">
                            <?php foreach ($departements as $departement) { ?>
                                <option value="<?= $departement['id_dep'] ?>">
                                    <?= htmlspecialchars($departement['nom_dep']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
