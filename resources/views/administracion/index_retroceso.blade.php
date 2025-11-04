@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Administración</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @if(session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>¡Contraseña Actualizada!</strong>
                                            {{ session()->get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                            <!--Se realiza la validación de campos para ver si dejó alguno vacío-->
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Revise los campos!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            <!--<span class="badge badge-danger">{{ $error }}</span>-->
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <form id="consulta-form">
                                @csrf
                                <div class="row">
                                    <label>Correción de Ratificacion</label>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <label>Ingresa el Folio</label>
                                        <input type="number" name="folio" class="form-control">
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <label>Ingresa el Año</label>
                                        <input type="number" name="año" class="form-control">
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2"><br>
                                        <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Consultar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div class="modal fade" id="resultadoModal" tabindex="-1" role="dialog" aria-labelledby="resultadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultadoModalLabel">Resultado de la Consulta</h5>
            </div>
            <div class="modal-body" id="modal-body-content">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

<script>
    $(document).ready(function() {
        $('#consulta-form').on('submit', function(e) {
            e.preventDefault(); // Detiene el envío normal del formulario

            $.ajax({
                url: "{{ route('tu.ruta.consulta') }}", // Asegúrate de que esta ruta esté definida
                method: 'POST',
                data: $(this).serialize(), // Serializa todos los campos del formulario
                dataType: 'json', // Esperamos una respuesta JSON
                success: function(response) {
                    if(response.success) {
                        // Limpia y llena el contenido del modal
                        let htmlContent = `
                            <p>ID: <strong>${response.data.id}</strong></p>
                            <p>Nombre: <strong>${response.data.nombre}</strong></p>
                            <p>Email: <strong>${response.data.email}</strong></p>
                        `;
                        $('#modal-body-content').html(htmlContent);

                        // Muestra el modal
                        $('#resultadoModal').modal('show');
                    } else {
                        alert(response.message || 'Registro no encontrado');
                    }
                },
                error: function(xhr, status, error) {
                    // Manejo de errores
                    alert('Ocurrió un error en la consulta.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>