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
        }  */
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
                           <p><b>CONVENIO DE TERMINACIÓN DE RELACIÓN LABORAL TRABAJADOR<br>
                              CENTRO DE CONCILIACIÓN LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO<br>
                              NÚMERO DE IDENTIFICACIÓN ÚNICO<br><br>
                              CONVENIO DE CONCILIACIÓN
                              <br></b></p>  

                           <p>Con fundamento en los artículos 123, apartado A, fracción XXVII, inciso h) párrafo segundo, de la Constitución Política de los Estados Unidos Mexicanos; 
                            artículo 33 y 684-E de la Ley Federal del Trabajo, se celebra el presente convenio por una parte [SOLICITANTE_NOMBRE_COMPLETO] quién en lo subsecuente se 
                            denominará la parte “TRABAJADORA” y, por otro [RESOLUCION_CITADOS_CONVENIO] a quién en lo subsecuente se le denominará la parte “EMPLEADORA”, a quienes en 
                            lo sucesivo de forma conjunta se les denominará las “PARTES”, quienes se someten y obligan en términos de las siguientes declaraciones y cláusulas:</p><br>
                           <p>D E C L A R A C I O N E S:</p><br>
                           <p>PRIMERA. La parte TRABAJADORA se identifica con [SOLICITANTE_IDENTIFICACION_DOCUMENTO] expedida a su favor por [SOLICITANTE_IDENTIFICACION_EXPEDIDA_POR]  
                            y declara ser una persona mayor de edad, por lo que tiene plenas capacidades de goce y ejercicio para convenir o transigir. 
                            SEGUNDA. Declara [RESOLUCION_SEGUNDA_DECLARACION_CONVENIO].  
                            TERCERA. Declara la parte TRABAJADORA: 
                            a) Que fue contratada por la parte EMPLEADORA desde el [SOLICITANTE_DATOS_LABORALES_FECHA_INGRESO], para prestar sus servicios como [SOLICITANTE_DATOS_LABORALES_PUESTO], 
                            puesto en el que se desempeñó hasta el día [SOLICITANTE_DATOS_LABORALES_FECHA_SALIDA].
                            b) Que por el desempeño de sus labores contaba con las siguientes prestaciones:
                                - Salario mensual: $[SOLICITANTE_DATOS_LABORALES_SALARIO_MENSUAL] ([SOLICITANTE_DATOS_LABORALES_SALARIO_MENSUAL_LETRA] moneda nacional). 
                                - Días de descanso: [SOLICITANTE_DATOS_LABORALES_DIAS_DESCANSO]
                                - Vacaciones: [SOLICITANTE_DATOS_LABORALES_DIAS_VACACIONES] días al año.
                                - Aguinaldo:[SOLICITANTE_DATOS_LABORALES_DIAS_AGUINALDO] días al año.
                                - Otras prestaciones (bonos, vales de despensa, seguros de gastos médicos mayores etc): [SOLICITANTE_DATOS_LABORALES_PRESTACIONES_ADICIONALES].
                            c) Que desempeñaba sus actividades laborales en las siguientes condiciones: 
                                - Horario: [SOLICITANTE_DATOS_LABORALES_HORARIO_LABORAL]
                                - Horario de comida: de [SOLICITANTE_DATOS_LABORALES_HORARIO_COMIDA] [SOLICITANTE_DATOS_LABORALES_COMIDA_DENTRO]  de las instalaciones.
                                - Domicilio donde prestaba sus servicios: [SOLICITANTE_DOMICILIOS_LABORAL].
                            d) Que el día [SOLICITUD_FECHA_RECEPCION] presentó solicitud para iniciar el procedimiento de conciliación prejudicial ante el Centro de Conciliación 
                            Laboral del Estado de MIchoacán de Ocampo, por motivo de [SOLICITUD_OBJETO_SOLICITUDES], misma que confirmó ante el Centro el [SOLICITUD_FECHA_RATIFICACION].
                            e) Que el Centro Estatal, fijó la audiencia de conciliación para el día  [AUDIENCIA_FECHA_AUDIENCIA].
                            CUARTA. Declara la parte EMPLEADORA:
                            a)Que la parte TRABAJADORA fue contratada en los términos señalados en la declaración inmediata anterior. 
                            b)Que con motivo del citatorio de fecha [SOLICITUD_FECHA_RATIFICACION] emitido por el Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, 
                            la parte EMPLEADORA comparece para desahogar la etapa de conciliación prejudicial conforme al Artículo 684-E de la Ley Federal del Trabajo.
                            QUINTA. Declaran las PARTES:  
                            a)  Que el presente convenio se celebra con la finalidad de dar por terminado el procedimiento de conciliación prejudicial, seguido ante el Centro de 
                            Conciliación Laboral del Estado de Michoacán de Ocampo, bajo el número de identificación único [EXPEDIENTE_FOLIO].
                            b) Que el día [AUDIENCIA_FECHA_AUDIENCIA], se celebró la audiencia de conciliación y que, por así convenir a sus intereses, la parte TRABAJADORA y la 
                            parte EMPLEADORA han llegado a un acuerdo para dirimir el conflicto suscitado, al tenor de las siguientes.
                            </p><br>
                            <p>
                                C L Á U S U L A S: <br>
                                PRIMERA. Las PARTES han determinado que por así convenir a sus intereses dan por concluida la relación laboral por mutuo acuerdo, conforme a lo 
                                estipulado por el artículo 53, fracción I, de la Ley Federal del Trabajo. 
                                SEGUNDA. La parte TRABAJADORA manifiesta bajo protesta de decir verdad, que el vínculo laboral lo mantuvo exclusivamente con la parte EMPLEADORA. 
                                Por lo anterior, expresa que no existió relación laboral alguna con otras personas, incluido el personal que fungía como superior jerárquico en el 
                                centro de trabajo donde la parte TRABAJADORA desempeñaba sus labores.
                                TERCERA. La EMPLEADORA otorga en favor de la TRABAJADORA el pago acordado conforme a las disposiciones de la Ley Federal del Trabajo y respetando 
                                los derechos consagrados en el mismo ordenamiento legal. 
                                Asimismo la TRABAJADORA manifiesta su entera conformidad y la aceptación de éste, así como la forma en que se obtuvieron los conceptos que se 
                                describen en la cláusula QUINTA.
                                CUARTA. La parte TRABAJADORA manifiesta que durante el tiempo que laboró para la parte EMPLEADORA, se cubrió en tiempo y forma el pago su salario; 
                                cada una de las prestaciones ordinarias y extraordinarias y en especie que conforme a derecho le corresponden, así mismo como cualquier riesgo o 
                                accidente de trabajo que haya sufrido. Por lo anterior, la parte EMPLEADORA no adeuda pago de concepto alguno.
                                QUINTA. La TRABAJADORA recibirá por parte de la EMPLEADORA la cantidad de $[RESOLUCION_TOTAL_PERCEPCIONES]  ([RESOLUCION_TOTAL_PERCEPCIONES_LETRA] 
                                moneda nacional), conforme a los siguientes conceptos:
                                [RESOLUCION_PROPUESTA_CONFIGURADA]
                                [RESOLUCION_JUSTIFICACION_PROPUESTA]
                                [SI_RESOLUCION_PAGO_DIFERIDO]SEXTA.La EMPLEADORA manifiesta que pagará en [RESOLUCION_TOTAL_DIFERIDOS] exhibiciones, hasta culminar la cantidad de 
                                $[RESOLUCION_TOTAL_PERCEPCIONES] ([RESOLUCION_TOTAL_PERCEPCIONES_LETRA] moneda nacional), tal como se muestra:
                                [RESOLUCION_PAGOS_DIFERIDOS]  
                                En caso de que la parte EMPLEADORA no cubra el pago de la cantidad estipulada y dentro del plazo determinado en esta cláusula, deberá pagar a la parte 
                                TRABAJADORA el equivalente a un día de salario diario, el cual se fijará en razón del salario que percibía dicha parte antes de finalizar la relación 
                                de trabajo. Esa cantidad se sumará a la previamente pactada, por cada día que transcurra, sin que se dé cabal cumplimiento al convenio, con fundamento 
                                en el artículo 684-E, fracción XIV, último párrafo, de la Ley Federal del Trabajo.
                                [SI_RESOLUCION_PAGO_NO_DIFERIDO]SEXTA. La EMPLEADORA manifiesta que en este acto en fecha [FECHA_ACTUAL] le paga a la TRABAJADORA en una sola exhibición 
                                la cantidad de $[RESOLUCION_TOTAL_PERCEPCIONES]  ([RESOLUCION_TOTAL_PERCEPCIONES_LETRA] moneda nacional), en el domicilio que ocupa el Centro de Conciliación 
                                Laboral del Estado de Michoacán de Ocampo, con lo que se certifica el cumplimiento de su obligación bajo el presente convenio, de conformidad con lo establecido 
                                en el artículo 684-E, fracción XIV, de la Ley Federal del Trabajo.
                                [FIN_SI_RESOLUCION_PAGO]  
                                SÉPTIMA. Las PARTES solicitan se apruebe y sancione este convenio, toda vez que se elaboró conforme a las disposiciones aplicables de la Ley Federal del Trabajo 
                                como resultado del diálogo de la conciliación entre la parte TRABAJADORA y la parte EMPLEADORA. Asimismo, manifiestan que se encuentran conformes con el presente 
                                acuerdo por no contener cláusula contraria a la costumbre, a la moral, ni renuncia a los derechos de las PARTES.
                                OCTAVA. Las PARTES manifiestan que es su voluntad ratificar el presente convenio en todas y cada una de sus partes y la aprobación de su contenido, por lo que no 
                                se reservan acción legal o derecho alguno para ejercitar con posterioridad a la firma del presente convenio.
                                NOVENA. Las PARTES solicitan ante el Centro Estatal de Conciliación Laboral que les sean expedidas las copias autorizadas del convenio, y en el momento en que se 
                                haya cumplido totalmente, se les expida acta en la que conste el cumplimiento de éste, en términos del artículo 684-E, fracción XIV, primer párrafo, de la Ley 
                                Federal del Trabajo.
                                DÉCIMA. Las PARTES manifiestan que en la celebración del presente convenio no existió violencia, mala fe, dolo, lesión o cualquier otro tipo de vicio del consentimiento 
                                que pudiera nulificarlo.
                                DÉCIMA PRIMERA. En caso de que no se cumplan los términos de lo convenido en el presente instrumento, las PARTES deberán acudir a los juzgados Laborales del fuero comun 
                                a efecto de que se realice el procedimiento de ejecución que la Ley Federal del Trabajo contempla.
                                Enteradas las PARTES del alcance legal del presente convenio que se eleva a cosa juzgada, conforme al artículo 684-E fracción XIII, mismo que se firma en [CENTRO_DOMICILIO_ESTADO] 
                                a los [FECHA_ACTUAL], ante la fe de [CONCILIADOR_NOMBRE_COMPLETO], funcionario conciliador, quien lo sanciona en este mismo acto. Doy fe.
                            </p>
                            <p>
                                [SOLICITUD_FIRMAS_PARTES_QR] 
                                <center><br><br> [CONCILIADOR_QR_FIRMA] 
                                    <p><b>___________________________________<br>
                                         [CONCILIADOR_NOMBRE_COMPLETO] <br> 
                                         FUNCIONARIO CONCILIADOR</b></p></center>

                                <p>Los códigos QR asociadas a cada una de las partes no representan una forma de manifestación de la voluntad, sin embargo, se convierten en firma electrónica en caso de que 
                                    la parte firmante utilice su firma electrónica avanzada para manifestar su voluntad. Para que se puedan utilizar los códigos QR será necesario que todas las partes firmantes
                                     cuenten con la firma electrónica avanzada de lo contrario deberán acudir a la Oficina estatal del CCL para firmar el documento de manera autógrafa.</p>
                                    
                                    <br><br>
                                        <center><p><b>  ___________________________________                                     ___________________________________<br>
                                                            LA PARTE TRABAJADORA<br>                                                LA PARTE EMPLEADORA<br>
                                                            FUNCIONARIA CONCILIADORA/<br>                                           FUNCIONARIA CONCILIADORA/<br>
                                                            FUNCIONARIO CONCILIADOR</b></p>                                         FUNCIONARIO CONCILIADOR</b></p></center>


                                    <center><br><br> 
                                            <p><b>___________________________________<br>
                                                 [CONCILIADOR_NOMBRE_COMPLETO] <br>   
                                                 FUNCIONARIA CONCILIADORA/<br>
                                                 FUNCIONARIO CONCILIADOR</b></p></center>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

