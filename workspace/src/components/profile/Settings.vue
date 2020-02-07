<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <div class="headline ml-4">通知</div>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            v-model="editedItem.notificationInterval"
                            label="通知間隔"
                            :items="interval"
                        >
                            <template v-slot:append>時間</template>
                        </v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-select v-model="editedItem.isNotification" label="通知可否" :items="items">
                            <template v-slot:append>時間</template>
                        </v-select>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <v-row justify="center">
                    <v-btn @click="save" color="primary">保存する</v-btn>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { auth, axios } from "@/store";
export default {
    data: () => ({
        user: auth.user,
        interval: [0.5, 1, 2, 3, 4, 12, 24],
        items: [
            {
                text: "通知する",
                value: true
            },
            {
                text: "通知しない",
                value: false
            }
        ],
        editedItem: {
            notificationInterval: "",
            isNotification: true
        }
    }),
    created() {
        this.editedItem = Object.assign({}, this.user);
    },
    methods: {
        save() {
            confirm("現在の情報に更新しますか？") &&
                axios.post("me", this.editedItem);
        }
    }
};
</script>

<style>
</style>