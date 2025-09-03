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
            
    </head>
    <body>
        <img src="{{ public_path('assets/images/pdf_Siconcilio.jpg') }}" class="fondo-membrete">
        <footer>
            
        </footer>
        <main>
            <div class="content">
                <div class="table-responsive">
                    <table id="tabla_solicitud" class="table-striped" style="width:60%; float: right;">
                            <tr>   
                                <td><b>Centro de conciliación: </b></td>
                                <td>Morelia</td>
                            </tr>
                    </table>
                </div><br><br><br>
                
                            <div class="table-responsive">
                                <spam>Auxiliares</spam>
                                <table class="table table-striped mt-2">
                                    <thead style="background-color: #869b9c;">
                                        <th style="color: #fff;  text-align: center;">Nombre</th>
                                        <th style="color: #fff;  text-align: center;">N° de Solicitudes</th>
                                        <th style="color: #fff;  text-align: center;">N° de Cumplimientos</th>
                                        <th style="color: #fff;  text-align: center;">Monto</th>
                                        <th style="color: #fff;  text-align: center;">N° de Ratificaciones</th>
                                        <th style="color: #fff;  text-align: center;">Monto</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style=" text-align: center;">Luis Rico Guzman</td>
                                            <td style=" text-align: center;">25</td>
                                            <td style=" text-align: center;">10</td>
                                            <td style=" text-align: center;">$12,500.00</td>
                                            <td style=" text-align: center;">15</td>
                                            <td style=" text-align: center;">$10,250.00</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Yesenia Arteaga Vences</td>
                                            <td style=" text-align: center;">23</td>
                                            <td style=" text-align: center;">12</td>
                                            <td style=" text-align: center;">$9,500.00</td>
                                            <td style=" text-align: center;">15</td>
                                            <td style=" text-align: center;">$14,600.00</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Ana Luisa Soriano</td>
                                            <td style=" text-align: center;">21</td>
                                            <td style=" text-align: center;">15</td>
                                            <td style=" text-align: center;">$20,125.00</td>
                                            <td style=" text-align: center;">15</td>
                                            <td style=" text-align: center;">$6,200.00</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Sandra Rocio Varela Cortés</td>
                                            <td style=" text-align: center;">20</td>
                                            <td style=" text-align: center;">10</td>
                                            <td style=" text-align: center;">$50,250.00</td>
                                            <td style=" text-align: center;">10</td>
                                            <td style=" text-align: center;">$20,000.00</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Erandi Martinez Barajas</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">14</td>
                                            <td style=" text-align: center;">$57,000.00</td>
                                            <td style=" text-align: center;">14</td>
                                            <td style=" text-align: center;">$10,250.00</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Maria Del Rosario Valle Garcia</td>
                                            <td style=" text-align: center;">21</td>
                                            <td style=" text-align: center;">13</td>
                                            <td style=" text-align: center;">$25,500.00</td>
                                            <td style=" text-align: center;">15</td>
                                            <td style=" text-align: center;">$12,250.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

             <div class="page-break"></div>
<br><br>
                            <div class="table-responsive">
                                <spam>Conciliadores</spam>
                                <table class="table table-striped mt-2">
                                    <thead style="background-color: #869b9c;">
                                        <th style="color: #fff;  text-align: center;">Nombre</th>
                                        <th style="color: #fff;  text-align: center;">N° de Audiencias</th>
                                        <th style="color: #fff;  text-align: center;">Monto</th>
                                        <th style="color: #fff;  text-align: center;">N° Cumpliemientos</th>
                                        <th style="color: #fff;  text-align: center;">Monto</th>
                                        <th style="color: #fff;  text-align: center;">Convenios</th>
                                        <th style="color: #fff;  text-align: center;">No Conciliación</th>
                                        <th style="color: #fff;  text-align: center;">Archivadas</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style=" text-align: center;">Natalia Itzel Estrada Guzman</td>
                                            <td style=" text-align: center;">24</td>
                                            <td style=" text-align: center;">$15,256.00</td>
                                            <td style=" text-align: center;">5</td>
                                            <td style=" text-align: center;">$12,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Susy Areli Reyes Santoyo</td>
                                            <td style=" text-align: center;">21</td>
                                            <td style=" text-align: center;">$40,256.00</td>
                                            <td style=" text-align: center;">4</td>
                                            <td style=" text-align: center;">$12,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Luz Ireri Gonzalez Hernadez</td>
                                            <td style=" text-align: center;">23</td>
                                            <td style=" text-align: center;">$9,256.00</td>
                                            <td style=" text-align: center;">4</td>
                                            <td style=" text-align: center;">$8,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Rosa Isela Barrera Valdes</td>
                                            <td style=" text-align: center;">25</td>
                                            <td style=" text-align: center;">$29,256.00</td>
                                            <td style=" text-align: center;">6</td>
                                            <td style=" text-align: center;">$6,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Rocio Estefania Ramirez Soto</td>
                                            <td style=" text-align: center;">21</td>
                                            <td style=" text-align: center;">$22,256.00</td>
                                            <td style=" text-align: center;">4</td>
                                            <td style=" text-align: center;">$12,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                         <tr>
                                            <td style=" text-align: center;">Daniel Buitron Izquierdo</td>
                                            <td style=" text-align: center;">26</td>
                                            <td style=" text-align: center;">$20,256.00</td>
                                            <td style=" text-align: center;">5</td>
                                            <td style=" text-align: center;">$9,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                         <tr>
                                            <td style=" text-align: center;">Juan Rosales Garibay</td>
                                            <td style=" text-align: center;">20</td>
                                            <td style=" text-align: center;">$14,256.00</td>
                                            <td style=" text-align: center;">3</td>
                                            <td style=" text-align: center;">$4,250.00</td>
                                            <td style=" text-align: center;">22</td>
                                            <td style=" text-align: center;">1</td>
                                            <td style=" text-align: center;">1</td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                
                <div class="page-break"></div>

                            <div class="table-responsive">
                                <spam>Notificadores</spam>
                                <table class="table table-striped mt-2">
                                    <thead style="background-color: #869b9c;">
                                        <th style="color: #fff;  text-align: center;">Nombre</th>
                                        <th style="color: #fff;  text-align: center;">Notificacicada</th>
                                        <th style="color: #fff;  text-align: center;">No Notificada</th>
                                        <th style="color: #fff;  text-align: center;">Notificación por Instructivo</th>
                                        <th style="color: #fff;  text-align: center;">Exhorto</th>
                                        <th style="color: #fff;  text-align: center;">No Exitosa se constituye</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style=" text-align: center;">Felipe Moreno Diaz</td>
                                            <td style=" text-align: center;">30</td>
                                            <td style=" text-align: center;">8</td>
                                            <td style=" text-align: center;">10</td>
                                            <td style=" text-align: center;">0</td>
                                            <td style=" text-align: center;">12</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Manlio Gerardo López Gutiérrez</td>
                                            <td style=" text-align: center;">25</td>
                                            <td style=" text-align: center;">10</td>
                                            <td style=" text-align: center;">3</td>
                                            <td style=" text-align: center;">0</td>
                                            <td style=" text-align: center;">15</td>
                                        </tr>
                                        <tr>
                                            <td style=" text-align: center;">Lorena Lachino Barboza</td>
                                            <td style=" text-align: center;">28</td>
                                            <td style=" text-align: center;">10</td>
                                            <td style=" text-align: center;">4</td>
                                            <td style=" text-align: center;">0</td>
                                            <td style=" text-align: center;">9</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

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