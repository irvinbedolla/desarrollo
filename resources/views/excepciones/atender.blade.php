@extends('layouts.app_editar')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Caso de Excepción</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Atender excepciones</h3>
                             
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
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('guardar_excepcion')}}">
                                <input type="hidden" name="id" value="{{$id}}">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Observaciones</label>
                                            <textarea name="observaciones" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                Las observaciones son obligatorias.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Se canalizo a:</label>
                                            <input type="text" class="form-control" name="dependencia" required>
                                            <div class="invalid-feedback">
                                                La dependencia es obligatoria.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Expediente</label>
                                            <input type="text" class="form-control" name="expediente" required>
                                            <div class="invalid-feedback">
                                                El número de expediente es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-6">
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
    <script src="../public/js/usuarios/usuarios.js"></script>
@endsection