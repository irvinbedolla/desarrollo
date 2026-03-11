@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cumplimientos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table-striped" style="width:100%">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Hora</th>
                                            <th style="color: #fff;">Número de Expediente</th>
                                            <th style="color: #fff;">Tipo</th>
                                            <th style="color: #fff;">Descripción</th>
                                            <th style="color: #fff;">Detalles</th>
                                        </thead>
                                        <tbody class="contenidobusqueda">
                                            @foreach($cumplimientos as $audiencia)
                                                <tr>
                                                    <td>{{ $audiencia->fecha_formateada }}</td>
                                                    <td>{{ $audiencia->hora_formateada }}</td>
                                                    <td>{{$audiencia->NUE_FINAL}}</td>
                                                    <td>{{$audiencia->tipo_pago}}</td>
                                                    <td>{{$audiencia->descripcion}}</td>
                                                    <td><a class="btn btn-primary" href="{{ route('audiencia_cumplimientos', $audiencia->id_solicitud) }}">Cumplimiento</a></td>
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