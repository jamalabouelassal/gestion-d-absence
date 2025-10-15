<?php require_once('identifier.php'); ?>
<!DOCTYPE HTML>
<HTML>
<head>
    <meta charset="utf-8"> 
    <title>Matière qui enseigne les professeurs</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <div class="card border-primary mb-3 rounded-3">
            <div class="card-header bg-primary text-white">Ajouter une nouvelle matière</div>
            <div class="card-body">
                <form method="post" action="updateprofesseurmatiere.php">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code:</label>
                        <input type="text" name="code" id="code" placeholder="Code du Professeur" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="matiere" class="form-label">Matière:</label>
                        <input type="text" name="matiere" id="matiere" placeholder="Matière qui enseigne" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Ajouter matière
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</HTML>
