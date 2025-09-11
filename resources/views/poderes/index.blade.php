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
                                <a class="btn btn-warning" href="{{ route('poder-crear') }}" target="_blank"> Nuevo</a>
                            @endcan
                            
                            @can('ver-abogado')
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Tipo Persona</th>
                                            <th style="color: #fff;">Representante</th>
                                            <th style="color: #fff;">Nombre/Razon</th>
                                            <th style="color: #fff;">Telefono</th>
                                            <th style="color: #fff;">Email</th>
                                            <th style="color: #fff;">Fecha Vigencia</th>
                                            <th style="color: #fff;">Vigencia Representación</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Identificación del patrón</th>
                                            <th style="color: #fff;">Identificacion representante</th>
                                            <th style="color: #fff;">Poder/</th>
                                            <th style="color: #fff;">Anexo</th>
                                            <th style="color: #fff;"></th>
                                            <th style="color: #fff;"></th>
                                            <th style="color: #fff;"></th>
                                        </thead>
                                        <tbody>
                                            @foreach($poderes as $persona)
                                                <tr>
                                                    <td>{{$persona->idAbogado}}</td>
                                                    <td>{{$persona->tipo}}</td>
                                                    <td>{{$persona->reprecentante}}</td>
                                                    <td>
                                                        @if($persona->tipo == "Fisica")
                                                            {{$persona->nombres_patronal." ".$persona->primer_apellido_patronal." ".$persona->segundo_apellido_patronal }}
                                                        @elseif($persona->tipo == "Moral")
                                                            {{$persona->nombres_patronal}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->tipo == "Fisica")
                                                            {{$persona->telefono_patronal }}
                                                        @elseif($persona->tipo == "Moral")
                                                            {{$persona->numero_representante}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->tipo == "Fisica")
                                                            {{$persona->email_patronal }}
                                                        @elseif($persona->tipo == "Moral")
                                                            {{$persona->correo_representante}}
                                                        @endif
                                                    </td>
                                                    <td>{{$persona->fechaVigencia}}</td>
                                                    <td>
                                                        @if($persona->tipo == "Moral" || ($persona->tipo == "Fisica" && $persona->reprecentante == "Si"))
                                                            @if($persona->fechaVigencia >= $fechaActual)
                                                                Vigente
                                                            @elseif($persona->fechaVigencia  < $fechaActual) 
                                                                Vencido
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{$persona->estatus}}</td>
                                                    <td><a target="_blank" href="../storage/app/documentos_abogados/{{$persona->ineDocumento}}">PDF</a></td>
                                                    <td>
                                                        @if($persona->cedulaDocumento == NULL)
                                                            S/D
                                                        @else
                                                            <a target="_blank" href="../storage/app/documentos_abogados/{{$persona->cedulaDocumento}}">PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->representacionDocumento == NULL)
                                                            S/D
                                                        @else 
                                                            <a target='_blank' href='../storage/app/documentos_abogados/{{$persona->representacionDocumento}}'>PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($persona->cedula === "Sin carta poder")
                                                            S/A
                                                        @else
                                                            <a target='_blank' href='../storage/app/documentos_abogados/{{$persona->cedulaDocumento}}'>PDF</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                         @if($persona->estatus === "Validado")
                                                            <a class="btn btn-info" href="{{ route('PDFregistroAbogado', $persona->idAbogado)}}" target="_blank">Documento</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @can('editar-abogado')
                                                            <a class="btn btn-info" href="{{ route('poderes.edit', $persona->idAbogado)}}" onclick=editar_poder();>Editar</a>
                                                        @endcan
                                                    </td>
                                                    <td>
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
