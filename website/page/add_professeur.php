<?php 

require_once('identifier.php');

?>

<!DOCTYPE HTML>
<HTML>
<head>
    <meta charset="utf-8"> 
    <title>Ajouter un nouvel professeur</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">

    <style>
        /* You can add your custom styles here */
    </style>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5" style="margin-top :60px;">
        <div class="card border-primary mb-3" style="margin-top :60px;">
            <div class="card-header bg-primary text-white">Ajouter un nouvel Professeur</div>
            <div class="card-body">
                <form method="post" action="updateprofesseur.php">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" name="nom" placeholder="Nom de Professeur" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" name="prenom" placeholder="Prénom de Professeur" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        Ajouter Professeur
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</HTML>
