import Vue from 'vue';
import App from './App.vue';

import vuetify from './plugins/vuetify';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';

import router from "./router";

// コンポーネントのグローバル登録
import VSelectMembers from "./components/VSelectMembers";
Vue.component("v-select-members", VSelectMembers);

Vue.config.productionTip = true;

new Vue({
    router,
    vuetify,
    render: h => h(App),
}).$mount('#app');