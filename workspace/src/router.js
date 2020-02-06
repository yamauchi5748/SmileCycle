import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter)

import Login from "@/components/PageLogin";
import Main from "@/components/PageMain";
import NotFound from "@/components/PageNotFound"
import Profile from "@/components/profile/Profile";
import ProfileInformation from "@/components/profile/Information";
import ProfileTimeline from "@/components/profile/Timeline";
import ProfileSettings from "@/components/profile/Settings";
import Chat from "@/components/chat/Chat";
import Invitations from "@/components/invitations/Invitations";
import Timelines from "@/components/timelines/Timelines";
import Members from "@/components/members/Members"
import Controls from "@/components/controls/Controls";
import ControlsInvitations from "@/components/controls/Invitations"
import ControlsTimeline from "@/components/controls/Timeline";
import ControlsMembers from "@/components/controls/OMembers";
import ControlsCompanies from "@/components/controls/Companies";
import ControlsStamps from "@/components/controls/Stamps";
const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/",
            name: "main",
            component: Main,
            redirect: { name: "invitations" },
            meta: { requireAuth: true },
            children: [
                {
                    path: "profile",
                    name: "profile",
                    component: Profile,
                    redirect: { name: "profile-information" },
                    children: [
                        {
                            path: "information",
                            name: "profile-information",
                            component: ProfileInformation
                        },
                        {
                            path: "timelines",
                            name: "profile-timelines",
                            component: ProfileTimeline
                        },
                        {
                            path: "settings",
                            name: "profile-settings",
                            component: ProfileSettings
                        },
                    ]
                },
                {
                    path: "/chat",
                    name: "chat",
                    component: Chat
                },
                {
                    path: "/chat/:id",
                    name: "chat-room",
                    component: Chat
                },
                {
                    path: "/invitations",
                    name: "invitations",
                    component: Invitations
                },
                {
                    path: "/timelines",
                    name: "timelines",
                    component: Timelines
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
                    redirect: { name: "controls-invitations" },
                    meta: { requireAdmin: true },
                    children: [
                        {
                            path: "invitations",
                            name: "controls-invitations",
                            component: ControlsInvitations
                        },
                        {
                            path: "timelines",
                            name: "controls-timelines",
                            component: ControlsTimeline
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
        },
        {
            path: "*",
            component: NotFound,
        }
    ]
    , scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    }
});
import { auth } from "@/store";
window.auth = auth;
router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requireAuth);
    const requiresAdmin = to.matched.some(record => record.meta.requireAdmin);
    if (!requiresAuth) return next();
    if (!auth.isInitialized) await auth.init();
    if (!auth.user._id) return next({ name: "login" });
    if (requiresAdmin && !auth.user.isAdmin) return next({ name: "main" });
    return next();
})
export default router