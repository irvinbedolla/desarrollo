<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="width: 80%; margin: auto;">
    <canvas id="graficaCumplimientos"></canvas>
</div>
<div style="width: 80%; margin: auto;">
    <canvas id="graficaCumplimientosMonto"></canvas>
</div>

<script>
    // Convertimos los datos de PHP a JSON para JavaScript
    const datosRatificacion = @json($ratificacionesData);
    const datosAudiencia = @json($audienciasData);

    const ctx = document.getElementById('graficaCumplimientos').getContext('2d');
    const ctx1 = document.getElementById('graficaCumplimientosMonto').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfica
        data: {
            labels: ['Total', 'Pagados', 'Pendientes'], // Etiquetas del eje X
            datasets: [
                {
                    label: 'Ratificaciones',
                    data: [
                        datosRatificacion.total_count, 
                        datosRatificacion.pagado_count, 
                        datosRatificacion.pendiente_count
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Audiencias',
                    // Audiencias usualmente no tienen estatus en tu consulta anterior, 
                    // ajustamos según lo que necesites mostrar
                    data: [
                        datosAudiencia.total_count, 
                        datosAudiencia.pagado_count, 
                        datosAudiencia.pendiente_count
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Reporte de Cumplimientos (Cantidades)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const myChart1 = new Chart(ctx1, {
        type: 'bar', // Tipo de gráfica
        data: {
            labels: ['Total', 'Pagados', 'Pendientes'], // Etiquetas del eje X
            datasets: [
                {
                    label: 'Ratificaciones',
                    data: [
                        datosRatificacion.total_monto, 
                        datosRatificacion.pagado_monto, 
                        datosRatificacion.pendiente_monto
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Audiencias',
                    // Audiencias usualmente no tienen estatus en tu consulta anterior, 
                    // ajustamos según lo que necesites mostrar
                    data: [
                        datosAudiencia.total_count, 
                        datosAudiencia.pagado_count, 
                        datosAudiencia.pendiente_count
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Reporte de Cumplimientos (Totales)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>