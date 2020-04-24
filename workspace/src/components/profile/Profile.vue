<template>
    <v-container fluid>
        <v-tabs grow background-color="transparent">
            <v-tab v-for="item in items" :key="item.title" :to="item.to">{{item.title}}</v-tab>
        </v-tabs>
        <router-view></router-view>
    </v-container>
</template>

<script>
import { auth } from "@/store";

export default {
    data: () => ({
        items: [
            {
                title: "プロフィール",
                to: { name: "profile-information" }
            },
            {
                title: "投稿",
                to: { name: "profile-timelines" }
            },
            {
                title: "設定",
                to: { name: "profile-settings" }
            }
        ],
        user: auth.user
    })
};
</script>

<style>
</style>