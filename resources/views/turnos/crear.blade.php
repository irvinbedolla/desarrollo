@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Turnos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Generar Turno</h3>
                            
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

                            <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('turnos.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre del solicitante</label>
                                            <input type="text" name="nombre" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tipo Solicitud</label>
                                            <select name="tipo" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="Solicitud">Solicitud</option>
                                                <option value="Ratificación">Ratificación</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El tipo de solicitud es obligatoria.
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Edad</label>
                                                <input type="number" name="edad" class="form-control"> 
                                                <div class="invalid-feedback">
                                                    El campo edad es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Sexo</label>
                                                <select name="sexo" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="H">Hombre</option>
                                                    <option value="M">Mujer</option>
                                                    <option value="NB">No Binarios</option>
                                                    <option value="LGBTTTIQ">LGBTTTIQ+</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo sexo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Grupos vulnerables</label>
                                                <select name="vulnerables" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="Discapacidad">Personas con discapacidad</option>
                                                    <option value="Mayores">Adultos mayores</option>
                                                    <option value="Indigena">Población indígena</option>
                                                    <option value="Violencia">Violencia laboral ( acoso/ hostigamiento laboral)</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo sexo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Conflicto</label>
                                                <textarea name="conflicto" class="form-control"></textarea>
                                                <div class="invalid-feedback">
                                                    El campo edad es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                    
                                </div>
                            </forms>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="nuevo_turno" style="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../public/assets/js/turnos/turnos.js"></script>
    <script>
        $('input[type="checkbox"]').on('change', function(e){
            if (this.checked) {
                document.getElementById("div1").style.display = "block";
                document.getElementById("div2").style.display = "block";
                document.getElementById("div3").style.display = "block";
                document.getElementById("div4").style.display = "block";
            } else {
                document.getElementById("div1").style.display = "none";
                document.getElementById("div2").style.display = "none";
                document.getElementById("div3").style.display = "none";
                document.getElementById("div4").style.display = "none";
            }
        });
    </script>
@endsection