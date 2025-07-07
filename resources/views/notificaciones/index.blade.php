@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Notificaciones</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            
                            @can('ver-seer')
                                @if($userRole[0] == "Enlace")
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped mt-1" style="text-align:center">
                                            <thead style="background-color: #4A001F;">
                                                <th style="display: none;">ID</th>
                                                <th style="color: #fff;">Expediente</th>
                                                <th style="color: #fff;">Citado</th>
                                                <th style="color: #fff;">Dirección</th>
                                                <th style="color: #fff;">Estatus</th>
                                                <th style="color: #fff;">Asignar</th>
                                                <th style="color: #fff;"></th>
                                                <th style="color: #fff;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                @foreach($notificaciones as $notificacion)
                                                    <tr>
                                                        <td style="display: none;">{{$notificacion->id_solicitud}}</td>
                                                        <td>{{$notificacion->NUE}}</td>
                                                        <td>{{$notificacion->nombre}} {{$notificacion->primer_apellido}} {{$notificacion->segundo_apellido}}</td>
                                                        <td>{{$notificacion->colonia}} {{$notificacion->calle}} {{$notificacion->n_ext}}</td>
                                                        <td>{{$notificacion->estatus}}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('seer.store_enlace') }}" class="needs-validation novalidate">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$notificacion->id_citado}}">
                                                                <select class="form-control" name="notificador">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach($personas as $persona)
                                                                        <option value="{{$persona->id}}">{{$persona->name}}</option>
                                                                    @endforeach
                                                                </select> 
                                                            <td>    
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <button type="submit" class="btn btn-primary">Asignar</button>
                                                                </div> 
                                                            </td>    
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <div class="col-xs-12 col-sm-12 col-md-12"> 
                                                                @if($notificacion->estatus == "Pendiente" || $notificacion->estatus == "Sin asignar")
                                                                    <a class="btn btn-primary" href="{{ route('editar_citado', $notificacion->id_citado) }}" onclick="consultar_estadistica();">Editar</a>
                                                                @endif
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endcan
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end">
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="menu_carga" style ="display: none;">
            <div>.</div>
            <div class="loader"></div>
        </div>
        
@section('scripts')
    <script src="../public/assets/js/estadistica/estadistica.js"></script>
@endsection
        
    </section>
    
    
@endsection




