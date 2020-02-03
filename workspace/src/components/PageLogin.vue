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
                                <v-form>
                                    <v-text-field
                                        v-model="name"
                                        label="氏名"
                                        prepend-icon="mdi-account"
                                        type="text"
                                    />
                                    <v-text-field
                                        v-model="password"
                                        label="パスワード"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                    />
                                </v-form>
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
        error_message: ""
    }),
    methods: {
        async login() {
            const {
                data: { result }
            } = await auth.login(this.name, this.password);
            if (result) {
                this.$router.push({ name: "main" });
            }
        }
    }
};
</script>

<style>
</style>