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
                            <h3 class="text-center">Citados </h3>
                            
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
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('editar_citado_enlace')}}" enctype='multipart/form-data'>
                                @csrf    
                                <input type="hidden" name="id" value="{{ $folio->id }}">
                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Folio de solicitud</label>
                                            <input type="text" class="form-control" value="<?=$folio["id"];?>"readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <label for="name">Nombre(s) del citado *</label>
                                            <input type="text" name="nombre" class="form-control" value="<?=$folio["nombre"];?>" oninput="this.value = this.value.toUpperCase()" > 
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Primer apellido *</label>
                                            <input type="text" name="primer_apellido" class="form-control" value="<?=$folio["primer_apellido"];?>" oninput="this.value = this.value.toUpperCase()" > 
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Segundo apellido *</label>
                                            <input type="text" name="segundo_apellido" class="form-control" value="<?=$folio["segundo_apellido"];?>"oninput="this.value = this.value.toUpperCase()" > 
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">RFC</label>
                                            <input type="text" name="rfc" class="form-control" value="<?=$folio["rfc"];?>"minlength="13" maxlength="13" > 
                                            <div class="invalid-feedback">
                                                El campo conflicto es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tipo de Vialidad del citado *</label>
                                            <select name="vialidad" class="form-control" required>
                                                <option value="">SELECCIONE</option>
                                                <option value="Calle">CALLE</option>
                                                    <option value="Avenida" @php if($folio->tipo_vialidad === "Avenida") echo "selected"  @endphp>AVENIDA</option>
                                                    <option value="Calzada" @php if($folio->tipo_vialidad === "Calzada") echo "selected"  @endphp>CALZADA</option>
                                                    <option value="Boulevard" @php if($folio->tipo_vialidad === "Boulevard") echo "selected"  @endphp>BOULEVARD</option>
                                                </select>
                                            <div class="invalid-feedback">
                                                El campo vialidad es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Calle del citado *</label>
                                            <input type="text" name="calle" class="form-control" value="<?=$folio["calle"];?>"required> 
                                            <div class="invalid-feedback">
                                                El campo calle es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Colonia del citado *</label>
                                            <input type="text" name="colonia" class="form-control" value="<?=$folio["colonia"];?>"required> 
                                            <div class="invalid-feedback">
                                                El campo colonia es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Código Postal del citado *</label>
                                            <input type="text" name="cp" class="form-control" value="<?=$folio["cp"];?>" minlength="5" maxlength="5" required> 
                                            <div class="invalid-feedback">
                                                El campo Código Postal es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Entre calle del domicilio del citado</label>
                                            <input type="text" name="calle1" class="form-control" value="<?=$folio["calle1"];?>">
                                            <div class="invalid-feedback">
                                                El campo calle es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">y calle del domicilio del citado</label>
                                            <input type="text" name="calle2" class="form-control" value="<?=$folio["calle2"];?>"> 
                                            <div class="invalid-feedback">
                                                El campo calle es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Num ext. del citado</label>
                                            <input type="text" name="exterior" class="form-control" value="<?=$folio["n_ext"];?>" required> 
                                            <div class="invalid-feedback">
                                                El campo calle es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Num int. del citado</label>
                                            <input type="text" name="interior" class="form-control" value="<?=$folio["n_int"];?>" > 
                                            <div class="invalid-feedback">
                                                El campo calle es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Tipo de personas</label>
                                            <select name="tipo" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Fisica" @php if($folio->tipo_persona === "Fisica") echo "selected"  @endphp>Fisica</option>
                                                <option value="Moral" @php if($folio->tipo_persona === "Moral") echo "selected"  @endphp>Moral</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El tipo de persona es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">CURP</label>
                                            <input type="text" name="curp" id="curp_input" oninput="validarInput(this)" class="form-control" value="<?=$folio["curp"];?>"> 
                                            <pre id="resultado"></pre>
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="floatingTextarea">Referencias del domicilio del citado</label>
                                            <textarea class="form-control" placeholder="" name="referencia"><?=$folio["referencia"];?></textarea>
                                            <div class="invalid-feedback">
                                                El campo referencias es obligatorio.
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-info">Guardar</button>
                                        <a class="btn btn-info" href="{{ route('notificaciones')}}" onclick=consultar_estadistica();>Regresar</a>
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
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection

    <script src="../../public/assets/js/jquery.min.js"></script>
    <script src="../../public/assets/js/popper.min.js"></script>
    <script src="../../public/assets/js/bootstrap.min.js"></script>
    <script src="../../public/assets/js/sweetalert.min.js"></script>
    <script src="../../public/assets/js/select2.min.js"></script>
    <script src="../../public/assets/js/jquery.nicescroll.js"></script>

    <!-- Template JS File -->
    <script src="../../public/assets/js/stisla.js"></script>
    <script src="../../public/assets/js/scripts.js"></script>
    <script src="../../public/assets/js/profile.js"></script>
    <script src="../../public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')
    <script>

        $(function(){
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
        })
    </script>

@section('scripts')
    <script src="../../public/js/estadistica/estadistica.js"></script>
@endsection
