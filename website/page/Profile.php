<?php
require_once('identifier.php');
require_once('connection_db.php');

$iduser = 1;
try {
    // Prepare and execute the SQL statement
    $sql = "SELECT login, email FROM Utilisateur WHERE iduser = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':iduser', $iduser);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Assign fetched data to variables
        $username = $user['login'];
        $email = $user['email'];
    } else {
        // Default values if no user is found
        $username = 'default_username';
        $email = 'default_email@example.com';
        echo "No user found with ID = 1.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    // Fallback or default values
    $username = 'error_loading_username';
    $email = 'error_loading_email';
}

$profile_picture = 'http://localhost/gestion_website/img/profile_picture.jpg'; 
$bio = 'Administrator of the platform by order of Ministry of National Education and Higher Education';
$member_since = 'Joined: January 1, 2022';

function getPlaceholderProfilePicture() {
    return 'http://localhost/gestion_website/img/fsacimage.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container mt-5" style="margin-top :60px;">
        <div class="card" style="margin-top :60px;">
            <div class="card-body">
                <img src="<?php echo file_exists($_SERVER['DOCUMENT_ROOT'] . '/gestion_website/img/profile_picture.jpg') ? $profile_picture : getPlaceholderProfilePicture(); ?>" alt="Profile Picture" class="img-thumbnail rounded-circle mx-auto d-block" style="width: 150px; height: 150px;">
                <h5 class="card-title text-center mt-3"><?= htmlspecialchars($username) ?></h5>
                <p class="card-text text-center"><?= htmlspecialchars($email) ?></p>
                <p class="text-center"><?= $member_since ?></p>
                <p class="text-center"><?= $bio ?></p>
                <div class="text-center">
                    <button class="btn btn-primary" onclick="showForm('edit-username')" style="background-color: #337ab7; border-color: #337ab7;">Edit Username</button>
                    <button class="btn btn-primary" onclick="showForm('edit-email')"style="background-color: #337ab7; border-color: #337ab7;">Edit Email</button>
                    <button class="btn btn-primary" onclick="showForm('edit-password')"style="background-color: #337ab7; border-color: #337ab7;">Edit Password</button>
                </div>
                <div id="edit-username" class="form-edit" style="display:none;">
                    <form action="updateusername_profile.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['iduser']; ?>">
                        <input type="text" name="username" placeholder="Enter new username" required class="form-control">
                        <button type="submit" class="btn btn-success mt-2">Update Username</button>
                    </form>
                </div>
                <div id="edit-email" class="form-edit" style="display:none;">
                    <form action="updatemail_profile.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['iduser']; ?>">
                        <input type="email" name="email" placeholder="Enter new email" required class="form-control">
                        <button type="submit" class="btn btn-success mt-2">Update Email</button>
                    </form>
                </div>
                <div id="edit-password" class="form-edit" style="display:none;">
                    <form action="updatepassword_profile.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['iduser']; ?>">
                        <input type="password" name="old_password" placeholder="Enter old password" required class="form-control">
                        <input type="password" name="new_password" placeholder="Enter new password" required class="form-control mt-2">
                        <button type="submit" class="btn btn-success mt-2">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showForm(formId) {
            document.querySelectorAll('.form-edit').forEach(function(form) {
                form.style.display = 'none'; // Hide all forms first
            });
            document.getElementById(formId).style.display = 'block'; // Show the selected form
        }
    </script>
</body>
</html>
