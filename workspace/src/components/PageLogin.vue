<template>
    <v-app>
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" flat>
                                <v-toolbar-title class="white--text">笑門会</v-toolbar-title>
                                <v-spacer />
                            </v-toolbar>
                            <v-card-text>
                                <v-text-field
                                    v-model="name"
                                    label="氏名"
                                    prepend-icon="mdi-account"
                                    type="text"
                                    :error="error"
                                />
                                <v-text-field
                                    v-model="password"
                                    label="パスワード"
                                    prepend-icon="mdi-lock"
                                    type="password"
                                    :error="error"
                                />
                            </v-card-text>
                            <v-card-text v-show="error" class="red--text">
                                名前かパスワード又はその両方が違います。
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer />
                                <v-btn @click="login" color="primary">ログイン</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import { auth } from "@/store";
export default {
    data: () => ({
        name: "管理者",
        password: "lkwjaoieu",
        error: false
    }),
    methods: {
        async login() {
            const {
                data: { result }
            } = await auth.login(this.name, this.password).catch(() => {
                this.error = true;
            });
            if (result) {
                this.$router.push({ name: "main" });
            } else {
                this.error = true;
            }
        }
    }
};
</script>

<style>
</style>