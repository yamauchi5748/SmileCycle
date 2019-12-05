<template>
    <v-container fluid>
        <v-row class="mt-4" justify="center">
            <div class="d-flex flex-column align-center">
                <v-avatar size="90" color="grey"></v-avatar>
                <div class="subtitle-1 mt-4">会員名</div>
            </div>
        </v-row>
        <v-row class="mt-8">
            <v-tabs centered background-color="transparent">
                <v-tab v-for="item in items" :key="item.title" :to="item.to">{{item.title}}</v-tab>
            </v-tabs>
        </v-row>
        <v-row>
            <router-view></router-view>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        items: [
            {
                title: "プロフィール",
                to: { name: "profile-information" }
            },
            {
                title: "投稿",
                to: { name: "profile-forums" }
            },
            {
                title: "設定",
                to: { name: "profile-settings" }
            }
        ]
    })
};
</script>

<style>
</style>