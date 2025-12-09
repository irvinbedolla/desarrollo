<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Sí Concilio</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 5.3.3 -->
        <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
        <style>
           @page {
                margin: 0px 0px;
            }
            body{
                padding-top: 85px;
            }
            main{
                margin: 50px 50px 50px 40px; /*Para colocar el texto*/
            }
            header {
                position: fixed;
                top: -100px;
                left: 0;
                right: 0;
                height: 100px;
                text-align: center;
                font-size: 14px;
            }

            footer {
                position: fixed;
                bottom: -60px;
                left: 0;
                right: 0;
                height: 50px;
                text-align: center;
                font-size: 12px;
            }
            .content {
                font-family: sans-serif;
                font-size: 12px;
                text-align: justify;
                margin-top: 50px;
            }
            .fondo-membrete {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            } 
            .page-break {
                page-break-after: always;
            }
        </style>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    </head>
    <body>
        <img src="{{ public_path('../../assets/images/pdf_Siconcilio.jpg') }}" class="fondo-membrete">
        <footer></footer>
        <main>
            <div class="content">
                <div class="table-responsive">
                    <table id="tabla_solicitud" class="table-striped" style="width:60%; float: right;">
                            <tr>   
                                <td><b>Centro de Conciliación Laboral del Estado de Michoacán de Ocampo.</b></td>
                            </tr>
                    </table>
                </div><br><br><br>
                <div id="chart"> </div>
            </div>
                <script>
                
                   var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Efectividad',
                            data: @json($labels)
                        }],
                        xaxis: {
                            categories: @json($labels)
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();

                    function exportChartsAsPDF() {
                        const button = document.getElementById('exportButton');
                        button.setAttribute('data-kt-indicator', 'on');
                        
                        setTimeout(() => {
                            const element = document.getElementById('chart');
                            html2canvas(element, {
                                scale: 2,
                                useCORS: true,
                                allowTaint: true,
                                backgroundColor: '#ffffff',
                                colors: ['#FF0000'],
                                logging: true,
                                onclone: function(clonedDoc) {
                                    clonedDoc.querySelectorAll('.apexcharts-canvas').forEach(canvas => {
                                        canvas.style.display = 'block';
                                    });
                                }
                            }).then(canvas => {
                                const imgData = canvas.toDataURL('image/png');
                                const { jsPDF } = window.jspdf;
                                const pdf = new jsPDF('l', 'mm', 'a4');
                                const imgProps = pdf.getImageProperties(imgData);
                                const pdfWidth = pdf.internal.pageSize.getWidth();
                                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                                
                                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                                pdf.save('estadisticas_evaluacion.pdf');
                                
                                button.removeAttribute('data-kt-indicator');
                            });
                        }, 1000);
                    }
                </script>


            <script type="text/php">
                if (isset($pdf)) {
                    $font = $fontMetrics->get_font("Arial", "normal");
                    $size = 10;
                    $y = $pdf->get_height() - 30;
                    $x = ($pdf->get_width() / 2) - 50;
                    $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
                    $pdf->page_text($x, $y, $text, $font, $size, array(0, 0, 0));
                }
            </script>
        </main>
    </body>