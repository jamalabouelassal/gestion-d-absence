<?php
session_start();

if(!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

require_once('connection_db.php');

$stmt = $pdo->query("SELECT COUNT(*) FROM Etudiant");
$studentCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM Filiere");
$filiereCount = $stmt->fetchColumn();
?>

<!DOCTYPE HTML>
<HTML>
<head>
    <meta charset="utf-8"> 
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Add this for responsiveness -->
    <link rel="stylesheet" type="text/css" href="../css/monstyleinput.css">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="container-fluid mt-4 margetop">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 margetop">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" aria-current="true" style="background-color: #337ab7; border-color: #337ab7;">
                        Quick Access
                    </a>
                    <a href="Professeur.php" class="list-group-item list-group-item-action">Professeur</a>
                    <a href="filiere.php" class="list-group-item list-group-item-action">Departments</a>
                </div>
            </div>
            <div class="col-lg-8 col-md-9 col-sm-8 margetop">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="studentChart" style="width:100%; height: 400px;"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="departmentChart" style="width:100%; height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 margetop">
                <div class="bg-light border rounded-3 p-3">
                    <h4>Upcoming Events</h4>
                    <ul class="list-unstyled">
                        <li>Conference sur la reconnaissance faciale - June 10</li>
                        <li>Alumni Meet - July 15</li>
                        <li>Convocation - June 16</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-3" style="margin-top :60px;">
            <div class="col" style="margin-top :60px;">
                <div class="alert alert-info">
                    <h4 class="alert-heading">Recent Activity</h4>
                    <p>New student enrollments this week: 15</p>
                    <p>Departmental reviews completed: 3</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional scripts for charts -->
    <script>
        var ctx1 = document.getElementById('studentChart').getContext('2d');
        var studentChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['MATHS', 'PHYSIQUE ', 'CHIMIE', 'INFO'],
                datasets: [{
                    label: 'Number of Students by department',
                    data: [20 , 50, 70, 150],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        var ctx2 = document.getElementById('departmentChart').getContext('2d');
        var departmentChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Licence', 'Master', 'Doctorat'],
                datasets: [{
                    label: 'Capacity of students ',
                    data: [200, 150, 50],
                    backgroundColor: ['red', 'blue', 'green']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</HTML>
