<template>
    <v-container fluid>
        <v-row :class="{'d-none':$vuetify.breakpoint.lgAndUp}">
            <v-col cols="12">
                <v-btn @click="drawer=!drawer" text>
                    <v-icon>mdi-menu</v-icon>
                </v-btn>
                <v-divider></v-divider>
            </v-col>
        </v-row>
        <v-navigation-drawer
            app
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            :mobile-break-point="$vuetify.breakpoint.thresholds.md"
            width="200"
        >
            <v-list nav dense>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>管理</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item
                    v-for="item in link_items"
                    :key="item.title"
                    link
                    active-class="accent--text"
                    :to="item.to"
                >
                    <!--                     
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>-->
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <router-view></router-view>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
            link_items: [
                { title: "会のご案内", to: { name: "controls-invitations" } },
                { title: "タイムライン", to: { name: "controls-timelines" } },
                { title: "会員", to: { name: "controls-members" } },
                { title: "会社", to: { name: "controls-companies" } },
                { title: "スタンプ", to: { name: "controls-stamps" } }
            ]
        };
    }
};
</script>

<style>
</style>