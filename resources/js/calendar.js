import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list'

export function dashboardCalendar(events, locale) {
    return {
        currentView: 'dayGridMonth',
        calendar: null,

        init() {
            this.calendar = new Calendar(this.$refs.calendarEl, {
                plugins: [dayGridPlugin, listPlugin],
                initialView: this.currentView,
                locale: locale ?? 'fr',
                events,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: '',
                },
                noEventsText: 'Aucun événement',
                viewDidMount: (info) => {
                    this.currentView = info.view.type
                },
                eventClick(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault()
                        window.location.href = info.event.url
                    }
                },
            })
            this.calendar.render()
        },

        changeView(view) {
            this.currentView = view
            this.calendar.changeView(view)
        },
    }
}
