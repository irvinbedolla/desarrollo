<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Sí Concilio - Estadísticas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        @page { margin: 0px; }
        body { padding-top: 50px; background-color: #f4f7f7; font-family: 'Helvetica', sans-serif; }
        main { margin: 20px 50px; }
        
        .chart-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e0e6e6;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f4f4;
            padding-bottom: 10px;
        }

        .chart-title {
            color: #5a6a6b;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            margin: 0;
        }

        .btn-export {
            background-color: #869b9c;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            transition: 0.3s;
        }

        .btn-export:hover { background-color: #5a6a6b; color: white; }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

    <main>
        <div class="chart-card" id="container-efectividad">
            <div class="chart-header">
                <h2 class="chart-title">Efectividad General</h2>
                <button class="btn-export" onclick="exportToPDF('container-efectividad', 'efectividad')">Descargar Reporte</button>
            </div>
            <div id="chart-efectividad"></div>
        </div>

        <div class="chart-card" id="container-cantidades">
            <div class="chart-header">
                <h2 class="chart-title">Cumplimientos por Cantidad</h2>
                <button class="btn-export" onclick="exportToPDF('container-cantidades', 'cantidades')">Descargar Reporte</button>
            </div>
            <div id="chart-cantidades"></div>
        </div>

        <div class="chart-card" id="container-montos">
            <div class="chart-header">
                <h2 class="chart-title">Cumplimientos por Monto Económico</h2>
                <button class="btn-export" onclick="exportToPDF('container-montos', 'montos')">Descargar Reporte</button>
            </div>
            <div id="chart-montos"></div>
        </div>

        <div class="chart-card" id="container-auxiliares">
            <div class="chart-header">
                <h2 class="chart-title">Ratificaciones por Auxiliar</h2>
                <button class="btn-export" onclick="exportToPDF('container-auxiliares', 'auxiliares')">Descargar Reporte</button>
            </div>
            <div id="chart-auxiliares"></div>
        </div>

        <div class="chart-card" id="container-productividad">
            <div class="chart-header">
                <h2 class="chart-title">Solictudse por Auxiliar</h2>
                <button class="btn-export" onclick="exportToPDF('container-productividad', 'productividad')">Descargar Reporte</button>
            </div>
            <div id="chart-productividad"></div>
        </div>


        <script>
            const colorPrimario = '#869b9c';
            const colorSecundario = '#5a6a6b';

            // Datos desde Blade
            const datosEfectividad = { data: @json($data), labels: @json($labels) };
            const datosRat = @json($ratificacionesData);
            const datosAud = @json($audienciasData);
            const etiquetasAux = @json($nombres_rati);
            const valoresAux = @json($totales_rati);

            // 1. Efectividad
            new ApexCharts(document.querySelector("#chart-efectividad"), {
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                colors: [colorPrimario],
                series: [{ name: 'Efectividad', data: datosEfectividad.data }],
                xaxis: { categories: datosEfectividad.labels }
            }).render();

            // 2. Cantidades
            new ApexCharts(document.querySelector("#chart-cantidades"), {
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                colors: [colorPrimario, colorSecundario],
                series: [
                    { name: 'Ratificaciones', data: [datosRat.total_count, datosRat.pagado_count, datosRat.pendiente_count] },
                    { name: 'Audiencias', data: [datosAud.total_count, datosAud.pagado_count, datosAud.pendiente_count] }
                ],
                xaxis: { categories: ['Total', 'Pagados', 'Pendientes'] }
            }).render();

            // 3. Montos
            new ApexCharts(document.querySelector("#chart-montos"), {
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                colors: [colorPrimario, colorSecundario],
                series: [
                    { name: 'Ratificaciones ($)', data: [datosRat.total_monto, datosRat.pagado_monto, datosRat.pendiente_monto] },
                    { name: 'Audiencias ($)', data: [datosAud.total_monto, datosAud.pagado_monto, datosAud.pendiente_monto] }
                ],
                xaxis: { categories: ['Total', 'Pagados', 'Pendientes'] },
                yaxis: { labels: { formatter: (val) => "$" + val.toLocaleString() } }
            }).render();

            // 4. Rendimiento por Auxiliar (Adaptada a ApexCharts Horizontal)
            new ApexCharts(document.querySelector("#chart-auxiliares"), {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '60%',
                        borderRadius: 4,
                        dataLabels: { position: 'top' }
                    }
                },
                colors: [colorPrimario],
                series: [{ name: 'Total Ratificaciones', data: valoresAux }],
                xaxis: { categories: etiquetasAux },
                dataLabels: {
                    enabled: true,
                    offsetX: 30,
                    style: { fontSize: '12px', colors: [colorSecundario] }
                },
                title: {
                    text: 'TOTAL DE RATIFICACIONES POR AUXILIAR',
                    align: 'left',
                    style: { color: colorSecundario, fontSize: '14px' }
                }
            }).render();

            // FUNCIÓN DE EXPORTACIÓN
            function exportToPDF(containerId, fileName) {
                const element = document.getElementById(containerId);
                html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#ffffff'
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const { jsPDF } = window.jspdf;
                    const pdf = new jsPDF('l', 'mm', 'a4');
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    pdf.addImage(imgData, 'PNG', 0, 10, pdfWidth, pdfHeight);
                    pdf.save(`reporte-${fileName}.pdf`);
                });
            }

            // 5. Productividad por Auxiliar (Migrado a ApexCharts)
            new ApexCharts(document.querySelector("#chart-productividad"), {
                chart: { 
                    type: 'bar', 
                    height: 400, 
                    toolbar: { show: false } 
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '60%',
                        borderRadius: 4,
                        dataLabels: { position: 'top' }
                    }
                },
                colors: [colorPrimario],
                series: [{ 
                    name: 'Solicitudes Procesadas', 
                    data: @json($totales) 
                }],
                xaxis: { 
                    categories: @json($nombres) 
                },
                dataLabels: {
                    enabled: true,
                    offsetX: 30,
                    style: { 
                        fontSize: '12px', 
                        colors: [colorSecundario] 
                    }
                },
                title: {
                    text: 'DETALLE DE REGISTROS POR AUXILIAR',
                    align: 'left',
                    style: { 
                        color: colorSecundario, 
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                }
            }).render();
        </script>
    </main>
</body>
</html>