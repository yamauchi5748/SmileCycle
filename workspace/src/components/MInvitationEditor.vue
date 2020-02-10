<template>
    <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="510px">
        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="valid" ref="form">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.title"
                                    label="タイトル"
                                    counter="32"
                                    :rules="invitationRules.title"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    v-model="editedItem.text"
                                    label="本文"
                                    no-resize
                                    counter="1000"
                                    :rules="invitationRules.text"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <MImageList v-model="editedItem.images"></MImageList>
                                <MImageUploader v-model="editedItem.images"></MImageUploader>
                            </v-col>
                            <v-col cols="12">
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="editedItem.deadline_at"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            v-model="editedItem.deadline_at"
                                            label="回答締切日"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            :rules="invitationRules.deadline_at"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="editedItem.deadline_at"
                                        no-title
                                        scrollable
                                        :allowed-dates="allowedDates"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false">閉じる</v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.menu.save(editedItem.deadline_at)"
                                        >決定する</v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="12">
                                <VSelectMembers
                                    v-model="editedItem.members"
                                    :rules="invitationRules.members"
                                ></VSelectMembers>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">取り消し</v-btn>
                <v-btn
                    :disabled="editedItem.members || !valid"
                    color="blue darken-1"
                    text
                    @click="save"
                >保存する</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { axios } from "@/store";
import VSelectMembers from "@/components/VSelectMembers";
import MImageList from "@/components/MImageList";
import MImageUploader from "@/components/MImageUploader";
export default {
    components: {
        VSelectMembers,
        MImageList,
        MImageUploader
    },
    data: () => ({
        dialog: false,
        menu: false,
        valid: false,
        editedId: null,
        editedItem: {
            title: "",
            text: "",
            images: [],
            members: [],
            deadline_at: "",
            statusTable: {}
        },
        defaultItem: {
            title: "",
            text: "",
            images: [],
            members: [],
            deadline_at: "",
            statusTable: {}
        },
        invitationRules: {
            title: [
                v => !!v || "必須項目です。",
                v =>
                    (v && 1 <= v.length && v.length <= 32) ||
                    "1文字以上32文字以下のみ"
            ],
            text: [
                v => !!v || "必須項目です。",
                v =>
                    (v && 1 <= v.length && v.length <= 1000) ||
                    "1文字以上1000文字以下のみ"
            ],
            deadline_at: [v => !!v || "必須項目です。"],
            members: [v => !!v || "必須項目です。1人以上選択してください。"]
        }
    }),
    computed: {
        formTitle() {
            return this.editedId ? "会のご案内編集" : "会のご案内作成";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    methods: {
        allowedDates(day) {
            return new Date().getTime() <= new Date(day).getTime();
        },
        createItem() {
            this.dialog = true;
        },
        editItem(invitation) {
            this.editedId = invitation.id;
            this.editedItem = Object.assign({}, invitation);
            this.dialog = true;
        },

        deleteItem(invitation) {
            confirm("この会のご案内を削除してもよろしいですか？") &&
                axios.delete("invitations/" + invitation.id);
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.editedId = null;
            this.editedItem = Object.assign({}, this.defaultItem);
        },
        save() {
            if (this.editedId) {
                axios.post("invitations/" + this.editedId, this.editedItem);
            } else {
                axios.post("invitations", this.editedItem);
            }
            this.close();
        }
    }
};
</script>

<style>
</style>