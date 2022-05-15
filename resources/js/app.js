require('./bootstrap');
import Vue from 'vue'
window.Vue = require('vue').default;
import vuetify from './vuetify';
import router from './router/index';
import App from './views/App';
import store from './store';

function leadingZero(number) {
    return (number < 10 ? '0' : '') + number;
}

Vue.prototype.$moment = function(timestamp) {
    return {
        format: function(format) {
            let date = new Date(timestamp);
            let hours = leadingZero(timestamp < 90000000 ? date.getUTCHours() : date.getHours());
            let minutes = leadingZero(date.getMinutes());
            let seconds = leadingZero(date.getSeconds());
            let fullTime = hours + ':' + minutes + ':' + seconds;

            if (format === 'fullDateForEarlierDates') {
                let today = new Date().setHours(0, 0, 0);
                if (timestamp >= today) {
                    format = 'fullTime';
                } else {
                    format = 'fullDate';
                }
            }

            if (format === 'fullDate') {
                let dateOfMonth = leadingZero(date.getDate());
                let month = leadingZero(date.getMonth() + 1);
                let year = date.getFullYear();
                return dateOfMonth + '.' + month + '.' + year;
            } else if (format === 'fullDateTime') {
                let dateOfMonth = leadingZero(date.getDate());
                let month = leadingZero(date.getMonth() + 1);
                let year = date.getFullYear();
                return dateOfMonth + '.' + month + '.' + year + ' ' + fullTime;
            } else if (format === 'HH:mm:ss' || format === 'fullTime') {
                return fullTime;
            } else if (format === 'mm:ss') {
                return minutes + ':' + seconds;
            }
        }
    }
}

let currentRouteName = null;

router.beforeEach((to, from, next) => {
    // Progress bar - show.
    router.app.showProgressBar = true;
    console.log(`${from.name} -> ${to.name}`)
    currentRouteName = `${to.name}`
    console.log('current route name: ', currentRouteName)
    next()
})

router.afterEach(() => {
    // Progress bar - hide.
    router.app.showProgressBar = false;
})

new Vue({
    data() {
        return {
            showProgressBar: false,
        }
    },
    router,
    store,
    vuetify,
    render: h => h(App)
}).$mount('#app');
