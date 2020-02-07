<template>
    <div class="fill-height d-flex flex-column">
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
                    <v-list-item
                        v-show="user._id == room.managerId"
                        link
                        @click="controlEditor('editItem',room)"
                    >
                        <v-list-item-title>編集</v-list-item-title>
                    </v-list-item>
                    <v-list-item link @click="controlEditor('exitRoom',room)">
                        <v-list-item-title>退出</v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        v-show="user._id == room.managerId"
                        link
                        @click="controlEditor('deleteItem',room)"
                    >
                        <v-list-item-title>削除</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <MRoomEditor ref="editor"></MRoomEditor>
        </v-toolbar>
        <v-divider></v-divider>
        <v-list
            ref="contents"
            color="transparent"
            height="0"
            flat
            class="overflow-y-auto flex-grow-1 flex-shrink-1"
        >
            <message v-for="content in contents" :key="content._id" :content="content"></message>
        </v-list>
        <v-textarea
            v-model="message"
            append-icon="mdi-face"
            append-outer-icon="mdi-send"
            :placeholder="placeholder"
            @focus="isStampMenuDisplayed = false"
            @click:append="isStampMenuDisplayed = !isStampMenuDisplayed"
            @click:append-outer="sendMessage"
            auto-grow
            hide-details
            outlined
            dence
            rows="1"
            class="mb-2 mx-4 flex-grow-0 flex-shrink-0"
        >
            <template v-slot:prepend>
                <v-icon
                    @click="isHurry = !isHurry"
                    :color="isHurry ? 'red':''"
                    class="mr-2"
                >mdi-email-alert</v-icon>
                <v-icon @click="choseImage">mdi-camera-image</v-icon>
                <input
                    v-show="false"
                    @change="onFileChange"
                    ref="input"
                    type="file"
                    multiple
                    accept="image/*"
                />
            </template>
        </v-textarea>
        <v-card
            v-show="isStampMenuDisplayed"
            class="flex-grow-0 flex-shrink-0"
            height="280"
            style="overflow-y:scroll"
        >
            <v-tabs>
                <v-tab v-for="stamp in stamps" :key="stamp._id">
                    <img height="40" width="40" :src="'/api/images/' + stamp.tabImage" />
                </v-tab>
                <v-tab-item v-for="stamp in stamps" :key="stamp._id" class="d-flex flex-wrap">
                    <v-img
                        @click="sendStamp(name)"
                        class="flex-grow-0 flex-shrink-0 ma-1"
                        v-for="name in stamp.stamps"
                        :key="name"
                        height="65"
                        width="65"
                        :src="'/api/images/' + name"
                    >
                        <template v-slot:placeholder>
                            <v-row class="fill-height ma-0" align="center" justify="center">
                                <v-progress-circular indeterminate color="grey"></v-progress-circular>
                            </v-row>
                        </template>
                    </v-img>
                </v-tab-item>
            </v-tabs>
        </v-card>
    </div>
</template>
<script>
import { auth, watch, axios } from "@/store";
import Message from "@/components/chat/Message";
import MRoomEditor from "@/components/MRoomEditor";
export default {
    props: {
        room: {
            tyep: Object,
            require: true
        }
    },
    components: {
        Message,
        MRoomEditor
    },
    data: () => ({
        isHurry: false,
        isStampMenuDisplayed: false,
        user: auth.user,
        placeholder: "メッセージを入力してください",
        message: "",
        contents: [],
        stamps: []
    }),
    async created() {
        const { data } = await axios.get("/stamps");
        axios.put(`/rooms/${this.room.id}/read`);
        this.stamps = this.stamps.concat(data);
        const room = this.room;
        watch("contents", this.contents, {
            url: `/rooms/${this.room.id}/contents`,
            insert(array, change) {
                const { documentId, document } = change;
                if (room.id != document.roomId) {
                    return;
                }
                Object.defineProperty(document, "id", {
                    value: documentId,
                    writable: false
                });
                array.splice(array.length, 0, document);
            }
        });
    },
    updated() {
        this.scrollToTop();
    },
    watch: {
        contents: {
            handler() {
                axios.put(`/rooms/${this.room.id}/read`);
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        controlEditor(action, ...value) {
            this.$refs.editor[action](...value);
        },
        async sendMessage() {
            if (!this.message) return;
            if (
                this.isHurry &&
                !confirm(
                    "ルーム内の会員全てにメールで通知されます。\nよろしいですか？"
                )
            )
                return;
            axios.post("rooms/" + this.room.id + "/message", {
                isHurry: this.isHurry,
                message: this.message
            });
            this.isHurry = false;
            this.message = "";
        },
        async sendStamp(name) {
            if (
                this.isHurry &&
                !confirm(
                    "ルーム内の会員全てにメールで通知されます。\nよろしいですか？"
                )
            )
                return;
            await axios.post("rooms/" + this.room.id + "/stamp", {
                isHurry: this.isHurry,
                stamp: name
            });
            this.isHurry = false;
        },
        choseImage() {
            this.$refs.input.value = null;
            this.$refs.input.click();
        },
        async sendImage(image) {
            if (
                this.isHurry &&
                !confirm(
                    "ルーム内の会員全てにメールで通知されます。\nよろしいですか？"
                )
            )
                return;
            await axios.post("rooms/" + this.room.id + "/image", {
                isHurry: this.isHurry,
                image: image
            });
            this.isHurry = false;
        },
        async onFileChange(event) {
            for (const file of event.target.files) {
                const formData = new FormData();
                formData.append("file", file);
                const config = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };
                axios.post("/images", formData, config).then(({ data }) => {
                    this.sendImage(data.name);
                });
            }
        },
        //コンテンツ一覧の一番下までスクロール
        scrollToTop() {
            this.$refs.contents.$el.scrollTop = this.$refs.contents.$el.scrollHeight;
        }
    }
};
</script>
