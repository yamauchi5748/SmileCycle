import Vue from 'vue';
import App from '@/App.vue';
import vuetify from '@/plugins/vuetify';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';

import router from "@/router";

import moment from "moment";
moment.locale("ja")
Vue.filter('fromNow', function (date) {
    if (!date) return "";
    return moment(date).fromNow();
})

new Vue({
    router,
    vuetify,
    render: h => h(App),
}).$mount('#app');
