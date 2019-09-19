import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap');

Vue.use(VueRouter)

import Controls from "./components/controls/Controls";

import ControlsInvitation from "./components/controls/Invitation";
import ControlsMember from "./components/controls/Member";
import ControlsCompany from "./components/controls/Company";

import Chat from "./components/controls/Chat";

import ChatGroup from "./components/controls/ChatGroup";
import ChatMember from "./components/controls/ChatMember";
import RoomDetails from "./components/controls/RoomDetails";

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
        },

        {
            path: "/chat/",
            component: Chat,
            children: [
                {
                    path: "group",
                    name: "chat-group",
                    components: {
                        default: ChatGroup,
                        details: RoomDetails
                    }
                },
                {
                    path: "member",
                    name: "chat-member",
                    component: ChatMember
                },
                {
                    path: "details",
                    name: "room-details",
                    component: RoomDetails
                }
            ]
        },
    ]
});

Vue.component('home-component', require('./components/TheHomeComponent.vue').default);

const app = new Vue({
    router,
    el: '#app'
});
