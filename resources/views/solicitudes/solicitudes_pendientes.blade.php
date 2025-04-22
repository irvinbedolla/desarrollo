@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Solicitudes Pendientes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table-striped" style="width:100%">
                                    <thead style="background-color: #4A001F;">
                                        <th style="color: #fff;">Folio</th>
                                        <th style="color: #fff;">Fecha Captura</th>
                                        <th style="color: #fff;">Fecha Conflicto</th>
                                        <th style="color: #fff;">Solicitante</th>
                                        <th style="color: #fff;">Rama IndustriaL</th>
                                        <th style="color: #fff;">Actividad Economica</th>
                                        <th style="color: #fff;">Delegacion</th>
                                        <th style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody class="contenidobusqueda">
                                        @foreach($solicitudes as $solicitud)
                                                <tr>
                                                    <td>{{$solicitud->id}}</td>
                                                    <td>{{$solicitud->fecha}}</td>
                                                    <td>{{$solicitud->fecha_conflicto}}</td>
                                                    <td>{{$solicitud->curp}}</td>
                                                    <td>{{$solicitud->rama_industrial}}</td>
                                                    <td>{{$solicitud->actividad}}</td>
                                                    <td>{{$solicitud->delegacion}}</td>
                                                    <td>
                                                        <a class="btn btn-info" href="{{ route('solicitud_revisar', $solicitud->id)}}" onclick=editar_usuario();>Revisar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end">
                               
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="nuevo_usuario" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../public/assets/js/usuarios/usuarios.js"></script>
@endsection