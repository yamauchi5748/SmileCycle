import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap');

Vue.use(VueRouter)

import Controls from "./components/controls/Controls";

import ControlsInvitation from "./components/controls/Invitation";
import ControlsMember from "./components/controls/Member";
import ControlsCompany from "./components/controls/Company";

import Chat from "./components/chats/Chat";

import ChatGroup from "./components/chats/ChatGroup";
import ChatMember from "./components/chats/ChatMember";
import RoomDetails from "./components/chats/RoomDetails";

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
            path: "/chats/",
            component: Chat,
            redirect: "/chats/group/",
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
                    components: {
                        default: ChatMember,
                        details: RoomDetails
                    }
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
