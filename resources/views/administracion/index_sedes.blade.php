@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Sedes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           
                            @can('ver-curso')
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-1">
                                        <thead style="background-color: #4A001F;">
                                            <tr>
                                                <th style="color: #fff;">Delegación</th>
                                                <th style="color: #fff; text-align: center;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sedes as $sede)
                                                <tr>
                                                    <td>{{$sede instanceof \App\Models\Sedes ? ($sede->delegacion ?? $sede->nombre ?? $sede->name ?? '') : $sede}}</td>
                                                    <td class="text-center">
                                                        <a type="button" class="btn btn-success text-white">Agregar</a>
                                                        <a type="button" class="btn btn-info text-white">Editar</a>
                                                        <a type="button" class="btn btn-danger text-white">Borrar</a>
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
@endsection

<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../../public/js/estadistica/estadistica.js"></script>
@endsection