
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    @auth
        @role('Super Usuario')
            <a class="nav-link" href="{{ route('usuarios') }}">
                <i class="bi bi-people-fill"></i><span class="text-dark" onclick="usuarios()">Usuarios</span>
            </a>
            <a class="nav-link" href="{{ route('roles') }}">
                <i class="bi bi-person-lines-fill"></i><span class="text-dark" onclick="roles()">Roles</span>
            </a>
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('capacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="capacitaciones()">Capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
            <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Expediente</span>
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-check"></i><span class="text-dark" onclick="revista()">Revista</span>
            </a>
            <a class="nav-link" href="{{ route('seer.estadistica') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">Estadisticas</span>
            </a>
            <a class="nav-link" href="{{ route('turnos') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="turnos()">Turnos</span>
            </a>
            <a class="nav-link" href="{{ route('misturnos') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="turnos()">Mis turnos</span>
            </a>
            <a class="nav-link" href="{{ route('turno_estadistica') }}">
                <i class="bi bi-graph-up"></i><span class="text-dark" onclick="estadistica_turno()">Estadistica turno</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
            <a class="nav-link" href="{{ route('solicitudes_pendientes') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Solicitudes Pendientes</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Administrador')
        <a class="nav-link" href="{{ route('usuarios') }}">
                <i class="bi bi-people-fill"></i><span class="text-dark" onclick="usuarios()">Usuarios</span>
            </a>
            <a class="nav-link" href="{{ route('roles') }}">
                <i class="bi bi-person-lines-fill"></i><span class="text-dark" onclick="roles()">Roles</span>
            </a>
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('capacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="capacitaciones()">Capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
            <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Expediente</span>
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-check"></i><span class="text-dark" onclick="revista()">Revista</span>
            </a>
            <a class="nav-link" href="{{ route('seer.estadistica') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">Estadisticas</span>
            </a>
            <a class="nav-link" href="{{ route('turnos') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="turnos()">Turnos</span>
            </a>
            <a class="nav-link" href="{{ route('misturnos') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="turnos()">Mis turnos</span>
            </a>
            <a class="nav-link" href="{{ route('turno_estadistica') }}">
                <i class="bi bi-graph-up"></i><span class="text-dark" onclick="estadistica_turno()">Estadistica turno</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Auxiliar')
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('seer') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">SEER</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Mi Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('misturnos') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="turnos()">Mis turnos</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
            <a class="nav-link" href="{{ route('solicitudes_pendientes') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Solicitudes Pendientes</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Conciliador')
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <<a class="nav-link" href="{{ route('seer') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">SEER</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Mi Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Notificador')
            <a class="nav-link" href="{{ route('seer') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">SEER</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Mi Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
        @endrole
    @endauth
    
    @auth
        @role('Capacitacion Admin')
            <a class="nav-link" href="{{ route('capacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="capacitaciones()">Capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Delegado')
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('seer.estadistica') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">Estadisticas</span>
            </a>
            <a class="nav-link" href="{{ route('turno_estadistica') }}">
                <i class="bi bi-graph-up"></i><span class="text-dark" onclick="estadistica_turno()">Estadistica turno</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Estadistica')
            <a class="nav-link" href="{{ route('seer.estadistica') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">Estadisticas</span>
            </a>
        @endrole
    @endauth    


    @auth
        @role('Turnos')
            <a class="nav-link" href="{{ route('turnos') }}">
                <i class="fa fa-book" aria-hidden="true"></i></i><span class="text-dark" onclick="turnos()">Turnos</span>
            </a>
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Expediente</span>
            </a>
        @endrole
    @endauth
    
    @auth
        @role('Excepcion')
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('seer') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">SEER</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Mi Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('misturnos') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="turnos()">Mis turnos</span>
            </a>
        @endrole
    @endauth

    @auth
        @role('Enlace')
            <a class="nav-link" href="{{ route('poderes') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="poderes()">Poderes</span>
            </a>
            <a class="nav-link" href="{{ route('seer') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">SEER</span>
            </a>
            <a class="nav-link" href="{{ route('miscapacitaciones') }}">
                <i class="bi bi-backpack4-fill"></i><span class="text-dark" onclick="mis_capacitaciones()">Mis capacitaciones</span>
            </a>
            <a class="nav-link" href="{{ route('expedientes') }}">
                <i class="bi bi-graph-down"></i><span class="text-dark" onclick="expedientes()">Mi Expediente</span>
            </a>
            <a class="nav-link" href="{{ route('seer.estadistica') }}">
                <i class="bi bi-clipboard-data-fill"></i><span class="text-dark" onclick="estadistica()">Estadisticas</span>
            </a>
            <a class="nav-link" href="{{ route('persona.historial') }}">
                <i class="bi bi-file-person"></i><span class="text-dark" onclick="consultar_estadistica()">Historial</span>
            </a>
        @endrole
    @endauth
    @auth
        @role('Solicitante')
            <a class="nav-link" href="{{ route('ratificacion') }}">
                <i class="bi bi-bank"></i><span class="text-dark" onclick="mis_citas()">Mis ratificaciones</span>
            </a>
        @endrole
    @endauth
</li>


