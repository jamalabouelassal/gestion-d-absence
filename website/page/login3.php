<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Andev web - Valider le Formulaire</title>
    <link rel="stylesheet" href="../css/stylelogin.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>
<body>
    <div class="container" id="container">
      <div class="form-container register-container">
        <form id="registerForm" method="POST" action="activate_account_process.php">
           <!-- Add your logo here -->
          <h1>Activez Votre Compte</h1>
          <div class="form-control">
            <input type="text" id="code" name="code" placeholder="Entrez votre code Apogée" required />
            <small id="code-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="text" id="nom" name="nom" placeholder="Nom de famille" required />
            <small id="nom-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required />
            <small id="prenom-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="text" id="cin" name="cin" placeholder="CIN" required />
            <small id="cin-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="email" id="email" name="email" placeholder="Nouvel Email" required />
            <small id="email-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="password" id="password" name="password" placeholder="Nouveau Mot de Passe" required />
            <small id="password-error"></small>
            <span></span>
          </div>
          <button type="submit" value="submit">Activer</button>
          <div id="activationMessage"></div>
        </form>
      </div>

      <div class="form-container login-container">
        <form class="form-lg" method="post" action="SeConnecterEtudiant.php">
          <!-- Add your logo here -->
          <h1>Connexion Étudiant</h1>
          <?php
          session_start();
          if (isset($_SESSION['erreurLogin'])) {
              echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreurLogin'] . '</div>';
              unset($_SESSION['erreurLogin']);
          }
          ?>
          <div class="form-control2">
            <input type="text" id="login" name="login" placeholder="Identifiant" autocomplete="off"/>
            <small class="login-error-2"></small>
            <span></span>
          </div>
          <div class="form-control2">
            <input type="password" id="loginPassword" name="pwd" placeholder="Mot de Passe">
            <small class="password-error-2"></small>
            <span></span>
          </div>
          <div class="content">
            <div class="checkbox">
              <input type="checkbox" name="checkbox" id="checkbox" />
              <label for="checkbox">Se souvenir de moi</label>
            </div>
            <div class="pass-link">
              <a href="#">Mot de passe oublié?</a>
            </div>
          </div>
          <button type="submit" value="submit">Connexion</button>
        </form>
      </div>

      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <img src="../img/FSAC LOGO.png" alt="Logo" class="logo"> <!-- Add your logo here -->
            <h1 class="title">
              Bonjour <br />
              les amis
            </h1>
            <p>Si vous avez un compte, connectez-vous ici et amusez-vous</p>
            <button class="ghost" id="loga">
              Se Connecter
              <i class="fa-solid fa-arrow-left"></i>
            </button>
          </div>

          <div class="overlay-panel overlay-right">
            <img src="../img/FSAC LOGO.png" alt="Logo" class="logo"> <!-- Add your logo here -->
            <h1 class="title">
              Commencez votre <br />
              aventure maintenant
            </h1>
            <p>
              Si vous n'avez pas encore de compte, rejoignez-nous et commencez votre aventure
            </p>
            <button class="ghost" id="register">
              S'inscrire
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>
