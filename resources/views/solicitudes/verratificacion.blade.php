@extends('layouts.app_editar')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ratificación</h3>
        </div>
        <div class="section-body">
            <?php $fecha_actual = date('d-m-Y');?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Ratificación </h3>
                            
                            <!--Se realiza la validación de campos para ver si dejó alguno vacío-->
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Revise los campos!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            <!--<span class="badge badge-danger">{{ $error }}</span>-->
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('editar_ratificacion')}}" enctype='multipart/form-data'>
                                @csrf    
                                <input type="hidden" name="id" value="{{ $folio->id }}">
                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Folio de solicitud</label>
                                            <input type="text" class="form-control" value="<?=$folio["id"];?>"readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-8">
                                        <div class="form-group">
                                            <label for="email">Nombre de la empresa</label>
                                            <input type="text" class="form-control" name="empresa" value="<?=$folio["empresa"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Primer apellido</label>
                                            <input type="text" class="form-control" name="primero_empresa" value="<?=$folio["primero_empresa"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Segundo apellido</label>
                                            <input type="text" class="form-control" name="segundo_empresa" value="<?=$folio["segundo_empresa"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Nombre</label>
                                            <input type="text" class="form-control" name="nombre_empresa"value="<?=$folio["nombre_empresa"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email"value="<?=$folio["email"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Telefono</label>
                                            <input type="text" class="form-control" name="telefono" value="<?=$folio["telefono"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Curp</label>
                                            <input type="text" class="form-control" name="curp_solicitante" value="<?=$folio["curp_solicitante"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <h4 class="text-center">Datos del trabajador</h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Nombre</label>
                                            <input type="text" class="form-control" name="nombre_trabajador" value="<?=$folio["trabajador"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Primer apellido</label>
                                            <input type="text" class="form-control" name="primer_apellidot" value="<?=$folio["primero_trabajador"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Segundo apellido</label>
                                            <input type="text" class="form-control" name="segundo_apellidot" value="<?=$folio["segundo_trabajador"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Edad</label>
                                            <input type="text" class="form-control" name="edad" value="<?=$folio["edad"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Sexo</label>
                                            <select class="form-control" name="sexo" required>
                                                <option value="Diario" @php if($folio->sexo === "H") echo "selected"  @endphp>Hombre</option>
                                                <option value="Semanal" @php if($folio->sexo === "M") echo "selected"  @endphp>Mujer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Curp trabajador</label>
                                            <input type="text" class="form-control" name="trabajador_curp" value="<?=$folio["trabajador_curp"];?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" value="<?=$folio["email"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Telefono</label>
                                            <input type="text" class="form-control" name="telefono" value="<?=$folio["telefono"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <h4 class="text-center">Documentos del trabajador</h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Tipo de Identificación</label>
                                            <select class="form-control" name="tipo_identificacion" required>
                                                <option value="Ine" @php if($folio->tipo_identificacion === "INE") echo "selected"  @endphp>INE</option>
                                                <option value="Pasaporte" @php if($folio->tipo_identificacion === "Pasaporte") echo "selected"  @endphp>Pasaporte</option>
                                                <option value="Cedula" @php if($folio->tipo_identificacion === "Cédula Profesional") echo "selected"  @endphp>Cédula Profesional</option>
                                                <option value="Licencia" @php if($folio->tipo_identificacion === "Licencia para Conducir") echo "selected"  @endphp>Licencia para conducir</option>
                                                <option value="Otros" @php if($folio->tipo_identificacion === "Otros") echo "selected"  @endphp>Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">INE</label>
                                            <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->ine}}">Existente</a>
                                            <input type="file" name="documentoIne" class="form-control-file" accept=".pdf">        
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>*Documento que acredite la representación</label><br>
                                            <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->representacion}}">Existente</a>
                                            <input type="file" name="documentoRepresentacion" class="form-control-file" accept=".pdf">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email"> Documento curp</label>
                                            <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->documentoCurp}}">Existente</a>
                                            <input type="file" name="documentoCurp" class="form-control-file" accept=".pdf">        
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Documento identificación</label>
                                            <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->documentoidentificacion}}">Existente</a>
                                            <input type="file" name="documentoidentificacion" class="form-control-file" accept=".pdf">        
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <h4 class="text-center">Datos de la relación laboral</h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Fecha de inicio de la relación laboral</label>
                                            <input type="date" class="form-control" name="fecha_inicio" value="<?=$folio["fecha_inicio"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Fecha de término de la relación laboral</label>
                                            <input type="date" class="form-control" name="fecha_termino" value="<?=$folio["fecha_termino"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Categoria o puesto que desempeña</label>
                                            <input type="text" class="form-control" name="categoria" value="<?=$folio["categoria"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Frecuencia de pago</label>
                                            <select class="form-control" name="frecuencia" required>
                                                <option value="Diario" @php if($folio->frecuencia === "Diario") echo "selected"  @endphp>Diario</option>
                                                <option value="Semanal" @php if($folio->frecuencia === "Semanal") echo "selected"  @endphp>Semanal</option>
                                                <option value="Quincenal" @php if($folio->frecuencia === "Quincenal") echo "selected"  @endphp>Quincenal</option>
                                                <option value="Mensual" @php if($folio->frecuencia === "Mensual") echo "selected"  @endphp>Mensual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Salario</label>
                                            <input type="text" class="form-control" name="salario" value="<?=$folio["salario"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Dias a la semana trabajados </label>
                                            <input type="text" class="form-control" name="dias" value="<?=$folio["dias"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Motivo de la conciliación</label>
                                            <input type="text" class="form-control" name="motivo" value="<?=$folio["motivo"];?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Motivo de la conciliación</label>
                                            <select class="form-control" name="motivo" required>
                                                <option value="Pprestaciones" @php if($folio->motivo === "Pago de prestaciones") echo "selected"  @endphp>Pago de prestaciones</option>
                                                <option value="Tvoluntaria" @php if($folio->motivo === "Terminación voluntaria de la relación de trabajo") echo "selected"  @endphp>Terminación voluntaria de la relación de trabajo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Monto total del convenio a pagar</label>
                                            <input type="text" class="form-control" name="monto" value="<?=$folio["monto"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Tipo pago</label>
                                            <input type="text" class="form-control" name="tipo_pago" value="<?=$folio["tipo_pago"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <h4 class="text-center">Datos de la fecha</h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Sede</label>
                                            <input type="text" class="form-control" name="delegacion" value="<?=$folio["delegacion"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Fecha</label>
                                            <input type="text" class="form-control" name="fecha_pago" value="<?=$folio["fecha"];?>">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="email">Hora inicio</label>
                                            <input type="text" class="form-control" name="hora_pago" value="<?=$folio["hora"];?>">
                                        </div>
                                    </div> 
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label for="email">Observaciones</label>
                                            <input type="text" class="form-control" name="observaciones" value="<?=$folio["observaciones"];?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <a class="btn btn-primary" href="{{ route('Ratificacion') }}">Regresar</a>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="public/assets/js/poderes/general.js"></script>
