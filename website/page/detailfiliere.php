<?php
require_once('identifier.php');
require_once('connection_db.php');

$idfiliere = isset($_GET['idfiliere']) ? $_GET['idfiliere'] : "";

if (empty($idfiliere)) {
    echo "<p>No Filiere ID provided or incorrect.</p>";
    return; // Stops further script execution if no ID is provided
}

$queryFiliere = $pdo->prepare("SELECT f.*, d.nom_dep FROM filiere f
                               LEFT JOIN departement d ON f.id_dep = d.id_dep
                               WHERE f.id_filiere = ?");
$queryFiliere->execute([$idfiliere]);
$filiere = $queryFiliere->fetch();

if (!$filiere) {
    echo "<p>Details for the specified filiere could not be found.</p>";
} else {
    $queryNiveaux = $pdo->prepare("SELECT n.nom_niveau, COUNT(e.code) AS student_count 
                                   FROM niveau n
                                   LEFT JOIN etudiant e ON n.id_niveau = e.niveau_id
                                   WHERE n.id_filiere = ?
                                   GROUP BY n.id_niveau, n.nom_niveau
                                   ORDER BY n.nom_niveau");
    $queryNiveaux->execute([$idfiliere]);
    $niveaux = $queryNiveaux->fetchAll();

   
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Détails de la Filière</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5"  >
        <?php if ($filiere): ?>
            <h2 style="margin-top :60px;">Détails de la Filière: <?php echo htmlspecialchars($filiere['nom_filiere']); ?></h2>
            <div class="card">
                <div class="card-header">Informations</div>
                <div class="card-body">
                    <p>Département: <?php echo htmlspecialchars($filiere['nom_dep']); ?></p>
                </div>
            </div>
            <div class="mt-4">
                <h3>Niveaux associés à la filière: <?php echo htmlspecialchars($filiere['nom_filiere']); ?></h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Niveau</th>
                            <th>Student Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($niveaux as $niveau): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($niveau['nom_niveau']); ?></td>
                                <td><?php echo $niveau['student_count']; ?></td>
                                <td>
                                    <a style="background-color: #337ab7; border-color: #337ab7;" href="listEtudiants.php?niveau=<?php echo urlencode($niveau['nom_niveau']); ?>&idfiliere=<?php echo urlencode($idfiliere); ?>" class="btn btn-info">View Students</a>

                                  <a href="deleteNiveau.php?id_niveau=<?php echo urlencode($niveau['id_niveau']); ?>&id_filiere=<?php echo urlencode($niveau['id_filiere']); ?>" class="btn btn-danger" onclick="return testDeletion();">Remove Niveau</a>



                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="mt-3" >
                    <h4>Add New Niveau</h4>
                    <form method="post" action="addNiveau.php" id="addNiveauForm">
                        <input type="hidden" name="idfiliere" value="<?php echo htmlspecialchars($idfiliere); ?>">
                        <input type="text" name="niveau" placeholder="Enter New Niveau" required class="form-control">
                        <button type="submit" class="btn btn-primary mt-2" style="background-color: #337ab7; border-color: #337ab7;">Add Niveau</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <script>
function testDeletion() {
    return confirm('Are you sure you want to delete this niveau?');
}
</script>
    <script>


        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addNiveauForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert('Niveau added successfully!');
                    window.location.reload();
                })
                .catch(error => {
                    alert('Failed to add niveau.');
                });
            });
        });
    </script>
</body>
</html>
