import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Controls from "./components/controls/Controls";
import ControlsMember from "./components/controls/Member";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/controls/",
            component: Controls,
            children: [
                {
                    path: "member",
                    name: "controls-member",
                    component: ControlsMember
                }
            ]
        }
    ]
});

Vue.component('home-component', require('./components/TheHomeComponent.vue').default);

const app = new Vue({
    router,
    el: '#app'
});