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
                                <a class="btn btn-warning" href="{{ route('turnos.create') }}"  onclick=crear_turnos();> Nuevo</a>
                                <a class="btn btn-info"    href="{{ route('turnos.listado') }}" onclick=crear_turnos();> Turnos</a>
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