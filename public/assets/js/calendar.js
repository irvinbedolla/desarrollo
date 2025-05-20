document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridWeek',
        locale: 'esLocale',
        events: 'citas/eventos',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
            //, 'timeGridWeek'
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

        eventClick: function(info) {
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
        },

        eventDidMount: function(info) {
            const titleElement = info.el.querySelector('.fc-event-title');
            if (titleElement) {
                titleElement.style.whiteSpace = 'normal';
            }
        }
    });
    calendar.render();
});   