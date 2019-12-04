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
                <v-list-item dence :to="{name:'controls'}" link>
                    <v-list-item-content>
                        <v-list-item-title>管理</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <div class="pa-2">
                    <v-btn block>ログアウト</v-btn>
                </div>
            </template>
        </v-navigation-drawer>
    </v-app>
</template>

<script>
export default {
    name: "App"
};
</script>
