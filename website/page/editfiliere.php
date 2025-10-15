<?php
require_once('identifier.php');
require_once('connection_db.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fetch all departments for the dropdown
$sqlAllDeps = "SELECT id_dep, nom_dep FROM departement";
$stmtAllDeps = $pdo->query($sqlAllDeps);
$departments = $stmtAllDeps->fetchAll(PDO::FETCH_ASSOC);

// Check if id_filiere is provided in the URL
if(isset($_GET['id_filiere'])) {
    $id_filiere = trim($_GET['id_filiere']); // Trim spaces just in case

    try {
        // Prepare the SQL statement to select the faculty from the Filiere table
        $sql = "SELECT * FROM Filiere WHERE id_filiere = :id_filiere";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id_filiere', $id_filiere, PDO::PARAM_INT);
        $statement->execute();

        // Check if the fetch was successful
        if($statement->rowCount() > 0) {
            $filiere = $statement->fetch(PDO::FETCH_ASSOC);
            $nom_filiere = $filiere['nom_filiere'];
            $current_id_dep = $filiere['id_dep']; // Get current department id
        } else {
            echo "No filière found with id: " . htmlspecialchars($id_filiere);
            exit;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }
} else {
    echo "id_filiere parameter is missing.";
    exit;
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Edition d'une filière</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
</head>
<body>
    <?php include("menu.php"); ?>

    <div class="container mt-5 " style="margin-top :60px;">
        <div class="card border-primary"  style="margin-top :60px;">
            <div class="card-header bg-primary text-white">Edition de la filière :</div>
            <div class="card-body">
                <form method="post" action="updateFiliere.php">
                    <div class="mb-3">
                        <label for="id_filiere" class="form-label">ID de la filière:</label>
                        <input type="hidden" id="id_filiere" name="id_filiere" value="<?php echo htmlspecialchars($id_filiere); ?>" readonly>
                        <p><?php echo htmlspecialchars($id_filiere); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="nom_filiere" class="form-label">Nom de la filière:</label>
                        <input type="text" id="nom_filiere" name="nom_filiere" value="<?php echo htmlspecialchars($nom_filiere); ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="id_dep" class="form-label">Département:</label>
                        <select id="id_dep" name="id_dep" class="form-control">
                            <?php foreach ($departments as $dep): ?>
                                <option value="<?php echo $dep['id_dep']; ?>" <?php if ($dep['id_dep'] == $current_id_dep) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($dep['nom_dep']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
