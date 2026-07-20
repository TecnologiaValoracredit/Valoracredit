import { Calendar } from '@fullcalendar/core'
import interactionPlugin from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid'
import rrulePlugin from '@fullcalendar/rrule'


const calendarEl = document.getElementById('calendar')
const calendar = new Calendar(calendarEl, {
plugins: [
    dayGridPlugin,
    rrulePlugin,
],
locale: 'es',
weekends: true,
initialView: 'dayGridMonth',
editable: true,
buttonText: {
    today: 'Hoy',
    month: 'Mes',
    week: 'Semana',
    day: 'Día',
    list: 'Lista'
},
buttonHints: {
    prev: 'Mes anterior',
    next: 'Mes siguiente',
    today: 'Ir a hoy',
},
eventDidMount(info) {
    info.el.setAttribute('data-bs-toggle', 'tooltip');
    info.el.setAttribute(
        'data-bs-title',
        info.event.extendedProps.description
    );

    new bootstrap.Tooltip(info.el);
},
events: '/calendar_events',
})

calendar.render()

function capitalize(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
}