<template>
    <v-container>
        <v-card class="elevation-1">
            <v-card-title>
                会社一覧
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
                :items="companies"
                :search="search"
                sort-by="department"
            >
                <template v-slot:item.avatar="{item}">
                    <v-avatar color="grey" size="40">
                        <img :src="'/api/images/'+(item.avatar || 'avatar')" />
                    </v-avatar>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
import { watch } from "@/store";
export default {
    data: () => ({
        search: "",
        headers: [
            {
                text: "会社名",
                align: "center",
                sortable: true,
                value: "name"
            },
            {
                text: "電話番号",
                align: "left",
                sortable: true,
                value: "tel"
            },
            {
                text: "住所",
                align: "left",
                sortable: true,
                value: "address"
            }
        ],
        companies: []
    }),
    created() {
        watch("companies", this.companies);
    }
};
</script>

<style>
</style>