<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"> 
    <title>Se Connecter - Etudiant</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monstyle.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background-image: url('http://localhost/gestion_website/img/home2.jpeg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Prevents scrolling */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            position: absolute;
            top: -60px;
            left: -122px;
            width: 600px; /* Adjust size as needed */
            height: auto;
            z-index: 10;
        }

        .auth-panel {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            opacity: 0.95;
            transition: all 0.3s ease-in-out;
            max-width: 400px;
            width: 100%;
            padding: 20px;
        }
        .auth-panel:hover {
            transform: translateY(-5px);
            opacity: 1;
            box-shadow: 0 12px 35px rgba(0,0,0,0.4);
        }
        .auth-heading {
            background: #337ab7;
            color: #fff;
            padding: 10px;
            font-size: 1.5rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            text-align: center;
        }
        .btn-primary, .btn-secondary {
            background-color: #337ab7;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 48%;
        }
        .btn-primary:hover, .btn-secondary:hover {
            background-color: #7a90c2;
            transform: scale(1.05);
        }
        .form-control {
            height: 50px;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(51, 122, 183, 0.5);
            outline: none;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }
        label {
            color: #7a90c2;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        .button-container a{
            font-size: 14px !important;padding: padding:5px;
        }
        .button-container button{
            font-size: 14px !important;padding: padding:5px;
        }
    </style>
</head>
<body>
    <img src="http://localhost/gestion_website/img/fsac330.png" alt="Website Logo" class="logo"> 
    <div class="container mt-5">
        <div class="card auth-panel">
            <div class="card-header auth-heading">Se Connecter - Etudiant</div>
            <div class="card-body">
                <!-- Login Form -->
                <form method="post" action="SeConnecterEtudiant.php">
                    <?php
                    session_start();
                    if (isset($_SESSION['erreurLogin'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreurLogin'] . '</div>';
                        unset($_SESSION['erreurLogin']); // Clear only the error message from the session
                    }
                    ?>
                    <div class="form-group">
                        <label for="login">Login :</label>
                        <input type="text" id="login" name="login" placeholder="Login" class="form-control" autocomplete="off"/>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot De Passe:</label>
                        <input type="password" id="pwd" name="pwd" placeholder="Mot De Passe" class="form-control">
                    </div>
                    <div class="button-container w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-arrow-right"></i> Se Connecter
                        </button>
                        <a href="activate_account.php" class="btn btn-secondary fs-6">
                            <i class="bi bi-pencil-square"></i> Activer Compte
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- JavaScript for dynamic effects like real-time validation or animations -->
    <script>
        document.querySelector('input[type="password"]').addEventListener('input', function() {
            if(this.value.length > 0) {
                this.nextElementSibling.style.display = 'block';
            } else {
                this.nextElementSibling.style.display = 'none';
            }
        });
    </script>
</body>
</html>
