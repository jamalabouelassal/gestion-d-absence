<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
}

require_once('connection_db.php');

// Debug: Check if professor's ID is in the session
if (isset($_SESSION['user'])) {
    $professor_info = $_SESSION['user'];

    // Extract the professor ID
    if (is_array($professor_info) && isset($professor_info['code'])) {
        $professor_id = $professor_info['code'];
    } else {
        echo 'Error: Professor ID not found in session.<br>';
        exit();
    }
} else {
    echo 'Error: Professor info not found in session.<br>';
    exit();
}

// Fetch the professor's matiere
$matiere_query = "SELECT matiere FROM professeurniveau WHERE prof_id = :prof_id";
try {
    $stmt = $pdo->prepare($matiere_query);
    $stmt->bindParam(':prof_id', $professor_id, PDO::PARAM_INT);
    $stmt->execute();
    $professor_matiere = $stmt->fetchColumn();
    if (!$professor_matiere) {
        echo 'No subject found for this professor.<br>';
        exit();
    }
} catch (PDOException $e) {
    echo 'PDOException: ' . $e->getMessage() . '<br>';
    exit;
}

// Fetch attendance records for the professor's matiere
$query = "SELECT code, matiere, nom, prenom, date, heure, statut, niveau FROM attendancee WHERE matiere = :matiere";
try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':matiere', $professor_matiere, PDO::PARAM_STR);
    $stmt->execute();
    $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'PDOException: ' . $e->getMessage() . '<br>';
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

<!DOCTYPE HTML>
<HTML>
<head>
    <meta charset="utf-8"> 
    <title>Reconnaissance faciale </title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .scroll-table {
            max-height: 200px; /* Adjust this value to fit your design needs */
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <?php include('navprof.php'); ?>

    <div class="container mt-3">
        <h2 style="margin-top: 60px;">Attendance Records</h2>
        <div class="row mb-3">
            <div class="col-md-2">
                <input type="text" id="codeFilter" class="form-control" placeholder="Code">
            </div>
            <div class="col-md-2">
                <input type="text" id="nameFilter" class="form-control" placeholder="Name">
            </div>
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
                            <th>Actions</th>
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
                                    <td>
                                        <button class="btn btn-warning alert-btn" data-code="<?= htmlspecialchars($record['code']) ?>" data-name="<?= htmlspecialchars($record['nom']) ?> <?= htmlspecialchars($record['prenom']) ?>">Send Alert</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9">No absent records found.</td></tr>
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

    <!-- Alert Modal -->
   <!-- Alert Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Send Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="alertForm">
                    <div class="form-group">
                        <label for="subject">Subject (Matiere):</label>
                        <input type="text" class="form-control" id="subject" name="subject" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <input type="hidden" id="alertCode" name="code">
                    <button type="submit" class="btn btn-primary mt-3">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script>
        $(document).ready(function() {
            // Filter logic for tables
            $("#codeFilter, #nameFilter, #dateFilter, #heureFilter, #statutFilter, #niveauFilter").on("keyup change", function() {
                var codeVal = $("#codeFilter").val().toLowerCase();
                var nameVal = $("#nameFilter").val().toLowerCase();
                var dateVal = $("#dateFilter").val();
                var heureVal = $("#heureFilter").val();
                var statutVal = $("#statutFilter").val().toLowerCase();
                var niveauVal = $("#niveauFilter").val().toLowerCase();

                $("#absentBody tr").filter(function() {
                    $(this).toggle(
                        $(this).find("td:eq(0)").text().toLowerCase().indexOf(codeVal) > -1 &&
                        ($(this).find("td:eq(2)").text().toLowerCase().indexOf(nameVal) > -1 || $(this).find("td:eq(3)").text().toLowerCase().indexOf(nameVal) > -1) &&
                        ($(this).find("td:eq(4)").text() === dateVal || dateVal === "") &&
                        ($(this).find("td:eq(5)").text() === heureVal || heureVal === "") &&
                        $(this).find("td:eq(6)").text().toLowerCase().indexOf(statutVal) > -1 &&
                        $(this).find("td:eq(7)").text().toLowerCase().indexOf(niveauVal) > -1
                    );
                });

                $("#presentBody tr").filter(function() {
                    $(this).toggle(
                        $(this).find("td:eq(0)").text().toLowerCase().indexOf(codeVal) > -1 &&
                        ($(this).find("td:eq(2)").text().toLowerCase().indexOf(nameVal) > -1 || $(this).find("td:eq(3)").text().toLowerCase().indexOf(nameVal) > -1) &&
                        ($(this).find("td:eq(4)").text() === dateVal || dateVal === "") &&
                        ($(this).find("td:eq(5)").text() === heureVal || heureVal === "") &&
                        $(this).find("td:eq(6)").text().toLowerCase().indexOf(statutVal) > -1 &&
                        $(this).find("td:eq(7)").text().toLowerCase().indexOf(niveauVal) > -1
                    );
                });
            });

            // Handle alert button click
             $(document).on('click', '.alert-btn', function() {
        var code = $(this).data('code');
        var name = $(this).data('name');
        var matiere = $(this).closest('tr').find('td:eq(1)').text(); // Gets the 'Matiere' from the row

        $('#alertCode').val(code);
        $('#subject').val(matiere); // Set the subject field in the modal
        $('#alertModal').modal('show');

        // Clear the message textarea
        $('#message').val('');
    });

    // Handle form submission for sending alert
    $('#alertForm').on('submit', function(e) {
        e.preventDefault();
        var userMessage = $('#message').val();
        var subjectMatiere = $('#subject').val();

        var fullMessage = subjectMatiere + ": " + userMessage; // Concatenate matiere with the user's message

        var formData = {
            code: $('#alertCode').val(),
            message: fullMessage
        };

        $.ajax({
            type: 'POST',
            url: 'send_alert.php',
            data: formData,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Message sent successfully to ' + name);
                    $('#alertModal').modal('hide');
                } else {
                    alert('Error: ' + result.error);
                }
            },
            error: function() {
                alert('Error sending message.');
            }
        });
    });
});
    </script>
</body>
</HTML>