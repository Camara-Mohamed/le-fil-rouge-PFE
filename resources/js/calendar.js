import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list'

export function dashboardCalendar(events, locale) {
    return {
        init() {
            const calendar = new Calendar(this.$el, {
                plugins: [dayGridPlugin, listPlugin],
                initialView: 'listMonth',
                locale: locale ?? 'fr',
                events,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth',
                },
                noEventsText: 'Aucun événement',
                eventClick(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault()
                        window.location.href = info.event.url
                    }
                },
            })
            calendar.render()
        },
    }
}