@endsection

    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/popper.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <script src="public/assets/js/sweetalert.min.js"></script>
    <script src="public/assets/js/select2.min.js"></script>
    <script src="public/assets/js/jquery.nicescroll.js"></script>

    <!-- Template JS File -->
    <script src="public/assets/js/stisla.js"></script>
    <script src="public/assets/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')
    <script>
        document.getElementById("folio").style.display = "none";
        document.getElementById("empresa").style.display = "block";
        document.getElementById("primero").style.display = "block";
        document.getElementById("segundo").style.display = "block";
        document.getElementById("nombre").style.display = "block";
        document.getElementById("edad").style.display = "block";
        document.getElementById("sexo").style.display = "block";
        document.getElementById("ine").style.display = "block";
        document.getElementById("acta").style.display = "block";


        function sedes(){
            document.getElementById("fecha").removeAttribute("disabled");
        }
        function diaSemana() {
            var dia_semana  = document.getElementById("fecha").value;
            var sede        = document.getElementById("sede").value;

            $.get('api/obtenerHorario/'+dia_semana+'/'+sede, function (data){
                var html_select = '<option value="">--Seleccione un horario --</option>';  
                for(var i=0; i<data.length; ++i)
                    html_select += '<option value= "'+data[i].hora+'">'+data[i].hora+'</option>';
                    $('#horarios').html(html_select);

            });
        }

        $(function(){
            $('#check_folio').on('change', validarcheckfolio);
        })

        function validarcheckfolio(){
            tipo = document.getElementById("folio").style.display;
            if (tipo == "none") {
                document.getElementById("folio").style.display = "block";
                document.getElementById("empresa").style.display = "none";
                document.getElementById("primero").style.display = "none";
                document.getElementById("segundo").style.display = "none";
                document.getElementById("nombre").style.display = "none";
                document.getElementById("edad").style.display = "none";
                document.getElementById("sexo").style.display = "none";
                document.getElementById("ine").style.display = "none";
                document.getElementById("acta").style.display = "none";
                document.getElementById("curp").style.display = "none";
            }
            else{
                document.getElementById("folio").style.display = "none";
                document.getElementById("empresa").style.display = "block";
                document.getElementById("primero").style.display = "block";
                document.getElementById("segundo").style.display = "block";
                document.getElementById("nombre").style.display = "block";
                document.getElementById("edad").style.display = "block";
                document.getElementById("sexo").style.display = "block";
                document.getElementById("ine").style.display = "block";
                document.getElementById("acta").style.display = "block";
                document.getElementById("curp").style.display = "block";
            }
        }

        const tipo_iden = document.getElementById('tipo_identificacion');
        tipo_iden.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            // Realiza la validación o acciones necesarias
            if (valorSeleccionado === 'Otro') {
                document.getElementById('espesificar_tipo_identificacion').style.display = "block";
            } else {
                document.getElementById('espesificar_tipo_identificacion').style.display = "none";
            }
        });

        const motivo = document.getElementById('motivo');
        motivo.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            // Realiza la validación o acciones necesarias
            if (valorSeleccionado === 'Pago de prestaciones') {
                document.getElementById('motivo_pago').style.display = "block";
            } else {
                document.getElementById('motivo_pago').style.display = "none";
            }
        });        
        
        const otras = document.getElementById('otras');
        otras.addEventListener('click', function() {
            const valorSeleccionado = this.value;
                document.getElementById('div_otras').style.display = "block";
        });
        
    </script>

@section('scripts')
    <script src="../../public/js/estadistica/estadistica.js"></script>
@endsection
