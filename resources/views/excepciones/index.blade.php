@extends('layouts.app')


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
                            
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2">
                                    <thead style="background-color: #4A001F;">
                                        <th style="color: #fff;">ID</th>
                                        <th style="color: #fff;">Nombre</th>
                                        <th style="color: #fff;">Tipo de Caso</th>
                                        <th style="color: #fff;">Grupos Vulnerable</th>
                                        <th style="color: #fff;">Delegación</th>
                                        <th style="color: #fff;"></th>
                                    </thead>
                                    <tbody>
                                        @foreach($recepciones as $recepcion)
                                            <tr>
                                                <td>{{$recepcion->id}}</td>
                                                <td>{{$recepcion->solicitante}}</td>
                                                <td>{{$recepcion->tipo_caso}}</td>
                                                <td>{{$recepcion->vulnerables}}</td>
                                                <td>{{$recepcion->delegacion}}</td>
                                                <td><a class="btn btn-warning" href="{{ route('atender_excepcion' , $recepcion->id)}}"  onclick=crear_turnos();>Atender</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
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
    <script src="../public/js/turnos/turnos.js"></script>
@endsection