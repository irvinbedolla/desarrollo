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

                            {{-- Buscador Backend (Garantiza buscar registros no cargados en la página actual) --}}
                            <form action="{{ url()->current() }}" method="GET" class="mb-4">
                                <div class="input-group" style="max-width: 450px;">
                                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por NUE en servidor..." value="{{ request('buscar') }}">
                                    <button class="btn btn-primary" type="submit" style="background-color: #4A001F; border-color: #4A001F;">
                                        <i class="fas fa-search me-1"></i> Buscar en BD
                                    </button>
                                    @if(request('buscar'))
                                        <a href="{{ url()->current() }}" class="btn btn-secondary ms-1">Limpiar</a>
                                    @endif
                                </div>
                            </form>

                            {{-- Tabla con DataTables --}}
                            <div class="table-responsive">
                                <table id="example" class="table table-striped w-100">
                                    <thead style="background-color: #4A001F;">
                                        <th style="color: #fff;">Fecha</th>
                                        <th style="color: #fff;">Hora</th>
                                        <th style="color: #fff;">Número de Expediente</th>
                                        <th style="color: #fff;">Tipo</th>
                                        <th style="color: #fff;">Estatus</th>
                                        <th style="color: #fff;">Detalles</th>
                                    </thead>
                                    <tbody class="contenidobusqueda">
                                        @foreach($cumplimientos as $audiencia)
                                            <tr>
                                                <td>{{ $audiencia->fecha_formateada }}</td>
                                                <td>{{ $audiencia->hora_formateada }}</td>
                                                <td><strong>{{ $audiencia->NUE_FINAL }}</strong></td>
                                                <td>{{ $audiencia->tipo_pago }}</td>
                                                <td>
                                                    @if($audiencia->estatus == 'Pagado')
                                                        <span class="badge badge-success">Pagado</span>
                                                    @elseif($audiencia->estatus == 'Incumplimiento')
                                                        <span class="badge badge-danger">Incumplimiento</span>
                                                    @else
                                                        <span class="badge badge-warning">Pendiente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="{{ route('pago_cumplimiento', $audiencia->id) }}">
                                                        Cumplimiento
                                                    </a>
                                                </td>
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

@section('scripts')
    <script src="../public/assets/js/usuarios/usuarios.js"></script>
    <script>
        $(document).ready(function() {
            // Destruir instancia previa si existe para evitar el error 'Cannot reinitialise DataTable'
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            $('#example').DataTable({
                "destroy": true,
                "searching": false, // <--- DESACTIVA EL BUSCADOR DEL LADO DERECHO (Search:)
                "order": [[ 0, "desc" ]],
                
                // TRADUCCIÓN LOCAL (Evita descargas externas de CDN y soluciona el error i18n por CSP)
                "language": {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "infoPostFix": "",
                    "search": "Buscar:",
                    "url": "",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
@endsection