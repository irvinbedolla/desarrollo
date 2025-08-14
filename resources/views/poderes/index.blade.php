@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Poderes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            

                            @can('crear-abogado')
                                <a class="btn btn-warning" href="{{ route('poderes.create') }}"  onclick=nuevo_poder();> Nuevo</a>
                            @endcan
                            
                            @can('ver-abogado')
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Nombre(s)</th>
                                            <th style="color: #fff;">Primer apellido</th>
                                            <th style="color: #fff;">Segundo apellido</th>
                                            <th style="color: #fff;">Telefono</th>
                                            <th style="color: #fff;">Poder</th>
                                            <th style="color: #fff;">Fecha Vigencia</th>
                                            <th style="color: #fff;">Vigencia Representación</th>
                                            <th style="color: #fff;">Estatus Abogado</th>
                                            <th style="color: #fff;">INE/Cedula</th>
                                            <th style="color: #fff;">Representacion</th>
                                            <th style="color: #fff;">Anexo</th>
                                            <th style="color: #fff;">Anexo 2</th>
                                            <th style="color: #fff;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach($poderes as $persona)
                                                <tr>
                                                    <td>{{$persona->idAbogado}}</td>
                                                    <td>{{$persona->nombres}}</td>
                                                    <td>{{$persona->primer_apellido}}</td>
                                                    <td>{{$persona->segundo_apellido}}</td>
                                                    <td>{{$persona->telefono}}</td>
                                                    <td>{{$persona->empresa}}</td>
                                                    <td>{{$persona->fechaVigencia}}</td>
                                                    @php
                                                    if($persona->fechaVigencia >= $fechaActual){
                                                        echo'<td>Vigente</td>';
                                                    }
                                                    elseif($persona->fechaVigencia  < $fechaActual) {
                                                        echo'<td style="background-color: red;">Vencido</td>';
                                                    }
                                                    @endphp
                                                    <td>{{$persona->estatus}}</td>
                                                    <td><a target="_blank" href="../storage/app/documentos_abogados/{{$persona->ine}}">PDF</a></td>
                                                    <td><a target="_blank" href="../storage/app/documentos_abogados/{{$persona->representacion}}">PDF</a></td>
                                                    @php
                                                    if($persona->anexo === "Sin anexo"){
                                                        echo "<td>S/A</td>";
                                                    }else{ 
                                                        echo "<td><a target='_blank' href='../storage/app/documentos_abogados/$persona->anexo'>PDF</a></td>";
                                                    }
                                                    if($persona->cedula === "Sin carta poder"){
                                                        echo "<td>S/A</td>";
                                                    }else{
                                                        echo "<td><a target='_blank' href='../storage/app/documentos_abogados/$persona->cedula'>PDF</a></td>";
                                                    }
                                                    @endphp

                                                    <td>
                                                        @can('editar-abogado')
                                                            <a class="btn btn-info" href="{{ route('poderes.edit', $persona->idAbogado)}}" onclick=editar_poder();>Editar</a>
                                                        @endcan
                                                        @can('borrar-abogado')
                                                            <form method="POST" action="{{ route('poderes.destroy', $persona->idAbogado) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        @endcan
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

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="../public/js/poderes/general.js"></script>
@endsection
