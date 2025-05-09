document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'citas/eventos',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        },
        dateClick:function(){
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