/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Vuetify from "vuetify";
import VueSweetalert2 from "vue-sweetalert2";
import DatetimePicker from 'vuetify-datetime-picker'
import 'vuetify/dist/vuetify.min.css'
import helper from "./helper";
import bus from "./bus";
import moment from "moment";

Vue.use(Vuetify);
Vue.use(helper);
Vue.use(bus);
Vue.use(DatetimePicker);
Vue.use(moment);
Vue.use(VueSweetalert2);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dashboard-manager', require('./components/Dashboard/Manager.vue').default);
Vue.component('add-booking', require('./components/Booking/AddBooking.vue').default);
Vue.component('edit-booking', require('./components/Booking/EditBooking.vue').default);
Vue.component('booking-list', require('./components/Front/BookingList.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: () => ({
        drawer: null
    }),

    methods: {
        logoutMethod(logoutUrl) {
            axios.post(logoutUrl).then(() => {
                window.location.href = '/';
            });
        }
    }
});
