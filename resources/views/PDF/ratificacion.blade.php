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
       
        <!-- Template CSS -->
        <link rel="icon"       href="../public/assets/images/ccl-r.png" type="image/x-icon">
        <link rel="stylesheet" href="../public/assets/css/style.css">
        <link rel="stylesheet" href="../public/assets/css/components.css">

        <style>
            .header img { 
                width: 180px; height: 45px; 
            }
            body {
                font-family: sans-serif;
                font-size: 12px;
                text-align: justify;
                color: black;
            }
            p {
                line-height: 1.5;
            }
        </style>
    </head>
    @php     
       /* $direccion_sede='';
        if($solicitud->delegacion === 'Morelia'){
            $direccion_sede='BLVD. GARCÍA DE LEÓN NO. 1575, COL. CHAPULTEPEC ORIENTE, C.P.58260 MORELIA, MICHOACÁN DE OCAMPO';
        }    
        if($solicitud->delegacion === 'Uruapan'){
            $direccion_sede='NUEVO PARICUTÍN NO. 308, COL. JARDINES DE SAN RAFAEL, C.P.30136 URUAPAN, MICHOACÁN DE OCAMPO. SE ENCUENTRA DENTRO DEL RECINTÓ DONDE ESTA RENTAS DEL
                ESTADO, POR LA CLÍNICA DEL IMSS NO.76.';
        }
        if($solicitud->delegacion === 'Zamora') {
            $direccion_sede='JUSTO SIERRA PONIENTE NO. 290, COL. JARDINES DE CATEDRAL, C.P.59600 ZAMORA, MICHOACÁN DE OCAMPO';
        }  
        if($solicitud->delegacion === 'Zitácuaro') {
            $direccion_sede='CUAUHTEMOC ORIENTE NO. 15, COL. CUAUHTEMOC, C.P. 61506ZITÁCUARO, MICHOACÁN DE OCAMPO';
        } 
        if($solicitud->delegacion === 'Lázaro Cárdenas') {
            $direccion_sede='PARACHO NO. 26, COL. 600 CASAS, C.P.60950 LÁZARO CÁRDENAS, MICHOACÁN DE OCAMPO';
        }  
        if($solicitud->delegacion === 'Sahuayo') {
            $direccion_sede='AV. UNIVERSIDAD SUR NO. 300, COL. LOMAS DE UNIVERSIDAD, C.P.59103 SAHUAYO DE MORELOS, MICHOACÁN DE OCAMPO';
        } */ 
    @endphp

    <body>
        <div class="header">
            <img src="{{ public_path('assets/images/Logos 2.png') }}" alt="Encabezado">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           <p><b>FECHA DE LA SOLICITUD O EMISIÓN DEL DOCUMENTO:  {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</b></p>
                           <p> 
                              EMPRESA/PATRÓN:<br>
                              TRABAJADOR: <br>
                              CENTRO DE CONCILIACIÓN LABORAL DEL ESTADO DE MICHOACÁN DE OCAMPO <br><br>
                            </p>  
                            <p>Usted ha guardado exitosamente la Solicitud de <b>Ratificación de Convenio</b>. El Centro de Conciliación Laboral del Estado 
                                de Michoacán de Ocampo con domicilio en <b>(domicilio de la sede que escogieron)</b>, misma que tiene un horario de 09:00 a 15:00 hrs, 
                                está facultada para atender su solicitud.</p>
                            <p>Con fecha {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y \s\i\e\n\d\o \l\a\s H:i:s') }} horas, ante esta 
                                autoridad conciliadora, <b>NOMBRE</b> con un salario de <b>???? pesos FRECUENCIA DE PAGO</b> y cubriendo la cantidad de <b>NÚMERO DE DÍAS 
                                TRABAJADOS</b> días trabajados por semana, me doy por notificado (a) personalmente de la fecha para la 
                                celebración de Ratificación de Convenio, misma que tendrá lugar el día <b>FECHA</b> a las <b>HORA</b> horas, en la 
                                Delegación Regional/Oficina de Apoyo de <b>SEDE</b> del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, con domicilio en 
                                <b>DOMICILIO DE SEDE</b>, para la entrega de la cantidad convenida a pagar de <b>MONTO A PAGAR EN NÚMERO Y LETRA </b>pesos M.N en <b> FORMA DE PAGO</b>.</p>
                            
                                <p>Las partes deberán presentar su identificación oficial el día <b>(día de la cita)</b>. De conformidad con el articulo 684-E, fracción XIII, los convenios 
                                    celebrados ante el Centro de Conciliación adquirirán la condición de Cosa Juzgada.</p>
                                <p>
                                    La cantidad total a pagar estará sujeta a la revisión del Personal del Centro de Conciliación, para verificar que no exista Renuncia de Derechos y 
                                    proceder con la Ratificación del Convenio.
                                </p>

                            
                            <center><p><b>
                                ___________________________________<br>
                                </b>NOMBRE Y FIRMA</p><br><br></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>    