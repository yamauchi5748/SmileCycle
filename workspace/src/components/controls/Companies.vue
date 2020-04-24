<template>
    <v-container>
        <v-data-table :headers="headers" :items="companies" multi-sort class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>会社</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn color="accent" @click="controlEditor('createItem')">会社登録</v-btn>
                    <MCompanyEditor ref="editor"></MCompanyEditor>
                </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="controlEditor('editItem',item)">mdi-pencil</v-icon>
                <v-icon small @click="controlEditor('deleteItem',item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>データが存在しません。</template>
        </v-data-table>
    </v-container>
</template>

<script>
import { watch } from "@/store";
import MCompanyEditor from "@/components/MCompanyEditor";
export default {
    components: {
        MCompanyEditor
    },
    data: () => ({
        headers: [
            {
                text: "会社名",
                align: "left",
                sortable: true,
                value: "name"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        companies: [],
        editedItem: {
            name: "",
            address: "",
            tel: ""
        },
        defaultItem: {
            name: "",
            address: "",
            tel: ""
        }
    }),
    created() {
        watch("companies", this.companies);
    },
    methods: {
        controlEditor(action, ...value) {
            this.$refs.editor[action](...value);
        }
    }
};
</script>

<style>
</style>