var calendarPagos, calendarAudiencias, currentCalendar, calendarRatificaciones, calendarConciliador;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    // Configuración del calendario de pagos
    calendarPagos = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
        locale: 'es',
        events: 'pagos/eventos',
        eventSourceSuccess: function (events) {
            console.log(events); // Verifica los datos que se están cargando
            return events;
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mensual',
            week: 'Semanal'
        },
        eventClick: function (info) {
            handleEventClick(info, 'pagos');
        },
        eventDidMount: function (info) {
            styleEvent(info);
        },
        eventContent: function (info) {
            return {
                html: `
                    <div class="fc-event-content">
                        <div class="fc-event-title">${info.event.title}</div>
                        <div class="fc-event-time">
                            <div class="color-indicator" style="background:${info.event.extendedProps.color}"></div>
                            ${info.event.extendedProps.hora}
                        </div>
                    </div>
                `
            };
        },
    });

    // Configuración del calendario de audiencias
    calendarAudiencias = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
        locale: 'es',
        events: 'audiencias/eventos',
        /*eventSourceSuccess: function (events) {
            console.log(events); // Verifica los datos que se están cargando
            return events;
        },*/
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mensual',
            week: 'Semanal'
        },
        eventClick: function (info) {
            handleEventClick(info, 'audiencias');
        },
        eventDidMount: function (info) {
            styleEvent(info);
        },
        eventContent: function (info) {
            return {
                html: `
                    <div class="fc-event-content">
                        <div class="fc-event-title">${info.event.title}</div>
                        <div class="fc-event-time">
                            <div class="color-indicator" style="background:${info.event.extendedProps.color}"></div>
                            ${info.event.extendedProps.hora}
                        </div>
                    </div>
                `
            };
        },
    });

    // Configuración del calendario de ratificaciones
    calendarRatificaciones = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
        locale: 'es',
        events: 'ratificaciones/eventos',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mensual',
            week: 'Semanal'
        },
        eventClick: function (info) {
            handleEventClick(info, 'ratificaciones');
        },
        eventDidMount: function (info) {
            styleEvent(info);
        },
        eventContent: function (info) {
            return {
                html: `
                    <div class="fc-event-content">
                        <div class="fc-event-title">${info.event.title}</div>
                        <div class="fc-event-time">
                            <div class="color-indicator" style="background:${info.event.extendedProps.color}"></div>
                            ${info.event.extendedProps.hora}
                        </div>
                    </div>
                `
            };
        },
    });

    calendarCitas = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
        locale: 'es',
        events: 'citas/eventos',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mensual',
            week: 'Semanal'
        },
        eventClick: function (info) {
            handleEventClick(info, 'citas');
        },
        eventDidMount: function (info) {
            styleEvent(info);
        },
        eventContent: function (info) {
            return {
                html: `
                    <div class="fc-event-content">
                        <div class="fc-event-title">${info.event.title}</div>
                        <div class="fc-event-time">
                            <div class="color-indicator" style="background:${info.event.extendedProps.color}"></div>
                            ${info.event.extendedProps.hora}
                        </div>
                    </div>
                `
            };
        },
    });

    calendarConciliador = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
        locale: 'es',
        events: 'pagos/conciliadores',
        eventSourceSuccess: function (events) {
            console.log(events); // Verifica los datos que se están cargando
            return events;
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mensual',
            week: 'Semanal'
        },
        eventClick: function (info) {
            handleEventClick(info, 'pagos');
        },
        eventDidMount: function (info) {
            styleEvent(info);
        },
        eventContent: function (info) {
            return {
                html: `
                    <div class="fc-event-content">
                        <div class="fc-event-title">${info.event.title}</div>
                        <div class="fc-event-time">
                            <div class="color-indicator" style="background:${info.event.extendedProps.color}"></div>
                            ${info.event.extendedProps.hora}
                        </div>
                    </div>
                `
            };
        },
    });

    currentCalendar = calendarPagos;
    currentCalendar.render();

    /*function updateCalendarView() {
        if (window.innerWidth < 768) {
            calendar.changeView('listWeek');
        } else {
            calendar.changeView('dayGridWeek');
        }
    }*/

    //window.addEventListener('resize', updateCalendarView);

    document.getElementById('btn-conciliador').addEventListener('click', function () {
        switchCalendar(calendarConciliador);
    });

    document.getElementById('btn-pagos').addEventListener('click', function () {
        switchCalendar(calendarPagos);
    });

    document.getElementById('btn-audiencias').addEventListener('click', function () {
        switchCalendar(calendarAudiencias);
    });

    document.getElementById('btn-ratificaciones').addEventListener('click', function () {
        switchCalendar(calendarRatificaciones);
    });

    document.getElementById('btn-citas').addEventListener('click', function () {
        switchCalendar(calendarCitas);
    });

    document.getElementById('btn-actualizar').addEventListener('click', function () {
        if (currentCalendar) {
            currentCalendar.refetchEvents();
        }
    });
});

