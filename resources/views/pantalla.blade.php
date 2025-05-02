<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Si concilio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="public/assets_seer/assets/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="public/assets/css/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="public/assets/css/iziToast.min.css" rel="stylesheet">
    <link href="public/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="public/assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
    
    <!-- Agregados para los Select del Formulario Personas-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        let segundos_recarga = 10;
        //let miFecha = new Date();
        //let dato_url = miFecha.getYear().toString() + miFecha.getMonth().toString() + miFecha.getDate().toString() + miFecha.getHours().toString() + miFecha.getMinutes().toString() + miFecha.getSeconds().toString();
        setTimeout( function() {
            //window.location = `recarga-constante.html?parametro=${dato_url}`;
            window.location.href = "{{URL::to('pantalla')}}";
        }, segundos_recarga * 1000);
    </script>

    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('public/assets/images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
</style>

    @livewireStyles


    @yield('page_css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="public/web/css/style.css">
    <link rel="stylesheet" href="public/web/css/components.css">
    @yield('page_css')

    @yield('css')
</head>

                <div id="app">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                    <div class="row">
                                        <ul class="navbar-nav flex-grow-1 justify-content-center">
                                            <li class="nav-item text-center">
                                                <img src="public/assets_seer/images/logos.png" alt="" style="max-width: 25%; height: auto;">
                                            </li>
                                        </ul>
                                        <div class="section-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="tabla_usuarios" class="table table-striped mt-2">
                                                                    <thead style="background-color: #4A001F;">
                                                                        <th style="color: #fff; text-align: center;">Folio</th>
                                                                        <th style="color: #fff; text-align: center;">Auxiliar</th>
                                                                        <th style="color: #fff; text-align: center;">Tramite</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($turnos as $turno)
                                                                            <tr>
                                                                                <td style="text-align: center;">{{$turno->id}}</td>
                                                                                <td style="text-align: center;">{{$turno->lugar_auxiliar}}</td>
                                                                                <td style="text-align: center;">{{$turno->tipo}}</td>
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
    <script src="public/js/general/menu.js"></script>
@endsection

@include('profile.change_password')
@include('profile.edit_profile')

</body>



    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/popper.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <script src="public/assets/js/sweetalert.min.js"></script>
    <script src="public/assets/js/select2.min.js"></script>
    <script src="public/assets/js/jquery.nicescroll.js"></script>

    <!-- Template JS File -->
    <script src="public/web/js/stisla.js"></script>
    <script src="public/web/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom/custom.js"></script>
@yield('page_js')
@yield('scripts')
<script>
    let loggedInUser =@json(\Illuminate\Support\Facades\Auth::user());
    let loginUrl = '{{ route('login') }}';
    const userUrl = '{{url('users')}}';
    // Loading button plugin (removed from BS4)
    (function ($) {
        $.fn.button = function (action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
    }(jQuery));
</script>
</html>


