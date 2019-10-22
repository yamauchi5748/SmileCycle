import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap');

Vue.use(VueRouter)
import ChatRooms from "./components/chat/Chat.vue";
import ChatRoom from "./components/chat/ChatRoom.vue";

import Chat from "./components/chats/Chat.vue";
import ChatGroup from "./components/chats/ChatGroup.vue";
import ChatMember from "./components/chats/ChatMember.vue";
import RoomDetails from "./components/chats/RoomDetails.vue";
import Members from "./components/members/Members.vue";
import Invitations from "./components/invitations/Invitations.vue";
import InvitationDetails from "./components/invitations/InvitationDetails.vue";
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
            component: ChatRooms,
            children: [
                {
                    path: ":id",
                    name: "chat-room",
                    component: ChatRoom
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
        {
            path: "/members",
            component: Members
        },
        {
            path: "/invitations",
            component: Invitations,
        },
        {
            path: "/invitations/:id",
            name: "invitation-details",
            component: InvitationDetails,
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
        polling_time: 500,
        author: {},
        member_list: [],
        company_list: [],
        stamp_group_list: [],
        chat_room_list: [],
    },
    created: function () {
        Echo.private('user.' + this.author._id); // プライベートチャンネル接続

        this.$root.loadChatRooms().then(res => {
            for (const index in this.chat_room_list) {
                const channel = 'room.' + this.chat_room_list[index]._id;
                this.connect(channel);  // チャットルームのチャンネルに接続
            }
        });
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

        /* チャンネル接続 */
        connect: function (channel) {
            Echo.join(channel)
                .here((users) => {
                    console.log("参加しました");
                })
                .listen('ChatRecieved', (data) => {
                    console.log('チャット受信', data);

                    // 受信チャットの処理
                    for (const index in this.chat_room_list) {
                        const room = this.chat_room_list[index];
                        if (room._id == data.room_id) {
                            // 受信時にルームへ入室している場合
                            if (this.$route.params.id == room._id) {
                                this.alreadyRead(room._id, [data.content._id]);
                            } else {
                                room.unread++;
                            }

                            room.contents.push(data.content);
                            break;
                        };
                    }
                    console.log(this.$route.params.id);
                });
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
        /* 特定会員取得 */
        getMember: function (member_id) {
            return axios.get('/api/members/' + member_id)
                .then(res => this.checkAuth(res))
                .catch(error => {
                    console.log(error);
                });
        },
        /* 会員の作成 */
        createMember: function (member_property) {
            return axios.post('/api/members', member_property)
                .then(res => this.checkAuth(res))
        },

        /* 会員の情報の編集 */
        editMember: function (member_property) {
            return axios.put('/api/members/' + member_property._id, member_property)
                .then(res => this.checkAuth(res))
        },

        /* 会員削除 */
        deleteMember: function (member_id) {
            return axios.delete('/api/members/' + member_id)
                .then(res => this.checkAuth(res))
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

        /* 会社の作成 */
        createCompany: function (company_property) {
            return axios.post('/api/companies', company_property)
                .then(res => this.checkAuth(res))
        },

        /* 会社の情報の編集 */
        editCompany: function (company_property) {
            return axios.put('/api/companies/' + company_property._id, company_property)
                .then(res => this.checkAuth(res))
        },

        /* 会社削除 */
        deleteCompany: function (company_id) {
            return axios.delete('/api/companies/' + company_id)
                .then(res => this.checkAuth(res))
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
        /* スタンプグループの作成 */
        createStampGroup: function (stamp_group_property) {
            return axios.post('/api/stamp-groups', stamp_group_property)
                .then(res => this.checkAuth(res))
        },

        /* スタンプグループの編集 */
        editStampGroup: function (stamp_group_property) {
            return axios.put('/api/stamp-groups/' + stamp_group_property._id, company_property)
                .then(res => this.checkAuth(res))
        },

        /* スタンプグループ削除 */
        deleteStampGroup: function (stamp_group_id) {
            return axios.delete('/api/stamp-groups/' + stamp_group_id)
                .then(res => this.checkAuth(res))
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
                    this.chat_room_list.splice(0, 0, res.data.chat_room);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャットグループ編集 */
        editChatRoom: function (room_id, data) {
            data.append("_method", "PUT");
            return axios.post('/api/chat-rooms/' + room_id, data)
                .then(res => this.checkAuth(res))
                .then(res => {
                    return res.data.room;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャットグループ削除 */
        deleteChatRoom: function (room_id) {
            return axios.delete('/api/chat-rooms/' + room_id)
                .then(res => this.checkAuth(res))
                .then(res => {
                    const index = this.chat_room_list.findIndex(room => room._id === room_id);
                    this.chat_room_list.splice(index, 1);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャットグループ会員追加 */
        addChatRoomMember: function (room_id, data) {
            return axios.post('/api/chat-rooms/' + room_id + '/members', data)
                .then(res => this.checkAuth(res))
                .then(res => {
                    return res.data.room;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャットグループ会員削除 */
        deleteChatRoomMember: function (room_id, data) {
            return axios.delete('/api/chat-rooms/' + room_id + '/members', { data: data })
                .then(res => this.checkAuth(res))
                .then(res => {
                    return res.data.room;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* チャット送信 */
        chatSubmit: function (chat_room_id, data) {
            return axios.post('/api/chat-rooms/' + chat_room_id + '/contents', data)
                .then(res => this.checkAuth(res))
                .then(res => {
                    console.log(res);
                    return res.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        /* 既読処理 */
        alreadyRead: function (chat_room_id, contents_id) {
            return axios.put('/api/chat-rooms/' + chat_room_id + '/contents', {
                unread_contents: contents_id
            })
                .then(res => this.checkAuth(res))
                .catch(error => {
                    console.log(error);
                });
        },
    }
});

window.app = app;