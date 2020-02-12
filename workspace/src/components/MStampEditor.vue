<template>
    <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="510px">
        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="valid" ref="form"></v-form>
                    <v-row>
                        <v-col cols="12">
                            <MTabImageUploader v-model="editedItem.tabImage"></MTabImageUploader>
                        </v-col>
                        <v-col cols="12">
                            <MStampList v-model="editedItem.stamps"></MStampList>
                            <MImageUploader v-model="editedItem.stamps"></MImageUploader>
                        </v-col>
                        <v-col cols="12">
                            <v-switch v-model="editedItem.isAll" class="mx-2" label="全会員が使える"></v-switch>
                        </v-col>
                        <v-col cols="12" v-show="!editedItem.isAll">
                            <VSelectMembers v-model="editedItem.members"></VSelectMembers>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="accent" text @click="close">取り消し</v-btn>
                <v-btn :disabled="!valid" color="accent" text @click="save">保存する</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { axios } from "@/store";
import MTabImageUploader from "@/components/MTabImageUploader";
import MStampList from "@/components/MStampList";
import MImageUploader from "@/components/MImageUploader";
import VSelectMembers from "@/components/VSelectMembers";
export default {
    components: {
        MTabImageUploader,
        MStampList,
        MImageUploader,
        VSelectMembers
    },
    data: () => ({
        dialog: false,
        valid: false,
        editedId: "",
        editedItem: {
            tabImage: "",
            stamps: [],
            isAll: true,
            members: []
        },
        defaultItem: {
            tabImage: "",
            stamps: [],
            isAll: true,
            members: []
        },
        stampRules: {
            tabImage: [v => v || "必須項目です。"],
            stamps: [
                v =>
                    (v && v.length) || "必須項目です。1つ以上選択してください。"
            ]
        },
        stamps: []
    }),
    computed: {
        formTitle() {
            return this.editedId ? "スタンプ編集" : "スタンプ作成";
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
        editItem(stamp) {
            this.editedId = stamp.id;
            this.editedItem = Object.assign({}, stamp);
            this.dialog = true;
        },
        deleteItem(stamp) {
            confirm("このスタンプを削除してもよろしいですか？") &&
                axios.delete("stamps/" + stamp.id);
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.editedId = null;
            this.editedItem = Object.assign({}, this.defaultItem);
        },
        save() {
            if (this.editedId) {
                axios.post("stamps/" + this.editedId, this.editedItem);
            } else {
                axios.post("stamps", this.editedItem);
            }
            this.close();
        }
    }
};
</script>

<style>
</style>