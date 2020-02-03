<template>
    <v-app>
        <v-app-bar clipped-left app color="primary">
            <v-spacer></v-spacer>
            <v-btn @click.stop="drawer = !drawer" text>
                <v-icon>mdi-menu</v-icon>
            </v-btn>
        </v-app-bar>
        <!-- 各ページを表示する -->
        <v-content>
            <router-view></router-view>
        </v-content>
        <!-- 他のページに飛ぶためのnavigation  -->
        <v-navigation-drawer v-model="drawer" app fixed temporary right>
            <v-list nav dense>
                <v-list-item-group color="accent">
                    <v-list-item v-for="item in items" :key="item.title" :to="item.to" link>
                        <!--                         
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        -->
                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
            <template v-slot:append>
                <v-list-item v-if="user.isAdmin" dence :to="{name:'controls'}" link>
                    <v-list-item-content>
                        <v-list-item-title>管理</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <div class="pa-2">
                    <v-btn @click="logout" block>ログアウト</v-btn>
                </div>
            </template>
        </v-navigation-drawer>
    </v-app>
</template>

<script>
import { auth } from "@/store";
export default {
    data: () => ({
        user: auth.user,
        drawer: false,
        items: [
            {
                title: "チャット",
                to: { name: "chat" },
                icon: "fas fa-comments"
            },
            {
                title: "会のご案内",
                to: { name: "invitations" },
                icon: "question_answer"
            },
            { title: "タイムライン", to: { name: "timelines" } },
            { title: "会員一覧", to: { name: "members" } },
            // { title: "利用案内", to: { name: "help" } },
            { title: "プロフィール", to: { name: "profile" } }
        ]
    }),
    methods: {
        async logout() {
            await auth.logout();
            this.$router.push({ name: "login" });
        }
    }
};
</script>

<style>
</style>