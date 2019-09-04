import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Controls from "./components/controls/Controls";

import ControlsInvitation from "./components/controls/Invitation";
import ControlsMember from "./components/controls/Member";
import ControlsCompany from "./components/controls/Company";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/controls/",
            component: Controls,
            children: [
                {
                    path: "invitation",
                    name: "controls-invitation",
                    component: ControlsInvitation
                },
                {
                    path: "member",
                    name: "controls-member",
                    component: ControlsMember
                },
                {
                    path: "company",
                    name: "controls-company",
                    component: ControlsCompany
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