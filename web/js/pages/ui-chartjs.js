document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM fully loaded and parsed");

    var ctx = document.getElementById('myChart').getContext('2d');
    console.log(ctx); 

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Alternatif', 'Total Kriteria', 'Total Preferensi'],
            datasets: [{
                label: 'Jumlah',
                data: [totalAlternatives, totalCriterias, totalPreferences],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
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
});