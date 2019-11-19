<template>
    <v-container>
        <v-card class="elevation-1">
            <v-card-title>
                会員一覧
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="検索..."
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="members"
                :search="search"
                multi-sort
                loading-text="データを取得中..."
                :loading="loading"
            >
                <template v-slot:item.profile_img="{item}">
                    <v-avatar color="grey" size="40">
                        <img :src="item.profile_img" />
                    </v-avatar>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";
export default {
    data: () => ({
        search: "",
        loading: true,
        headers: [
            {
                text: "プロフ画像",
                align: "center",
                sortable: false,
                value: "profile_img"
            },
            {
                text: "会員名",
                align: "left",
                sortable: true,
                value: "name"
            },
            {
                text: "ふりがな",
                align: "left",
                sortable: true,
                value: "ruby"
            },
            {
                text: "会社名",
                align: "left",
                sortable: true,
                value: "company_name"
            },
            {
                text: "役職",
                align: "left",
                sortable: true,
                value: "post"
            },
            {
                text: "部門",
                align: "left",
                sortable: true,
                value: "department_name"
            }
        ],
        members: []
    }),
    created() {
        this.initialize();
    },
    methods: {
        initialize() {
            // https://next.json-generator.com/api/json/get/VJzF81SsP
            axios
                .get("https://next.json-generator.com/api/json/get/VJzF81SsP")
                .then(response => {
                    this.members = response.data;
                    this.loading = false;
                });
        }
    }
};
</script>

<style>
</style>