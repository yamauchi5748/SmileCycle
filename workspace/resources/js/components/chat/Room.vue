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
        rooms_collection: store.collection("rooms"),
        room_doc: store.collection("rooms"),
        room: {},
        room_unsubscribe: null,
        contents: [],
        contents_collection: null,
        contents_unsubscribe: null,
        editedItem: {
            name: "",
            members: []
        }
    }),
    created() {
        this.loadRoom();
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
        $route() {
            this.loadRoom();
        }
    },
    methods: {
        loadRoom() {
            this.unsubscribe();
            this.room_doc = this.rooms_collection.doc(this.$route.params.id);
            this.contents_collection = this.room_doc.collection("contents");

            this.room_doc.get().then(this.setRoomData);
            this.room_unsubscribe = this.room_doc.onSnapshot(this.setRoomData);
            this.contents_collection
                .orderBy("created_at")
                .get()
                .then(this.setContentsData);
            this.contents_unsubscribe = this.contents_collection
                .orderBy("created_at")
                .onSnapshot(this.setContentsData);
        },
        setRoomData(doc) {
            this.room = {
                ...doc.data(),
                _id: doc.id
            };
        },
        setContentsData(snapshot) {
            this.contents = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
            this.$nextTick(this.scrollToTop);
        },
        sendMessage() {
            if (!this.message) return;
            this.contents_collection.add({
                sender_name: "送信者",
                content_type: 1,
                message: this.message,
                created_at: new Date()
            });
            this.message = "";
            this.$nextTick(this.scrollToTop);
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
            /*
                退出処理をかく
            */
            this.$router.replace({ name: "chat-not-found" });
        },
        deleteRoom() {
            this.room_doc.delete();
            this.$router.replace({ name: "chat-not-found" });
        },
        close() {
            this.dialog = false;
        },
        save() {
            this.room_doc.set(this.editedItem);
            this.close();
        },
        unsubscribe() {
            this.room_unsubscribe && this.room_unsubscribe();
            this.contents_unsubscribe && this.contents_unsubscribe();
        }
    },
    destroyed() {
        this.unsubscribe();
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