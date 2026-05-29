import Alpine from 'alpinejs'
import { appFancyBox } from './fancybox.js'
import { dashboardCalendar } from './calendar.js'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.data('dashboardCalendar', dashboardCalendar)
})

Alpine.start()
appFancyBox();
