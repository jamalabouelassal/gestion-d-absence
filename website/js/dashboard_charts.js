document.addEventListener('DOMContentLoaded', function() {
    var ctx1 = document.getElementById('studentChart').getContext('2d');
    var studentChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Bio', 'Comp Sci', 'Math', 'Physics'],
            datasets: [{
                label: 'Number of Students',
                data: [50, 120, 70, 30],
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx2 = document.getElementById('departmentChart').getContext('2d');
    var departmentChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Undergrad', 'Postgrad', 'PhD'],
            datasets: [{
                label: 'Program Levels',
                data: [300, 150, 50],
                backgroundColor: ['red', 'blue', 'green']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});