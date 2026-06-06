import { Fancy } from './fancybox.js'
import { dashboardCalendar } from './calendar.js'

document.addEventListener('alpine:init', () => {
    Alpine.data('dashboardCalendar', dashboardCalendar)
})

Fancy.appFancyBox();
