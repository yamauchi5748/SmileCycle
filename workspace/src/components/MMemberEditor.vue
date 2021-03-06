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
                                    label="名前"
                                    counter="15"
                                    :rules="rules.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.ruby"
                                    label="ふりがな"
                                    counter="30"
                                    :rules="rules.ruby"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.tel"
                                    type="tel"
                                    label="電話番号"
                                    :rules="rules.tel"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.mail"
                                    label="メールアドレス"
                                    counter="256"
                                    :rules="rules.mail"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select-company
                                    v-model="editedItem.companyId"
                                    label="会社"
                                    :rules="rules.companyId"
                                ></v-select-company>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.post"
                                    label="役職"
                                    counter="50"
                                    :rules="rules.post"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="editedItem.department"
                                    :items="['愛媛笑門会','東京笑門会','大阪笑門会','鎌倉笑門会']"
                                    label="部門"
                                    :rules="rules.department"
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.secretaryName"
                                    label="秘書名"
                                    counter="15"
                                    :rules="rules.secretaryName"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.secretaryMail"
                                    label="秘書メールアドレス"
                                    counter="256"
                                    :rules="rules.secretaryMail"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="editedItem.password"
                                    type="password"
                                    label="パスワード"
                                    counter="150"
                                    :rules="rules.password"
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
import { axios, getWatchArray } from "@/store";
import VSelectCompany from "@/components/VSelectCompany";
export default {
    components: {
        VSelectCompany
    },
    data: () => ({
        dialog: false,
        valid: false,
        editedId: null,
        editedItem: {
            avatar: "69616d746865617661746172",
            name: "",
            ruby: "",
            tel: "",
            mail: "",
            companyId: "",
            post: "",
            department: "",
            secretaryName: "",
            secretaryMail: "",
            password: ""
        },
        defaultItem: {
            avatar: "69616d746865617661746172",
            name: "",
            ruby: "",
            tel: "",
            mail: "",
            companyId: "",
            post: "",
            department: "",
            secretaryName: "",
            secretaryMail: "",
            password: ""
        }
    }),
    computed: {
        rules() {
            const self = this;
            return {
                name: [
                    v => !!v || "必須項目です。",
                    v => (v && 2 <= v.length && v.length <= 15) ||
                        "2文字以上15文字以下のみ",
                    v =>
                        !getWatchArray("members").find(
                            member =>
                                member.name == v && member.id != self.editedId
                        ) || "すでに使われている名前です。"
                ],
                ruby: [
                    v => !!v || "必須項目です。",
                    v =>
                        (v && 2 <= v.length && v.length <= 30) ||
                        "2文字以上30文字以下のみ"
                ],
                tel: [
                    v => !!v || "必須項目です。",
                    v =>
                        /^(070|080|090)-\d{4}-\d{4}$/.test(v) ||
                        "(070又は080又は090)-####-####の形式のみ受け付けます。"
                ],
                mail: [
                    v => !!v || "必須項目です。",
                    v =>
                        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                        "正しい形式で入力してください。"
                ],
                companyId: [v => !!v || "必須項目です。"],
                post: [
                    v => !!v || "必須項目です。",
                    v => (v && v.length <= 50) || "1文字以上50文字以下のみ"
                ],
                department: [v => !!v || "必須項目です。"],
                secretaryName: [
                    v => (!self.editedItem.secretaryMail && !v) || (!!self.editedItem.secretaryMail && !!v) || (!self.editedItem.secretaryMail && !!v) || "必須項目です。",
                    v => (!self.editedItem.secretaryMail && !v) || (v && 2 <= v.length && v.length <= 15) || "2文字以上15文字以下のみ"
                ],
                secretaryMail: [
                    v => (!self.editedItem.secretaryName && !v) || (!!self.editedItem.secretaryName && !!v) || (!self.editedItem.secretaryName && !!v) || "必須項目です。",
                    v => (!self.editedItem.secretaryName && !v) || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || "正しい形式で入力してください。"
                ],
                password: !self.editedId
                    ? [
                          v => !!v || "必須項目です。",
                          v =>
                              (v && 8 <= v.length && v.length <= 150) ||
                              "8文字以上160文字以下のみ"
                      ]
                    : []
            };
        },
        formTitle() {
            return this.editedId ? "会員編集" : "会員作成";
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
        editItem(member) {
            this.editedId = member.id;
            this.editedItem = Object.assign({}, member);
            this.dialog = true;
        },
        deleteItem(member) {
            confirm("この会員を削除してもよろしいですか？") &&
                axios.delete("members/" + member.id);
        },
        close() {
            this.dialog = false;
            this.$refs.form.resetValidation();
            this.editedId = null;
            this.editedItem = Object.assign({}, this.defaultItem);
        },
        async save() {
            if (
                !(
                    this.editedItem.secretaryMail ||
                    this.editedItem.secretaryName
                )
            ) {
                delete this.editedItem.secretaryName;
                delete this.editedItem.secretaryMail;
            }

            if (this.editedId) {
                await axios.post("members/" + this.editedId, this.editedItem);
            } else {
                await axios.post("members", this.editedItem);
            }
            this.close();
        }
    }
};
</script>

<style>
</style>