document.addEventListener('DOMContentLoaded', function() {
    const chartsContainer = document.getElementById('chart');
    const data = jsonData;

    data.forEach(item => {
        const canvas = document.createElement('canvas');
        chartsContainer.appendChild(canvas);

        new Chart(canvas, {
            type: 'bar', // Puedes cambiar el tipo de gráfico si lo prefieres
            data: {
                labels: Object.keys(item.respuestas),
                datasets: [{
                    label: item.pregunta,
                    data: Object.values(item.respuestas),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
});
