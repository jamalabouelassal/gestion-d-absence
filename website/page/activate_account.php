<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activate Your Account</title>
    <!-- Bootstrap CSS for styling and responsiveness -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-control {
            margin-bottom: 10px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
   <div class="container">
    <h2>Activate Your Account</h2>
    <form method="POST" action="activate_account_process.php">
        <div class="mb-3">
            <label for="code" class="form-label">Code Apogée:</label>
            <input type="text" id="code" name="code" placeholder="Enter your Apogee code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom:</label>
            <input type="text" id="nom" name="nom" placeholder="Nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prenom:</label>
            <input type="text" id="prenom" name="prenom" placeholder="Prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cin" class="form-label">CIN:</label>
            <input type="text" id="cin" name="cin" placeholder="CIN" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">New Email:</label>
            <input type="email" id="email" name="email" placeholder="New Email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password:</label>
            <input type="password" id="password" name="password" placeholder="New Password" class="form-control" required>
        </div>
        <button type="submit" name="activate">Activate</button>
    </form>
</div>
</body>
</html>