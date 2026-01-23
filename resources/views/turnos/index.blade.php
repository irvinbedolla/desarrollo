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
                            @can('crear-turnos')
                                <div class="row g-3 align-items-end">
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="ufs">Último Folio Solicitudes</label>
                                            <input id="ufs" name="ufs" type="text" class="form-control" value="{{ $last_solicitudes ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="ufr">Último Folio Ratificaciones</label>
                                            <input id="ufr" name="ufr" type="text" class="form-control" value="{{ $last_turnos ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <a class="btn btn-info" href="{{ route('nueva_cita') }}" onclick="crear_turnos();">Nuevo</a>
                                    <a class="btn btn-info" href="{{ route('turnos.listado') }}" onclick="crear_turnos();">Turnos</a>
                                </div>
                            @endcan

                            @can('ver-turno')
                                <div class="table-responsive">
                                    <table id="example" class="table-striped" style="width:100%">
                                        <thead style="background-color: #4A001F;">
                                            <th style="display: none;">ID</th>
                                            <th style="color: #fff;">Nombre</th>
                                            <th style="color: #fff;">Delegacion</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < $total; $i++)
                                                <tr>
                                                    <td style="display: none;">{{$auxiliares_morelia[$i]["id"]}}</td>
                                                    <td>{{$auxiliares_morelia[$i]["name"]}}</td>
                                                    <td>{{$auxiliares_morelia[$i]["delegacion"]}}</td>
                                                    <td>{{$auxiliares_morelia[$i]["estatus"]}}</td>
                                                    <td> 
                                                        <a class="btn btn-info"   href="{{ route('turnos.activo',   $auxiliares_morelia[$i]['id']) }}" onclick=disponibles();>Disponible</a>
                                                        <a class="btn btn-danger" href="{{ route('turnos.noactivo', $auxiliares_morelia[$i]['id']) }}" onclick=no_disponible();>Ocupado</a>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="nuevo_turno" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../public/assets/js/turnos/turnos.js"></script>
@endsection