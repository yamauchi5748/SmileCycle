<template>
    <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="510px">
        <v-card>
            <v-card-title>
                <span class="headline">{{formTitle}}</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="valid" ref="form">
                        <v-row>
                            <v-col cols="12">
                                <v-avatar size="164" @click="onClick">
                                    <v-img :src="'/api/images/' + image"></v-img>
                                    <input
                                        v-show="false"
                                        @change="onFileChange"
                                        ref="input"
                                        type="file"
                                        accept="image/*"
                                    />
                                </v-avatar>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.name"
                                    label="ルーム名"
                                    counter="20"
                                    :rules="roomRules.name"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <VSelectMembers
                                    v-model="editedItem.members"
                                    label="ルームメンバー"
                                    :rules="roomRules.members"
                                ></VSelectMembers>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">取り消し</v-btn>
                <v-btn :disabled="!valid" color="blue darken-1" text @click="save">保存する</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { auth, axios } from "@/store";
import VSelectMembers from "@/components/VSelectMembers";
export default {
    components: {
        VSelectMembers
    },
    data: () => ({
        dialog: false,
        valid: false,
        editedId: "",
        editedItem: {
            image: "",
            name: "",
            members: [auth.user._id]
        },
        defaultItem: {
            image: "",
            name: "",
            members: [auth.user._id]
        },
        roomRules: {
            name: [
                v => !!v || "必須項目です。",
                v =>
                    (v && 1 <= v.length && v.length <= 20) ||
                    "1文字以上20文字以下のみ"
            ],
            members: [
                v =>
                    (v && 2 <= v.length) ||
                    "必須項目です。2人以上選択してください。"
            ]
        }
    }),
    computed: {
        formTitle() {
            return this.editedId ? "ルーム編集" : "ルーム作成";
        },
        image() {
            return this.editedItem.image || "roomtop";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    methods: {
        createItem() {
            this.dialog = true;
        },
        editItem(room) {
            this.editedId = room.id;
            this.editedItem = Object.assign({}, room);
            this.dialog = true;
        },
        deleteItem(room) {
            confirm("このルームを削除してもよろしいですか？") &&
                axios.delete("rooms/" + room.id);
        },
        exitRoom(room) {
            confirm("このルームから退出してもよろしいですか？") &&
                axios.put("rooms/" + room.id + "/exit");
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.editedId = null;
            this.editedItem = Object.assign({}, this.defaultItem);
        },
        save() {
            if (this.editedId) {
                axios.post("rooms/" + this.editedId, this.editedItem);
            } else {
                axios.post("rooms", this.editedItem);
            }
            this.close();
        },
        onClick() {
            this.$refs.input.value = null;
            this.$refs.input.click();
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
                    this.editedItem.image = data.name;
                });
            }
        }
    }
};
</script>

<style>
</style>