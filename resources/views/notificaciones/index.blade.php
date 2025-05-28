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
                                                <th style="color: #fff;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                @foreach($notificaciones as $estadistica)
                                                    <tr>
                                                        <td style="display: none;">{{$estadistica->id_solicitud}}</td>
                                                        <td>{{$estadistica->NUE}}</td>
                                                        <td>{{$estadistica->nombre}}</td>
                                                        <td>{{$estadistica->colonia}}</td>
                                                        <td>{{$estadistica->estatus}}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('seer.store_enlace') }}" class="needs-validation novalidate">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$estadistica->id_citado}}">
                                                                <select class="form-control" name="notificador">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach($personas as $persona)
                                                                        <option value="{{$persona->id}}">{{$persona->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <button type="submit" class="btn btn-primary">Asignar</button>
                                                                </div>
                                                            </form>
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
    <!-- Modal -->
        <div class="modal fade" id="modal_verCitados" tabindex="-1" role="dialog" aria-labelledby="CitadosModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">CITADOS</h5>
                    </div>
                <div class="modal-body">  
                    <div id="citados" class="tabcontent">
                        <div class="table-responsive">
                            <div id="T_citados" class="table table-striped mt-1"> 
                        
                                <table id="tabla_citados" class="table table-striped mt-1">
                                    <thead style="background-color:;">
                                        <th style="display: none;">ID</th>
                                        <th style="color: #fff;">Citado</th>
                                        <th style="color: #fff;">Dirección</th>
                                    </thead>
                                    <tbody  id="m_citados">
                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Fin Modal -->
    
@endsection




