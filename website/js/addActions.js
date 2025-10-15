// Function to handle adding a professor
function addProfessor() {
    var formData = new FormData(document.getElementById('addProfessorForm'));

    fetch('add_professor.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Professor added successfully: ' + data.message);
        // Optionally clear the form or update the UI here
    })
    .catch(error => {
        console.error('Error adding professor:', error);
        alert('Failed to add professor.');
    });
}

// Function to handle adding a niveau to a professor
function addNiveauToProfessor() {
    var formData = new FormData(document.getElementById('addNiveauForm'));

    fetch('add_niveau.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Niveau added successfully to professor: ' + data.message);
        // Optionally clear the form or update the UI here
    })
    .catch(error => {
        console.error('Error adding niveau:', error);
        alert('Failed to add niveau.');
    });
}

// Add event listeners to form buttons or elements
document.addEventListener('DOMContentLoaded', function() {
    var addProfBtn = document.getElementById('addProfessorButton');
    var addNiveauBtn = document.getElementById('addNiveauButton');

    if (addProfBtn) {
        addProfBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission and page reload
            addProfessor();
        });
    }

    if (addNiveauBtn) {
        addNiveauBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission and page reload
            addNiveauToProfessor();
        });
    }
});
