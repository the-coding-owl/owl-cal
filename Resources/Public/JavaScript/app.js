const options = {
    data() {
        return {
            calendars: {}
        }
    },
    methods: {
        toggleCalendar(calendar) {

        }
    }
};

const calendarApp = Vue.createApp(options);
calendarApp.component('navigation', {
    data() {

    }
});

document.addEventListener('DOMContentLoaded', () => {
    const vm = calendarApp.mount('#owl-cal');
}, false);

