require('./bootstrap');

window.Vue = require('vue');

Vue.component('home-component', require('./components/TheHomeComponent.vue').default);

const app = new Vue({
    el: '#app',
});