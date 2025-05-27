var calendar;

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridWeek',
        locale: 'es',
        //events: 'citas/eventos',
        events: 'pagos/eventos',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
            //, 'timeGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mensual',
            week: 'Semanal'
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        },

        eventContent: function(info) {
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

        /*eventClick: function(info) {
            const props = info.event.extendedProps;
            $('.modal-body').html(`
                <strong>Motivo:</strong> ${info.event.title}<br>
                <strong>Fecha:</strong> ${props.fecha}<br>
                <strong>Hora:</strong> ${props.hora}<br>
                <strong>Estatus:</strong> ${props.estatus}<br>
                <strong>Tipo:</strong> ${props.tipo}<br>
                <strong>Usuario:</strong> ${props.usuario}
            `);
            $('#evento').modal('show');
        },*/

        eventClick: function(info){
            const props = info.event.extendedProps;
            $('.modal-body').html(`
                <strong>Descripción:</strong> ${props.descripcion}<br>
                <strong>ID:</strong> ${info.event.id}<br>
                <strong>Fecha:</strong> ${props.fecha}<br>
                <strong>Hora:</strong> ${props.hora}<br>
                <strong>Empresa:</strong> ${props.empresa}<br>
                <strong>Trabajador:</strong> ${props.trabajador}<br>
                <strong>Estatus:</strong> ${props.estatus}<br>
                <strong>Monto:</strong> ${props.monto}<br>
                <strong>Observaciones:</strong> ${props.observaciones}<br>
            `);
            $('#evento').modal('show');
        },

        eventDidMount: function(info) {
            const titleElement = info.el.querySelector('.fc-event-title');
            if (titleElement) {
                titleElement.style.whiteSpace = 'normal';
                titleElement.style.textAlign = 'left';
            }
        }
    });
    calendar.render();

    document.getElementById('btn-actualizar').addEventListener('click'), function() {
        updateCalendar();
    }
});

function updateCalendar() {
    calendar.render();
    calendar.refetchEvents();
}