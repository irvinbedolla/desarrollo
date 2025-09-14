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
                padding-top: 95px;
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
                            <td><b>Oficina: </b></td>
                            <td>{{ strtoupper($solicitud->delegacion) }} </td>
                        </tr>
                        <tr>    
                            <td><b>Número de identificación único: </b></td>
                            <td>{{ $solicitud->NUE }} </td>
                        </tr> 
                    </table>
                </div><br><br><br><br>
                <p><center><b>
                    CENTRO DE CONCILIACIÓN LABORAL DEL ESTADO DE MICHOACÁN DE OCAMPO<br><br><br>
                    ACTA DE AUDIENCIA DE CONCILIACIÓN     
                </b></center></p> <br><br> 

                <p>
                    En el <b>Centro de Conciliación Laboral del Estado de Michoacán de Ocampo con sede en {{ $solicitud->delegacion }}</b>, siendo las <b>{{ $solicitud->hora }} horas del
                    {{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b>, hora y día señalados para la celebración de la Audiencia de Conciliación 
                    Prejudicial, relativa al expediente electrónico con Número de Identificación Único <b>{{ $solicitud->NUE }}</b>, misma que se celebra ante  
                    <b>{{ $conciliador->name }}</b>, Funcionario/a Conciliador/a adscrito al Centro de Conciliación 
                    Laboral del Estado de Michoacán de Ocampo,  con fundamento en los artículos 33, 590-E, 590-F, 684-A, 684-B, 684-C, 684-D, 684-E, 684-F, 684-G y 684-I, de la 
                    Ley Federal del Trabajo, artículo 27 de la Ley Orgánica del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, y artículo 20 del Reglamento Interior del 
                    Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, <b>declara abierta</b> la Audiencia de Conciliación Prejudicial en la que comparecen: <br><br>

                    La parte citada <b>{{ $solicitud->trabajador }} {{ $solicitud->primero_trabajador }} {{ $solicitud->segundo_trabajador }}</b> y, por la parte solicitante 
                    <b>{{ $solicitud->empresa }} {{$solicitud->observaciones}}</b>, identificaciones que concuerdan fisionómicamente con las partes y, que, en este acto, se agrega copia cotejada al 
                    expediente electrónico para que conste como corresponda; documentos que les son devueltos por ser innecesaria su retención. <br><br>

                    Por tanto, esta Autoridad Conciliadora se encuentra en condiciones para desahogar la <b>Audiencia de Conciliación Prejudicial.</b><br><br>

                    Se hace del conocimiento del trabajador(a) que podrá comparecer asistido por abogado(a) o persona de su confianza, pero no se reconocerá a ésta como apoderado, por tratarse 
                    de un Procedimiento de Conciliación y no de un juicio; por lo que respecta al empleador, éste podrá comparecer a través de su representante, siempre y cuando cuente con las 
                    facultades suficientes para obligarse en su nombre y lo acredite ante esta instancia.<br><br>

                    Asimismo, se les informa a las partes que las manifestaciones que realicen durante la audiencia, no podrán constituir prueba o indicio en ningún procedimiento administrativo 
                    o judicial ni el personal de las autoridades conciliadoras podrán ser llamados a comparecer como testigos ante los Tribunales Laborales, de conformidad con los establecido en 
                    los artículos 684-C tercer párrafo y 684-J de la Ley Federal del Trabajo.<br><br>

                    El Procedimiento de Conciliación se realiza de conformidad con los principios constitucionales de legalidad, imparcialidad, confiabilidad, eficacia, objetividad, profesionalismo, 
                    transparencia y publicidad. Consecuentemente, es un proceso ágil, objetivo, imparcial, transparente y eficaz, en el que sus costos son menores en comparación a un procedimiento 
                    jurisdiccional, máxime que en el procedimiento ni el patrón ni el trabajador puede estar seguro de ganar el juicio, mientras que en la conciliación se llega a un acuerdo en el que 
                    se benefician ambas partes.<br><br>

                    A continuación, se cede el uso de la voz de manera ordenada y respetuosa a los presentes en esta audiencia, para manifestar en relación al proceso de conciliación: <br><br>
                    
                    <!--[RESOLUCION_PRIMERA_MANIFESTACION]-->
                    <b>{{ $solicitud->resolucion_primera }}</b><br><br>

                    Así, resulta procedente exponer a los presentes la propuesta de un acuerdo conciliatorio justo y equitativo que beneficie a ambas partes del conflicto; haciendo de su conocimiento 
                    que, en el caso de estar conformes con dicho acuerdo, se procederá a realizar el convenio por escrito, mismo que deberá ratificarse en el presente acto y, posteriormente, se les 
                    entregará copia certificada del mismo en el que conste su cumplimiento en términos de los artículos 684-E fracción XIV y 684-I, de la ley Federal del Trabajo.<br><br>

                    La propuesta referida, se encuentra formulada en los términos siguientes:<br><br>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <!--<p class="sangria">-->
                            @foreach($prestaciones as $concepto)
                                @switch($concepto->descripcion)                                   
                                    @case('Vacaciones')
                                        <tr>
                                            <td>Vacaciones</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }} </td>
                                            <td>{{ $vacacionesTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('PrimaVacacional')
                                        <tr>
                                            <td>Prima vacacional</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td>
                                            <td>{{ $primaTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('Aguinaldo')
                                        <tr>
                                            <td>Aguinaldo</td> 
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td> 
                                            <td>{{ $aguinaldoTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('DSueldo')
                                        <tr>
                                            <td>Días de sueldo</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td> 
                                            <td>{{ $DSueldoTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('GraficaciónA')
                                        <tr>
                                            <td>Graficación A (Con base al salario integrado)</td> 
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td> 
                                            <td>{{ $gratificacionATexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('GraficaciónB')
                                        <tr>
                                            <td>Graficación B (20 Días por año cumplido)</td> 
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td>
                                            <td>{{ $gratificacionBTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('GratificaciónC')
                                        <tr>
                                            <td>Graficación C (Prima de antigüedad topada)</td> 
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td> 
                                            <td>{{ $gratificacionCTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('GratificaciónD')
                                        <tr>
                                            <td>Graficación D (Incluye cualquier otra prestación)</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td>
                                            <td>{{ $gratificacionDTexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('GratificaciónE')
                                        <tr>
                                            <td>Graficación E (Prestaciones en especie)</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td>
                                            <td>{{ $gratificacionETexto }} M.N.</b></td>
                                        </tr>
                                        @break
                                    @case('GratificaciónF')
                                        <tr>
                                            <td>Graficación F (Reconocimiento de derechos)</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }}</td>
                                            <td>{{ $gratificacionFTexto }} M.N.</b></td>
                                        </tr>
                                        @break 
                                    @case('Otras')
                                        <tr>
                                            <td>Otras prestaciones (bonos, vales de despensa, seguros de gastos médicos mayores etc)</td>
                                            <td><b>${{ number_format($concepto->monto, 2) }} {{ $otrasTexto }} M.N.</b></td>
                                            <td>{{ $solicitud->Especifique }}<br></td>
                                        </tr>
                                        @break
                                    @default    
                                @endswitch
                            @endforeach
                        <!--</p>-->
                        </tbody>
                    </table>
                    
                    <!--[RESOLUCION_PROPUESTAS_TRABAJADORES] -->
                    <b>{{ $solicitud->resolucion_trabajadores }}</b>

                    <!--[RESOLUCION_JUSTIFICACION_PROPUESTA]-->
                    <b>{{ $solicitud->resolucion_justificacion }}</b><br><br>

                    A efecto de conocer la opinión de las partes, se cede el uso de la voz de manera ordenada y respetuosa a los presentes en esta audiencia, con la finalidad de escuchar lo que 
                    tengan que expresar en torno a la propuesta y sus alcances, <b>haciendo de su conocimiento que no se podrán negociar derechos y prestaciones irrenunciables en términos de la Ley 
                    Federal del Trabajo,</b> y respetando los adquiridos; de no estar de acuerdo se podrá solicitar una nueva audiencia que tendrá verificativo dentro de los cinco días siguientes al 
                    cierre de esta diligencia.<br><br>

                    <!--[RESOLUCION_SEGUNDA_MANIFESTACION]-->
                    <b>{{ $solicitud->resolucion_segunda }}</b><br><br>

                    Por tanto, en caso de que las partes hayan expresado estar conformes con la propuesta sugerida, se procede a la celebración del convenio respectivo, el cual tendrá valor de cosa juzgada 
                    y, tendrá la calidad de un título para iniciar acciones ejecutivas sin necesidad de ratificación lo anterior con fundamento en el artículo 684-E fracción XIII de la Ley Federal del Trabajo.<br><br>

                    En caso de realizar convenio y éste se incumpla, cualquiera de las partes podrá promover su cumplimiento mediante el proceso de ejecución de sentencia establecido en la Ley Federal del 
                    Trabajo y ante los Tribunales Laborales competentes. <br><br>

                    Ahora bien, se hace del conocimiento de las partes que, la información aportada durante el Procedimiento de Conciliación no podrá comunicarse a persona o autoridad alguna, a excepción de 
                    la Constancia de No Conciliación y, en su caso, del convenio de conciliación que se celebre, mismos que deberán ser remitidos al Tribunal Laboral competente y deberán contener los nombres 
                    y domicilios aportados por las partes, acompañando las constancias relativas a la notificación de la parte citada que haya realizado la Autoridad Conciliadora y los buzones electrónicos 
                    asignados.<br><br>

                    De igual modo, el tratamiento de los datos proporcionados por los interesados y los datos personales recabados por este Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, 
                    serán protegidos, incorporados y tratados únicamente por este Organismo Descentralizado de la Administración Pública Estatal como Sujeto Obligado ante la Ley General de Protección de Datos 
                    Personales en Posesión de Sujetos Obligados y a la Ley General de Transparencia y Acceso a la Información Pública. <br><br>

                    Asimismo, se informa que sus datos no podrán ser difundidos sin el consentimiento expreso, salvo las excepciones previstas en ley.<br><br>

                    Así lo proveyó, <b>{{ $conciliador->name }}</b>, Funcionario(a) Conciliador(a) adscrito al Centro de Conciliación Laboral del Estado de Michoacán de Ocampo. <b>Doy fe.</b>
                </p>

                <br><br>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div style="display: inline-block; margin-right: 50px;">
                                <p><center><b>___________________________________<br> {{ $solicitud->trabajador }} {{ $solicitud->primero_trabajador }} {{ $solicitud->segundo_trabajador }}  <br> LA PARTE TRABAJADORA<br></b></center></p>
                            </div>
                                    
                            <div style="display: inline-block;">
                                <p><center><b>___________________________________<br> {{ $solicitud->nombre_empresa }} {{ $solicitud->primero_empresa }} {{ $solicitud->segundo_empresa }}<br>LA PARTE EMPLEADORA<br></b></center></p>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    <p><center><b>___________________________________<br> {{ $conciliador->name }} <br> FUNCIONARIO/A CONCILIADOR/A<br>
                        DEL CENTRO DE CONCILIACIÓN LABORAL DEL<br>ESTADO DE MICHOACÁN DE OCAMPO</b></p></center>                    
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