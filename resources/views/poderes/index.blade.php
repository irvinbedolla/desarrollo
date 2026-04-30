@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Poderes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @can('crear-abogado')
                                <a class="btn btn-warning" href="{{ route('poder-crear') }}" target="_blank"> Nuevo</a>
                            @endcan
                            
                            @can('ver-abogado')
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Tipo Persona</th>
                                            <th style="color: #fff;">Nombre/Razón</th>
                                            <th style="color: #fff;">Representante</th>
                                            <th style="color: #fff;">Teléfono</th>
                                            <th style="color: #fff;">Email</th>
                                            <th style="color: #fff;">Fecha Vigencia</th>
                                            <th style="color: #fff;">Vigencia Representación</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Identificación del patrón/Acta Constitutiva</th>
                                            <th style="color: #fff;">Identificación representante</th>
                                            <th style="color: #fff;">Documento que acredite la personería</th>
                                            <th style="color: #fff;">Anexo</th>
                                            <th style="color: #fff;"></th>
                                            <th style="color: #fff;"></th>
                                            <th style="color: #fff;"></th>
                                            <th style="color: #fff;"></th>                                            
                                        </thead>
                                        <tbody>
                                            @foreach($poderes as $persona)
                                                <tr>
                                                    <td>{{$persona->idAbogado}}</td>
                                                    <td>{{$persona->tipo}}</td>
                                                    <td>
                                                        @if($persona->tipo == "Fisica")
                                                            {{$persona->nombres_patronal." ".$persona->primer_apellido_patronal." ".$persona->segundo_apellido_patronal }}
                                                        @elseif($persona->tipo == "Moral")
                                                            {{$persona->nombres_patronal}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->reprecentante == "Si" || $persona->nombre_representante != null)
                                                            {{$persona->nombre_representante." ".$persona->primer_apellido_representante." ".$persona->segundo_apellido_representante}}
                                                        @else
                                                            Sin representante legal
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->tipo == "Fisica")
                                                            {{$persona->telefono_patronal }}
                                                        @elseif($persona->tipo == "Moral")
                                                            {{$persona->numero_representante}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->tipo == "Fisica")
                                                            {{$persona->email_patronal }}
                                                        @elseif($persona->tipo == "Moral")
                                                            {{$persona->correo_representante}}
                                                        @endif
                                                    </td>
                                                    <td>{{\Carbon\Carbon::parse($persona->fechaVigencia)->format('d/m/y')}}</td>
                                                    <td>
                                                        @if($persona->tipo == "Moral" || ($persona->tipo == "Fisica" && $persona->reprecentante == "Si"))
                                                            @if($persona->fechaVigencia == NULL)
                                                                Sin Validar
                                                            @elseif($persona->fechaVigencia >= $fechaActual)
                                                                Vigente
                                                            @elseif($persona->fechaVigencia  < $fechaActual) 
                                                                Vencido
                                                            @endif
                                                        @else
                                                            No Aplica
                                                        @endif
                                                    </td>
                                                    <td>{{$persona->estatus}}</td>
                                                    {{--<td><a target="_blank" href="../storage/app/documentos_abogados/{{$persona->ineDocumento}}">PDF</a></td> 
                                                    <td>
                                                        @if($persona->cedulaDocumento == NULL)
                                                            S/D
                                                        @else
                                                            <a target="_blank" href="../storage/app/documentos_abogados/{{$persona->cedulaDocumento}}">PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->representacionDocumento == NULL)
                                                            S/D
                                                        @else 
                                                            <a target='_blank' href='../storage/app/documentos_abogados/{{$persona->representacionDocumento}}'>PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->cedula === "Sin carta poder")
                                                            S/A
                                                        @else
                                                            <a target='_blank' href='../storage/app/documentos_abogados/{{$persona->cedulaDocumento}}'>PDF</a>
                                                        @endif
                                                    </td>--}}
                                                    <td><a target="_blank" href="../storage/app/documentos_abogados/{{$persona->ineDocumento}}">PDF</a></td> 
                                        
                                                    <td>
                                                        @if($persona->representacionDocumento == NULL)
                                                            S/D
                                                        @else 
                                                            <a target='_blank' href='../storage/app/documentos_abogados/{{$persona->representacionDocumento}}'>PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->cedulaDocumento == NULL)
                                                            S/D
                                                        @else
                                                            <a target="_blank" href="../storage/app/documentos_abogados/{{$persona->cedulaDocumento}}">PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->cedula === "Sin carta poder")
                                                            S/D
                                                        @else
                                                            <a target='_blank' href='../storage/app/documentos_abogados/{{$persona->anexo_documento}}'>PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                         @if($persona->estatus === "Validado")
                                                            <a class="btn btn-info" href="{{ route('PDFregistroAbogado', $persona->idAbogado)}}" target="_blank">Documento</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @can('editar-abogado')
                                                            <div class="d-flex flex-column gap-1">
                                                                <a class="btn btn-info"
                                                                href="{{ route('poderes.edit', $persona->idAbogado) }}"
                                                                onclick="editar_poder();">
                                                                    Editar
                                                                </a>

                                                                <a class="btn btn-warning"
                                                                href="{{ route('poderes.history', $persona->idAbogado) }}">
                                                                    Historial
                                                                </a>
                                                            </div>
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-1 h-100">
                                                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-id="{{ $persona->idAbogado }}" data-tipo="{{ $persona->tipo }}">
                                                                Agregar representante
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @can('borrar-abogado')
                                                            <form method="POST" action="{{ route('poderes.destroy', $persona->idAbogado) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                @if($userRole[0] == "Super Usuario")
                                                                    <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                                @endif
                                                            </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endcan

                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end">
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class='needs-validation novalidate' method='POST' action="{{ route('poderes.agregar_representante') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idAbogado" id="idAbogado_input" value="">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Representante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12" id="Conrepresentante">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Información del Representante Legal</h5>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center">Datos de identificación</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) del representante <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombre_representante_pF" id="nombre_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Primer apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="primer_representante_pF" id="primer_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El primer apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Segundo apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="segundo_representante_pF" id="segundo_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP<span style="color:red;"> (*)</span></label>
                                                        <input type="text" class="form-control"  aria-label="CURP" name="curp_representante_pF" id="curp_representante_pF" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Sexo <span style="color:red;">(*)</span></label>
                                                        <select name="sexo_representante_pF" id="sexo_representante_pF" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Femenino">Femenino</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Prefiero no responder">Prefiero no responder</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El tipo de persona es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                   <div class="form-group">
                                                        <h5 class="text-center">Datos de contacto</h5>
                                                    </div>
                                                </div> 

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo electrónico <span style="color:red;">(*)</span></label>
                                                        <input type="email" class="form-control" name="correo_representante_pF" id="correo_representante_pF" >
                                                        <div class="invalid-feedback">
                                                            El Correo electrónico es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control"  name="telefono_representante_pF" id="telefono_representante_pF" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Datos de la documentación que acredite la personeria</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">  
                                                    <div class="form-group">
                                                        <label for="name">Tipo de documento <span style="color:red;">(*)</span></label>
                                                        <select name="tipo_documento_pF" id="tipo_documento_pF" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Carta Poder">Carta Poder</option>
                                                                <option value="Instrumento Notarial">Instrumento Notarial</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Fecha expedición <span style="color:red;">(*)</span></label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_expedicion_pF" id="fecha_expedicion_pF" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <div class="form-check mt-4">
                                                        <input name="sin_fecha_vigencia_pF" type="checkbox" class="form-check-input" id="check_vigencia" autocomplete="off">
                                                        <label class="form-check-label" for="check_vigencia">Sin fecha de vigencia</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3" id="fecha_vigencia_pF_container">
                                                    <div class="form-group">
                                                        <label for="fecha_vigencia_pF">Fecha vigencia</label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_vigencia_pF" id="fecha_vigencia_pF" min="<?= date("Y-m-d") ?>" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Descripción del documento que acredite la personaria <span style="color:red;">(*)</span></label>
                                                        <textarea class="form-control" aria-describedby="basic-addon1" name="descripcion_pF" id="descripcion_pF" 
                                                        placeholder="Ejemplo: Carta poder simple de fecha___, firmada ante dos testigos, suscrita a favor del compareciente por el (C., Lic., Ing., etc.,)_____, en cuanto ___ de la moral citada, personalidad que acredite en terminos de___ número(45 Cuarenta y Cinco), de fecha___, pasada ante la fe del(Lic., Mtro., etc.,)___, Notario Público Número ___, del Estado de ____, y cuyas facultades no han sido revocadas ni mofificadas a la fecha."></textarea>
                                                        <div class="invalid-feedback">
                                                            La descripción es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Identificación Oficial  <span style="color:red;">(*)</span></label>
                                                        <select id="tipo_identificacion_pFCR" name="tipo_identificacion_pFCR" class="form-control">
                                                            <option value="">Seleccione el tipo de indentificación</option>
                                                            <option value="Credencial de elector">Credencial de Elector</option>
                                                            <option value="Pasaporte">Pasaporte</option>
                                                            <option value="Cédula profesional">Cédula Profesional</option>
                                                            <option value="Licencia de conducir">Licencia de Conducir</option>
                                                            <option value="Credencial de inapam">Credencial de INAPAM</option>
                                                            <option value="Cartilla militar">Cartilla Militar</option>
                                                            <option value="Documento migratorio">Documento Migratorio</option>
                                                            <option value="Constancia de identidad">Constancia de Identidad</option>
                                                            <option value="Otro">Otros</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Este campo identificación es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6"> 
                                                    <div class="form-group">
                                                        <label for="name">Núm de identificación <span style="color:red;">(*)</span> <span data-bs-toggle="modal" data-bs-target="#helpModal" style="cursor: pointer;">❓</span></label>
                                                        <input type="text" name="num_identificacion_pFCR" id="num_identificacion_pFCR" class="form-control" oninput="this.value = this.value.toUpperCase()"> 
                                                        <div class="invalid-feedback">
                                                            El campo núm. de identificación es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Cargar Documentos</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6" id="div_acta_constitutiva" style="display:none;">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Acta Constitutiva</label><br>
                                                        <input type="file" name="documentoActa_Moral" id="documentoActa_Moral" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            El acta constitutiva es obligatoria para personas morales.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Identificación del Representante Legal</label><br>
                                                        <input type="file" name="documentoRepresentacion_pF" id="documentoRepresentacion_pF" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            El documento de representación es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Documento que acredite la personería</label><br>
                                                        <input type="file" name="documentoPoder_pF" id="documentoPoder_pF" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Anexo (Documentos Complementarios)</label><br>
                                                        <input type="file" name="documentoAnexo_pF" id="documentoAnexo_pF" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div align="center">
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="../public/js/poderes/general.js"></script>
    <script>
        var exampleModal1 = document.getElementById('exampleModal1')
        if (exampleModal1) {
            exampleModal1.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                
                var idAbogadoReq = button.getAttribute('data-id')
                var tipoAbogadoReq = button.getAttribute('data-tipo')
                
                var modalBodyInput = exampleModal1.querySelector('#idAbogado_input')
                modalBodyInput.value = idAbogadoReq
                
                var divActa = document.getElementById('div_acta_constitutiva');
                var inputActa = document.getElementById('documentoActa_Moral');
                
                if(tipoAbogadoReq === 'Moral') {
                    divActa.style.display = 'block';
                    inputActa.setAttribute('required', 'required');
                } else {
                    divActa.style.display = 'none';
                    inputActa.removeAttribute('required');
                    inputActa.value = '';
                }

                var checkVigencia = document.getElementById('check_vigencia');
                var divFechaVigencia = document.getElementById('fecha_vigencia_pF_container');
                var inputFechaVigencia = document.getElementById('fecha_vigencia_pF');

                if (checkVigencia && divFechaVigencia && inputFechaVigencia) {
                    function toggleFechaVigencia() {
                        if (checkVigencia.checked) {
                            divFechaVigencia.style.display = 'none';
                            inputFechaVigencia.value = '';
                        } else {
                            divFechaVigencia.style.display = 'block';
                        }
                    }

                    checkVigencia.checked = false;
                    toggleFechaVigencia();

                    checkVigencia.onchange = toggleFechaVigencia;
                }
            })
        }
    </script>
@endsection
