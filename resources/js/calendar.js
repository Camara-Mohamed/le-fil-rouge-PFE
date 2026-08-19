export function dashboardCalendar(events, locale) {
    return {
        currentView: 'dayGridMonth',
        calendar: null,

        async init() {
            const [{ Calendar }, { default: dayGridPlugin }, { default: listPlugin }] = await Promise.all([
                import('@fullcalendar/core'),
                import('@fullcalendar/daygrid'),
                import('@fullcalendar/list'),
            ])

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
