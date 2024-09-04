// Cargamos el contenido del canva para mostrar el grafico
const ctx = document.getElementById('chart').getContext('2d');

// Creamos un grafico
const chart = new Chart(ctx, {
    type: 'bar', // Tipo de grafico
    data: {
        labels: labels, // Nombres de las respuestas enviadas
        datasets: [{
            label: 'Número de votos', // Nombre de lo que carga el grafico
            data: data, // Cantidad de votos por respuesta
            backgroundColor: [
                // Colores para el fondo
                'rgba(144, 238, 144, 0.2)',
                'rgba(0, 100, 0, 0.2)',
                'rgba(255, 255, 0, 0.2)',
                'rgba(139, 0, 0, 0.2)',
                'rgba(255, 99, 71, 0.2)'
            ],
            borderColor: [
                // Colores para los bordes
                'rgba(144, 238, 144, 1)',
                'rgba(0, 100, 0, 1)',
                'rgba(255, 255, 0, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(139, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});