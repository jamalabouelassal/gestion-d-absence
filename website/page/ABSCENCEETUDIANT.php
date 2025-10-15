<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

require_once('connection_db.php');

$student_code = $_SESSION['user']['code'];

// Fetch attendance records from the `attendancee` table for the logged-in student
$query = "SELECT code, matiere, nom, prenom, date, heure, statut, niveau FROM attendancee WHERE code = ?";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$student_code]);
    $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'PDOException: ' . $e->getMessage();
    exit;
}

// Separate records into 'absent' and 'present'
$absent_records = array_filter($attendance_records, function($record) {
    return strtolower($record['statut']) === 'absent';
});
$present_records = array_filter($attendance_records, function($record) {
    return strtolower($record['statut']) === 'present';
});
?>

<?php include('navbar.php'); ?>

<div class="container mt-3">
    <h2>Attendance Records</h2>
    <div class="row mb-3">
        <div class="col-md-2">
            <input type="date" id="dateFilter" class="form-control">
        </div>
        <div class="col-md-2">
            <input type="time" id="heureFilter" class="form-control">
        </div>
        <div class="col-md-2">
            <select id="statutFilter" class="form-control">
                <option value="">All</option>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" id="niveauFilter" class="form-control" placeholder="Niveau">
        </div>
        <div class="col-md-2">
            <input type="text" id="matiereFilter" class="form-control" placeholder="Matière">
        </div>
    </div>

    <!-- Absent Table -->
    <h3>Absent Records</h3>
    <div class="row">
        <div class="scroll-table">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Matiere</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Statut</th>
                        <th>Niveau</th>
                    </tr>
                </thead>
                <tbody id="absentBody">
                    <?php if ($absent_records): ?>
                        <?php foreach ($absent_records as $record): ?>
                            <tr>
                                <td><?= htmlspecialchars($record['code']) ?></td>
                                <td><?= htmlspecialchars($record['matiere']) ?></td>
                                <td><?= htmlspecialchars($record['nom']) ?></td>
                                <td><?= htmlspecialchars($record['prenom']) ?></td>
                                <td><?= htmlspecialchars($record['date']) ?></td>
                                <td><?= htmlspecialchars($record['heure']) ?></td>
                                <td><?= htmlspecialchars($record['statut']) ?></td>
                                <td><?= htmlspecialchars($record['niveau']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No absent records found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Present Table -->
    <h3>Present Records</h3>
    <div class="row">
        <div class="scroll-table">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Matiere</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Statut</th>
                        <th>Niveau</th>
                    </tr>
                </thead>
                <tbody id="presentBody">
                    <?php if ($present_records): ?>
                        <?php foreach ($present_records as $record): ?>
                            <tr>
                                <td><?= htmlspecialchars($record['code']) ?></td>
                                <td><?= htmlspecialchars($record['matiere']) ?></td>
                                <td><?= htmlspecialchars($record['nom']) ?></td>
                                <td><?= htmlspecialchars($record['prenom']) ?></td>
                                <td><?= htmlspecialchars($record['date']) ?></td>
                                <td><?= htmlspecialchars($record['heure']) ?></td>
                                <td><?= htmlspecialchars($record['statut']) ?></td>
                                <td><?= htmlspecialchars($record['niveau']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No present records found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .scroll-table {
        max-height: 200px; /* Adjust this value to fit your design needs */
        overflow-y: auto;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#dateFilter, #heureFilter, #statutFilter, #niveauFilter, #matiereFilter").on("keyup change", function() {
            var dateVal = $("#dateFilter").val();
            var heureVal = $("#heureFilter").val();
            var statutVal = $("#statutFilter").val().toLowerCase();
            var niveauVal = $("#niveauFilter").val().toLowerCase();
            var matiereVal = $("#matiereFilter").val().toLowerCase();

            // Filter the absent table
            $("#absentBody tr").filter(function() {
                $(this).toggle(
                    ($(this).find("td:eq(4)").text() === dateVal || dateVal === "") &&
                    ($(this).find("td:eq(5)").text() === heureVal || heureVal === "") &&
                    ($(this).find("td:eq(6)").text().toLowerCase().indexOf(statutVal) > -1 || statutVal === "") &&
                    $(this).find("td:eq(7)").text().toLowerCase().indexOf(niveauVal) > -1 &&
                    $(this).find("td:eq(1)").text().toLowerCase().indexOf(matiereVal) > -1
                );
            });

            // Filter the present table
            $("#presentBody tr").filter(function() {
                $(this).toggle(
                    ($(this).find("td:eq(4)").text() === dateVal || dateVal === "") &&
                    ($(this).find("td:eq(5)").text() === heureVal || heureVal === "") &&
                    ($(this).find("td:eq(6)").text().toLowerCase().indexOf(statutVal) > -1 || statutVal === "") &&
                    $(this).find("td:eq(7)").text().toLowerCase().indexOf(niveauVal) > -1 &&
                    $(this).find("td:eq(1)").text().toLowerCase().indexOf(matiereVal) > -1
                );
            });
        });
    });
</script>
