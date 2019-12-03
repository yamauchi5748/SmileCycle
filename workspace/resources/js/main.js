import Vue from 'vue';
import App from './App.vue';

import vuetify from './plugins/vuetify';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';

import router from "./router";

// コンポーネントのグローバル登録
import VSelectMembers from "./components/VSelectMembers";
Vue.component("v-select-members", VSelectMembers);

const dateFormat = (date, format) => {
    const _fmt = {
        "yyyy": function (date) { return date.getFullYear() + ''; },
        "MM": function (date) { return ('0' + (date.getMonth() + 1)).slice(-2); },
        "dd": function (date) { return ('0' + date.getDate()).slice(-2); },
        "hh": function (date) { return ('0' + date.getHours()).slice(-2); },
        "mm": function (date) { return ('0' + date.getMinutes()).slice(-2); },
        "ss": function (date) { return ('0' + date.getSeconds()).slice(-2); }
    }
    const _priority = ["yyyy", "MM", "dd", "hh", "mm", "ss"]
    return _priority.reduce((res, fmt) => res.replace(fmt, _fmt[fmt](date)), format);
}

Vue.filter('date_format', function (date, format = "yyyy年MM月dd日 hh:mm") {
    if (!date) return '';
    return dateFormat(new Date(date.toDate()), format);
})

Vue.config.productionTip = true;

new Vue({
    router,
    vuetify,
    render: h => h(App),
}).$mount('#app');