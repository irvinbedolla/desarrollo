@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Audiencias</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Historial</h3>
                            @can('ver-seer')
                                <div class="table-responsive">
                                    <table id="HistorialSolicitudes" class="table table-striped mt-1">
                                        <thead style="background-color: #4A001F;">
                                            <th style="display: none;">ID</th>
                                            <th style="color: #fff;">Fecha de audiencia</th>
                                            <th style="color: #fff;">Número unico de identificación</th>
                                            <th style="color: #fff;">Solicitante</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Detalles</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($audiencias as $audiencia)
                                                <tr>
                                                    <td style="display: none;">{{$audiencia->id_solicitud}}</td>
                                                    <td>{{$audiencia->fecha}}</td> 
                                                    <td>{{$audiencia->NUE}}</td>
                                                    <td>{{$audiencia->nombre_solicitante}}</td>
                                                    <td>{{$audiencia->nombre}}</td>
                                                    <td>{{$audiencia->estatus}}</td>
                                                    <td>
                                                        <a class="btn btn-success"  tarjet="_black">Documento</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>      
                                </div>

                            @endcan
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end"></div>                        
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
            <script src="../../public/js/estadistica/estadistica.js"></script>
        @endsection
        
    </section>
@endsection    