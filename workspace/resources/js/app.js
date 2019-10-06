import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap');

Vue.use(VueRouter)
import NewChat from "./components/chat/Chat.vue";
import ChatRoom from "./components/chat/ChatRoom.vue";
import CreateChatRoom from "./components/chat/CreateRoomModal.vue";

import Chat from "./components/chats/Chat.vue";
import ChatGroup from "./components/chats/ChatGroup.vue";
import ChatMember from "./components/chats/ChatMember.vue";
import RoomDetails from "./components/chats/RoomDetails.vue";
import Members from "./components/members/Members.vue";
import Controls from "./components/controls/Controls.vue";
import ControlsInvitation from "./components/controls/Invitation.vue";
import ControlsInvitationCreate from "./components/controls/InvitationCreate.vue";
import ControlsInvitationDetails from "./components/controls/InvitationDetails.vue";
import ControlsForum from "./components/controls/Forum.vue"
import ControlsForumDetails from "./components/controls/ForumDetails.vue";
import ControlsMember from "./components/controls/Member.vue";
import ControlsMemberCreate from "./components/controls/MemberCreate.vue";
import ControlsMemberDetails from "./components/controls/MemberDetails.vue";
import ControlsCompany from "./components/controls/Company.vue";
import ControlsCompanyCreate from "./components/controls/CompanyCreate.vue";
import ControlsCompanyDetails from "./components/controls/CompanyDetails.vue";
import ControlsStamp from "./components/controls/Stamp.vue";
import ControlsStampCreate from "./components/controls/StampCreate.vue";
import ControlsStampDetails from "./components/controls/StampDetails.vue";
import Axios from 'axios';
const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/chat-rooms",
            component: NewChat,
            children: [
                {
                    path: ":id",
                    name: "chat-room",
                    component: ChatRoom
                },
                {
                    path: "room/create",
                    name: "chat-room-create",
                    component: CreateChatRoom
                },
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
        {
            path: "/members",
            component: Members
        },
        {
            path: "/controls",
            component: Controls,
            children: [
                {
                    path: "invitation",
                    name: "controls-invitation",
                    component: ControlsInvitation
                },
                {
                    path: "invitation/create",
                    name: "controls-invitation-create",
                    component: ControlsInvitationCreate
                },
                {
                    path: "invitation/:id",
                    name: "controls-invitation-details",
                    component: ControlsInvitationDetails
                },
                {
                    path: "forum",
                    name: "controls-forum",
                    component: ControlsForum
                },
                {
                    path: "forum/:id",
                    name: "controls-forum-details",
                    component: ControlsForumDetails
                },
                {
                    path: "member",
                    name: "controls-member",
                    component: ControlsMember
                },
                {
                    path: "member/create",
                    name: "controls-member-create",
                    component: ControlsMemberCreate
                },
                {
                    path: "member/:id",
                    component: ControlsMemberDetails
                },
                {
                    path: "company",
                    name: "controls-company",
                    component: ControlsCompany
                },
                {
                    path: "company/create",
                    name: "controls-company-create",
                    component: ControlsCompanyCreate
                },
                {
                    path: "company/:id",
                    component: ControlsCompanyDetails
                },
                {
                    path: "stamp",
                    name: "controls-stamp",
                    component: ControlsStamp,
                },
                {
                    path: "stamp/create",
                    name: "controls-stamp-create",
                    component: ControlsStampCreate,
                },
                {
                    path: "stamp/:id",
                    component: ControlsStampDetails,
                }
            ]
        },
    ]
});

Vue.component('home-component', require('./components/TheHomeComponent.vue').default);

const app = new Vue({
    router,
    el: '#app',
    data: {
        member_list: [],
        company_list: [],
        stamp_group_list: [],
        chat_room_list: [],
    },
    methods: {
        /* レスポンスの認証チェック */
        checkAuth: function (res) {
            if (res.data.auth) {
                return res;
            }
            /* エラー */
            return Promise.reject('認証エラー');
        },

        /* 会員一覧取得 */
        loadMembers: function () {
            return axios.get('/api/members')
                .then(res => this.checkAuth(res))
                .then(res => {
                    this.member_list = res.data.members;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        createMember: function (member_property) {
            return axios.post('/api/members', member_property)
                .then(res => this.checkAuth(res))
        },
        /* 特定会員取得 */
        getMember: function (member_id) {
            return axios.get('/api/members/' + member_id)
                .then(res => this.checkAuth(res))
                .catch(error => {
                    console.log(error);
                });
        },

        /* 会社一覧取得 */
        loadCompanies: function () {
            return axios.get('/api/companies')
                .then(res => this.checkAuth(res))
                .then(res => {
                    this.company_list = res.data.companies;
                    return res;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* 特定会社取得 */
        getCompany: function (company_id) {
            return axios.get('/api/companies/' + company_id)
                .then(res => this.checkAuth(res))
                .catch(error => {
                    console.log(error);
                });
        },

        /* スタンプグループ一覧取得 */
        loadAdminStampGroups: function () {
            return axios.get('/api/admin-stamp-groups')
                .then(res => this.checkAuth(res))
                .then(res => {
                    this.stamp_group_list = res.data.stamp_groups;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャットグループ一覧取得 */
        loadChatRooms: function () {
            return axios.get('/api/chat-rooms')
                .then(res => this.checkAuth(res))
                .then(res => {
                    this.chat_room_list = res.data.rooms;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャットグループ作成 */
        createChatRoom: function (data) {
            return axios.post('/api/chat-rooms', data)
                .then(res => this.checkAuth(res))
                .then(res => {
                    console.log(res.data);
                    this.chat_room_list.splice(0, 0, res.data.chat_room);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    }
});

window.app = app;