<?php
require_once('identifier.php');
require_once('connection_db.php');

$nomf = isset($_GET['fname']) ? $_GET['fname'] : "";
$code = isset($_GET['code']) ? $_GET['code'] : "";
$sex = isset($_GET['sex']) ? $_GET['sex'] : "all";
$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : "";

function fetchDistinctNiveau($pdo) {
    try {
        $stmt = $pdo->query("SELECT DISTINCT niveau FROM Etudiant ORDER BY niveau");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("<p>Error fetching niveau options: " . $e->getMessage() . "</p>");
    }
}

function fetchEtudiants($pdo, $nomf, $code, $sex, $niveau) {
    $params = [];
    $sql = "SELECT * FROM Etudiant WHERE 1=1";
    if (!empty($nomf)) {
        $sql .= " AND (nom LIKE ? OR prenom LIKE ?)";
        array_push($params, "%$nomf%", "%$nomf%");
    }
    if ($code !== "all" && !empty($code)) {
        $sql .= " AND code = ?";
        array_push($params, $code);
    }
    if ($sex !== "all") {
        $sql .= " AND sex = ?";
        array_push($params, $sex);
    }
    if (!empty($niveau)) {
        $sql .= " AND niveau = ?";
        array_push($params, $niveau);
    }

    try {
        $query = $pdo->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    } catch (Exception $e) {
        die("<p>Error fetching students: " . $e->getMessage() . "</p>");
    }
}

$niveauOptions = fetchDistinctNiveau($pdo);
$etudiants = fetchEtudiants($pdo, $nomf, $code, $sex, $niveau);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Etudiants</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monstyle.css">
    <style>
        .img-circle { border-radius: 50%; }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="card border-primary"style="margin-top :60px;">
            <div class="card-header bg-primary text-white">Recherche des Etudiants</div>
            <div class="card-body">
                <form method="get" action="listEtudiants.php" class="row g-3">
                    <div class="col-auto"><input type="text" placeholder="Enter your first and last name" name="fname" class="form-control" value="<?php echo htmlspecialchars($nomf); ?>"></div>
                    <div class="col-auto"><input type="text" placeholder="Enter your Apogée code" name="code" class="form-control" value="<?php echo htmlspecialchars($code); ?>"></div>
                    <div class="col-auto">
                        <select class="form-select" name="sex" id="sex">
                            <option value="all" <?php echo $sex === 'all' ? 'selected' : ''; ?>>All</option>
                            <option value="F" <?php echo $sex === 'F' ? 'selected' : ''; ?>>F</option>
                            <option value="M" <?php echo $sex === 'M' ? 'selected' : ''; ?>>M</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="niveau" id="niveau">
                            <option value="">Select Niveau</option>
                            <?php foreach ($niveauOptions as $option) { ?>
                            <option value="<?php echo htmlspecialchars($option['niveau']); ?>" <?php echo $niveau === $option['niveau'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($option['niveau']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-auto"><button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button></div>
                    <div class="col-auto"><a href="nouvelleETUDIANT.php" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter Etudiant</a></div>
                </form>
                <form method="post" enctype="multipart/form-data" action="import_etudiants.php" class="mt-3">
                    <div class="input-group">
                        <input type="file" name="csv_file" class="form-control">
                        <button class="btn btn-primary" type="submit">Importer CSV</button>
                    </div>
                </form>
            </div>
        </div>

        <h2 class="mt-5">Etudiants in Niveau: <?php echo htmlspecialchars($niveau); ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($etudiant['code']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['nom']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['sex']); ?></td>
                    <td><img src="../img/<?php echo htmlspecialchars($etudiant['photo']); ?>" width="50px" height="50px" class="img-circle"></td>
                    <td>
                        <a href="details_etudiant.php?code=<?php echo htmlspecialchars($etudiant['code']); ?>" class="btn btn-info"><i class="fas fa-info-circle"></i> Détails</a>
                        <a href="editetudiant.php?code=<?php echo htmlspecialchars($etudiant['code']); ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Modifier</a>
                        <a onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')" href="removeetudiants.php?code=<?php echo htmlspecialchars($etudiant['code']); ?>" class="btn btn-danger"><i class="fas fa-trash"></i> Supprimer</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>