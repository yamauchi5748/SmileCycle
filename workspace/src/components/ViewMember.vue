<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="510px">
            <v-card>
                <v-card-title>
                    <span class="headline">会員情報</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field readonly :value="viewItem.name" label="名前"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field readonly :value="viewItem.ruby" label="ふりがな"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    readonly
                                    :value="viewItem.tel"
                                    type="tel"
                                    label="電話番号"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field readonly :value="viewItem.mail" label="メールアドレス"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field readonly :value="viewItem.companyName" label="会社"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field readonly :value="viewItem.post" label="役職"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    readonly
                                    :value="viewItem.department"
                                    :items="['愛媛笑門会','東京笑門会','大阪笑門会','鎌倉笑門会']"
                                    label="部門"
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field readonly :value="viewItem.secretaryName" label="秘書名"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    readonly
                                    :value="viewItem.secretaryMail"
                                    label="秘書メールアドレス"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="accent" text @click="dialog = false">閉じる</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
export default {
    data: () => ({
        dialog: false,
        viewItem: {
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
    methods: {
        view(member) {
            this.viewItem = Object.assign(this.viewItem, member);
            this.dialog = true;
        }
    }
};
</script>