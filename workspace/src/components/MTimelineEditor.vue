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
                                    counter="20"
                                    :rules="timelineRules.title"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    v-model="editedItem.text"
                                    label="本文"
                                    no-resize
                                    counter="1000"
                                    :rules="timelineRules.text"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <MImageList v-model="editedItem.images"></MImageList>
                                <MImageUploader v-model="editedItem.images"></MImageUploader>
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
import { axios } from "@/store";
import MImageList from "@/components/MImageList";
import MImageUploader from "@/components/MImageUploader";
export default {
    components: {
        MImageList,
        MImageUploader
    },
    data: () => ({
        dialog: false,
        valid: false,
        editedId: null,
        editedItem: {
            title: "",
            text: "",
            images: []
        },
        defaultItem: {
            title: "",
            text: "",
            images: []
        },
        timelineRules: {
            title: [
                v => !!v || "必須項目です。",
                v =>
                    (v && 1 <= v.length && v.length <= 20) ||
                    "1文字以上20文字以下のみ"
            ],
            text: [
                v => !!v || "必須項目です。",
                v =>
                    (v && 1 <= v.length && v.length <= 1000) ||
                    "1文字以上1000文字以下のみ"
            ]
        }
    }),
    computed: {
        formTitle() {
            return this.editedId ? "タイムライン編集" : "タイムライン作成";
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
        editItem(timeline) {
            this.editedId = timeline.id;
            this.editedItem = Object.assign({}, timeline);
            this.dialog = true;
        },
        deleteItem(timeline) {
            confirm("このタイムラインを削除してもよろしいですか？") &&
                axios.delete("timelines/" + timeline.id);
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.editedId = null;
            this.editedItem = Object.assign({}, this.defaultItem);
        },
        save() {
            if (this.editedId) {
                axios.post("timelines/" + this.editedId, this.editedItem);
            } else {
                axios.post("timelines", this.editedItem);
            }
            this.close();
        }
    }
};
</script>

<style>
</style>