function switchCalendar(newCalendar) {
    if (currentCalendar) {
        currentCalendar.destroy();
    }
    currentCalendar = newCalendar;
    currentCalendar.render();

    //window.addEventListener('resize', updateCalendarView);
}

function handleEventClick(info, calendarType) {
    const props = info.event.extendedProps;
    let modalContent = '';

    if (calendarType === 'pagos') {
        modalContent = `
            <strong>Descripción:</strong> ${props.descripcion}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Trabajador:</strong> ${props.trabajador}<br>
            <strong>Patronal:</strong> ${props.empresa}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Monto:</strong> ${props.monto}<br>
            <strong>Observaciones:</strong> ${props.observaciones}<br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="cumplimiento/consulta/${info.event.id}/${props.tipo}" class="btn btn-info">Ver detalle</a>
            </div>
        `;
    }
    else if (calendarType === 'conciliador') {
        modalContent = `
            <strong>Descripción:</strong> ${props.descripcion}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Trabajador:</strong> ${props.trabajador}<br>
            <strong>Patronal:</strong> ${props.empresa}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Monto:</strong> ${props.monto}<br>
            <strong>Observaciones:</strong> ${props.observaciones}<br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="cumplimiento/consulta/${info.event.id}/${props.tipo}" class="btn btn-info">Ver detalle</a>
            </div>
        `;
    } else if (calendarType === 'audiencias') {
        modalContent = `
            <strong>Motivo:</strong> ${info.event.title}<br>
            <strong>Numero:</strong> ${props.numero_audiencia}<br>
            <strong>ID:</strong> ${info.event.id}<br>
            <strong>Folio:</strong> ${props.folio_audiencia}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Delegación:</strong> ${props.delegacion}<br>
            <strong>Sala:</strong> ${props.sala}<br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="cumplimiento/consulta${info.event.id}/${props.tipo}" class="btn btn-info">Ver detalle</a>
            </div>
        `;
    }
    else if (calendarType === 'ratificaciones') {
        modalContent = `
            <strong>Motivo:</strong> ${info.event.title}<br>
            <strong>Folio:</strong> ${info.event.id}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Delegación:</strong> ${props.delegacion}<br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="cumplimiento/consulta${info.event.id}/${props.tipo}" class="btn btn-info">Ver detalle</a>
            </div>
        `;
    }
    else if (calendarType === 'citas') {
        modalContent = `
            <strong>Descripción:</strong> ${props.descripcion}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Monto:</strong> ${props.monto}<br>
            <strong>Observaciones:</strong> ${props.observaciones}<br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="cumplimiento/consulta/${info.event.id}/${props.tipo}" class="btn btn-info">Ver detalle</a>
            </div>
        `;
    }

    $('.modal-body').html(modalContent);
    $('#evento').modal('show');
}

// Función para estilizar los eventos
function styleEvent(info) {
    const titleElement = info.el.querySelector('.fc-event-title');
    if (titleElement) {
        titleElement.style.whiteSpace = 'normal';
        titleElement.style.textAlign = 'left';
    }
}
