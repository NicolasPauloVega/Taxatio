document.addEventListener('DOMContentLoaded', function() {
    const chartsContainer = document.getElementById('chart');
    const data = jsonData;

    data.forEach(item => {
        const canvas = document.createElement('canvas');
        chartsContainer.appendChild(canvas);

        new Chart(canvas, {
            type: 'bar',
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
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const value = tooltipItem.raw;
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    });
});