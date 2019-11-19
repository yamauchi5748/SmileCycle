<template>
    <div v-if="room" class="fill-height d-flex flex-column">
        <v-toolbar dense flat class="flex-grow-0 flex-shrink-0">
            <v-btn
                :to="{name:'chat'}"
                exact
                text
                icon
                :class="{'d-none':$vuetify.breakpoint.lgAndUp}"
            >
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-toolbar-title>{{room.name}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu offset-y>
                <template v-slot:activator="{ on }">
                    <v-btn text icon v-on="on">
                        <v-icon>mdi-settings-outline</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item link @click="editRoom">
                        <v-list-item-title>編集</v-list-item-title>
                    </v-list-item>
                    <v-list-item link @click="exitRoom">
                        <v-list-item-title>退出</v-list-item-title>
                    </v-list-item>
                    <v-list-item link @click="deleteRoom">
                        <v-list-item-title>削除</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <!-- グループ編集 -->
            <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="headline">グループ編集</span>
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
                                    <v-select-members v-model="editedItem.members" label="ルームメンバー"></v-select-members>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close">取り消し</v-btn>
                        <v-btn color="blue darken-1" text @click="save">保存する</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-divider></v-divider>
        <v-list
            ref="contents"
            color="transparent"
            flat
            class="p-contents flex-grow-1 flex-shrink-1"
        >
            <message v-for="content in contents" :key="content._id" :content="content"></message>
        </v-list>
        <v-textarea
            v-model="message"
            :key="room && room._id"
            append-icon="mdi-face"
            append-outer-icon="mdi-send"
            @click:append-outer="sendMessage"
            rows="1"
            row-height="44"
            auto-grow
            hide-details
            outlined
            class="mb-4 mx-4 flex-grow-0 flex-shrink-0"
        ></v-textarea>
    </div>
    <not-found v-else></not-found>
</template>
<script>
import NotFound from "./NotFound";
import Message from "./Message";
import store from "../../store";
export default {
    data: () => ({
        dialog: false,
        message: "",
        store,
        editedItem: {
            name: "",
            members: []
        }
    }),
    watch: {
        dialog(val) {
            val || this.close();
        },
    },
    computed: {
        room() {
            return this.store.rooms.data.find(
                room => room._id == this.$route.params.id
            );
        },
        // 表示用にソートする
        contents() {
            if (!this.room.contents) return [];
            return this.room.contents.slice().sort((content1, content2) => {
                return content1 > content2;
            });
        }
    },
    methods: {
        sendMessage() {
            if (!this.message) return;

            this.message = "";
        },
        //コンテンツ一覧の一番下までスクロール
        scrollToTop() {
            this.$refs.contents.$el.scrollTop = this.$refs.contents.$el.scrollHeight;
        },
        editRoom() {
            this.editedItem = Object.assign({}, this.room);
            this.dialog = true;
        },
        exitRoom() {
            this.room.members = this.room.members.filter(
                member_id => member_id !== this.store.profile._id
            );
            store.rooms.edit(this.room);
            this.$router.replace({ name: "chat-not-found" });
        },
        deleteRoom() {
            store.rooms.delete(this.room);
            this.$router.replace({ name: "chat-not-found" });
        },
        close() {
            this.dialog = false;
        },
        save() {
            store.rooms.edit(this.editedItem);
            this.close();
        }
    },
    components: {
        NotFound,
        Message
    }
};
</script>

<style scoped>
.p-contents {
    height: 0px;
    overflow-y: scroll;
}
</style>