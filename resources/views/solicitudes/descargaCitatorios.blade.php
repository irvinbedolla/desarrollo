@extends('layouts.app_editar')

@section('content')

  
    <section class="section"> 
        <div class="section-header">
            <h3 class="page__heading">Citatorios a entregar por el trabajador</h3>
        </div>
        <div class="section-body">
            <div class="row"> 
                <div class="col-lg-12" >
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="table-responsive">
                                        <table id="tabla_solicitud" class="table-striped" style="margin: 0 center; text-align:center; width:100%;">
                                            <tbody>
                                                @foreach($citados as $citado)
                                                    <tr>
                                                        <td style="text-align: left;">
                                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                                <div class="form-group">
                                                                    <span>{{ $citado->nombre }} {{ $citado->primer_apellido }} {{ $citado->segundo_apellido }}</span>   
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                                <div class="form-group">
                                                                    <a class="btn btn-success" href="{{ route('PDFSolicitud', $citado->id) }}" class="btn btn-success btn-sm" style="background-color:#920808; border-color:#920808;">Descargar</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> 
                                    <div class="text-center mt-3">
                                        <button type="button" class="btn btn-warning open-citatoriosT-modal" data-bs-toggle="modal" data-bs-target="#citatoriosTrabajador" data-id="{{ $citado->id_solicitud }}">
                                            Subir citatorios firmados
                                        </button>
                                    </div>
                                </div> 
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
<div class="modal fade" id="citatoriosTrabajador" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <form class="needs-validation" method="POST" action="{{ route('subir_citatoriosT') }}" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="citatorioT_id" id="citatorioT_id">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Subir citatorios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="documentoCitatoriosT" class="form-label">Documento en PDF</label>
                        <input type="file" name="documentoCitatoriosT" id="documentoCitatoriosT" class="form-control" accept=".pdf" required>
                        <div class="invalid-feedback">
                            El documento es obligatorio.
                        </div>
                    </div>
                </div>
                <div  class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group"><br>
                        <label for="name">Nombre del archivo<span style="color:red;">(*)</span></label>
                        <input type="text" name="nombreCitatoriosT" class="form-control" required> 
                        <div class="invalid-feedback">
                            El nombre para el archivo es obligatorio.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Subir</button>
                </div>
            </div>
        </div>
    </form>
</div>
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll('.open-citatoriosT-modal');
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                document.getElementById('citatorioT_id').value = id;
            });
        });
    });
</script>
@endsection