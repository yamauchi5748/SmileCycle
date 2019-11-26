<template>
    <div class="fill-height">
        <v-navigation-drawer app clipped :mobile-break-point="0" :width="sidebar_width">
            <div class="fill-height d-flex flex-column">
                <v-tabs fixed-tabs v-model="room_type" class="flex-grow-0 flex-shrink-0">
                    <v-tab>個人</v-tab>
                    <v-tab>グループ</v-tab>
                </v-tabs>
                <v-divider></v-divider>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="検索..."
                    clearable
                    single-line
                    hide-details
                    dense
                    outlined
                    class="mx-2 mt-2 flex-grow-0 flex-shrink-0"
                ></v-text-field>
                <v-list nav class="p-rooms flex-grow-1 flex-shrink-1">
                    <v-list-item
                        v-for="room in rooms"
                        :key="room._id"
                        link
                        :to="{name:'chat-room',params:{id:room._id}}"
                    >
                        <v-list-item-avatar>
                            <img :src="room.img" alt />
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>{{room.name}}</v-list-item-title>
                            <v-list-item-subtitle>{{latestContentsText(room)}}</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-badge>
                                <template v-slot:badge>0</template>
                            </v-badge>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
                {{store.profile}}
                <!-- チャットルーム作成ダイアログ -->
                <v-dialog
                    v-model="dialog"
                    :fullscreen="!$vuetify.breakpoint.lgAndUp"
                    max-width="600px"
                >
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" fab fixed bottom right color="accent" class="mr-3">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">グループ作成</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field v-model="editedItem.name" label="ルーム名"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-select-members
                                            v-model="editedItem.members"
                                            label="ルームメンバー"
                                        ></v-select-members>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">取り消し</v-btn>
                            <v-btn color="blue darken-1" text @click="save">作成する</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-navigation-drawer>
        <router-view></router-view>
    </div>
</template>

<script>
import store from "../../store";
export default {
    data: () => ({
        dialog: false,
        room_type: 0, // 個人 == 0 , グループ == 1
        search: null,
        store,
        editedItem: {
            name: "",
            members: []
        },
        defaultItem: {
            name: "",
            members: []
        }
    }),
    watch: {
        $route() {
            if (this.$route.name == "chat") {
                this.$router.replace({ name: "chat-not-found" });
            }
        },
        dialog(val) {
            val || this.close();
        },
        // 初期ユーザを設定
        "store.members.data": {
            handler() {
                this.store.profile = this.store.members.data[0];
            }
        }
    },
    computed: {
        // 表示用にフィルターをかける
        rooms() {
            return this.store.rooms.data.filter(room => {
                if (
                    !(
                        (this.room_type == 0 && !room.is_group) ||
                        (this.room_type == 1 && room.is_group)
                    )
                ) {
                    return false;
                }

                if (
                    !room.members.some(
                        member_id => member_id === this.store.profile._id
                    )
                ) {
                    return false;
                }

                return room.name.indexOf(this.search ? this.search : "") !== -1;
            });
        },
        // レスポンシブ対応
        sidebar_width() {
            if (this.$vuetify.breakpoint.lgAndUp) {
                return "300";
            } else if (this.$route.name == "chat-not-found") {
                return "100%";
            } else if (this.$route.name == "chat-room") {
                return "0";
            } else {
                return "0";
            }
        }
    },
    methods: {
        // ルームの最新のコンテンツを表示用文字列にする
        latestContentsText(room) {
            if (room.contents && room.contents[0] && room.contents[0].message) {
                return room.contents[0].message;
            }
            return "";
        },
        close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
            }, 300);
        },
        save() {
            store.rooms.create({ ...this.editedItem, is_group: false });
            this.close();
        }
    }
};
</script>
<style scoped>
.p-rooms {
    height: 0;
    overflow-y: scroll;
}
</style>