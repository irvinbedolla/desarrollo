document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

        dateClick:function(){
            $('#evento').modal('show');
        }
    });
    calendar.render();
});   