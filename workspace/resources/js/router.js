import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter)

import Profile from "./components/Profile";
import Chat from "./components/chat/Chat";
import ChatNotFound from "./components/chat/NotFound";
import ChatRoom from "./components/chat/Room";
import Invitations from "./components/invitations/Invitations";
import Forums from "./components/forums/Forums";
import Members from "./components/members/Members"
import Controls from "./components/controls/Controls";
import ControlsInvitations from "./components/controls/Invitations"
import ControlsForums from "./components/controls/Forums";
import ControlsMembers from "./components/controls/Members";
import ControlsCompanies from "./components/controls/Companies";
import ControlsStamps from "./components/controls/Stamps";
const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/profile",
            name: "profile",
            component: Profile
        },
        {
            path: "/chat",
            name: "chat",
            component: Chat,
            children: [
                {
                    path: "",
                    name: "chat-not-found",
                    component: ChatNotFound
                },
                {
                    path: ":id",
                    name: "chat-room",
                    component: ChatRoom,
                }
            ]
        },
        {
            path: "/invitations",
            name: "invitations",
            component: Invitations
        },
        {
            path: "/forums",
            name: "forums",
            component: Forums
        },
        {
            path: "/members",
            name: "members",
            component: Members
        },
        {
            path: "/controls",
            name: "controls",
            component: Controls,
            children: [
                {
                    path: "invitations",
                    name: "controls-invitations",
                    component: ControlsInvitations
                },
                {
                    path: "forums",
                    name: "controls-forums",
                    component: ControlsForums
                },
                {
                    path: "members",
                    name: "controls-members",
                    component: ControlsMembers
                },
                {
                    path: "companies",
                    name: "controls-companies",
                    component: ControlsCompanies
                },
                {
                    path: "stamps",
                    name: "controls-stamps",
                    component: ControlsStamps
                }
            ]
        },
    ]
});
export default router