var calendarPagos, calendarAudiencias, currentCalendar;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    // Configuración del calendario de pagos
    calendarPagos = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridWeek',
        locale: 'es',
        events: 'pagos/eventos',
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
        initialView: 'dayGridWeek',
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

    currentCalendar = calendarPagos;
    currentCalendar.render();

    document.getElementById('btn-pagos').addEventListener('click', function () {
        switchCalendar(calendarPagos);
    });

    document.getElementById('btn-audiencias').addEventListener('click', function () {
        switchCalendar(calendarAudiencias);
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
}

function handleEventClick(info, calendarType) {
    const props = info.event.extendedProps;
    let modalContent = '';

    if (calendarType === 'pagos') {
        modalContent = `
            <strong>Descripción:</strong> ${props.descripcion}<br>
            <strong>ID:</strong> ${info.event.id}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Empresa:</strong> ${props.empresa}<br>
            <strong>Trabajador:</strong> ${props.trabajador}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Monto:</strong> ${props.monto}<br>
            <strong>Observaciones:</strong> ${props.observaciones}<br>
        `;
    } else if (calendarType === 'audiencias') {
        modalContent = `
            <strong>Motivo:</strong> ${info.event.title}<br>
            <strong>Numero:</strong> ${props.numero_audiencia}<br>
            <strong>Folio:</strong> ${props.folio_audiencia}<br>
            <strong>Fecha:</strong> ${props.fecha}<br>
            <strong>Hora:</strong> ${props.hora}<br>
            <strong>Estatus:</strong> ${props.estatus}<br>
            <strong>Tipo:</strong> ${props.tipo}<br>
            <strong>Usuario:</strong> ${props.usuario}<br>
            <strong>Conciliador:</strong> ${props.conciliador}<br>
            <strong>Delegación:</strong> ${props.delegación}<br>
            <strong>Sala:</strong> ${props.sala}<br>
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
