<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="width: 80%; margin: auto; background: white; padding: 20px; border-radius: 10px; shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <canvas id="graficaUsuarios"></canvas>
</div>

<script>
    const ctx = document.getElementById('graficaUsuarios').getContext('2d');
    
    // Datos pasados desde Laravel
    const etiquetas = @json($nombres);
    const valores = @json($totales);

    new Chart(ctx, {
        type: 'bar', // Tipo de gráfica: Barras
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Total de Ratificaciones',
                data: valores,
                // Colores institucionales (puedes cambiarlos)
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Auxiliares / Usuarios'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Ocultamos la leyenda porque el título de la barra es suficiente
                },
                title: {
                    display: true,
                    text: 'Ratificaciones por Usuario'
                }
            }
        }
    });
</script>