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
                                    v-model="editedItem.name"
                                    label="会社名"
                                    counter="150"
                                    :rules="companyRules.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.tel"
                                    label="電話番号"
                                    :rules="companyRules.tel"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.address"
                                    label="住所"
                                    counter="128"
                                    :rules="companyRules.address"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="accent" text @click="close">閉じる</v-btn>
                <v-btn :disabled="!valid" color="accent" text @click="save">保存する</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { axios } from "@/store";
export default {
    data: () => ({
        dialog: false,
        valid: false,
        editedId: null,
        editedItem: {
            name: "",
            address: "",
            tel: ""
        },
        defaultItem: {
            name: "",
            address: "",
            tel: ""
        },
        companyRules: {
            name: [
                v => !!v || "必須項目です。",
                v => (v && v.length <= 150) || "1文字以上150文字以下のみ"
            ],
            tel: [
                v => !!v || "必須項目です。",
                v =>
                    /^\d{2,4}-\d{2,4}-\d{2,4}$/.test(v) ||
                    "###-####-####の形式のみ受け付けます。"
            ],
            address: [
                v => !!v || "必須項目です。",
                v => (v && v.length <= 128) || "1文字以上128文字以下のみ"
            ]
        }
    }),
    computed: {
        formTitle() {
            return this.editedId ? "会社編集" : "会社作成";
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
        editItem(company) {
            this.editedId = company.id;
            this.editedItem = Object.assign({}, company);
            this.dialog = true;
        },

        deleteItem(company) {
            confirm("この会社を削除してもよろしいですか？") &&
                axios.delete("companies/" + company.id);
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.editedId = null;
            this.editedItem = Object.assign({}, this.defaultItem);
        },
        save() {
            if (this.editedId) {
                axios.post("companies/" + this.editedId, this.editedItem);
            } else {
                axios.post("companies", this.editedItem);
            }
            this.close();
        }
    }
};
</script>

<style>
</style>