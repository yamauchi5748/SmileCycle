<template>
    <v-container>
        <v-data-table :headers="headers" :items="stamps" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>スタンプ</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn color="accent" @click="controlEditor('createItem')">スタンプ登録</v-btn>
                    <MStampEditor ref="editor"></MStampEditor>
                </v-toolbar>
            </template>
            <template v-slot:item.tabImage="{ item }">
                <v-img class="my-2" aspect-ratio="1" width="60" :src="'/api/images/'+item.tabImage"></v-img>
            </template>
            <template v-slot:item.stampCount="{ item }">{{item.stamps.length}}</template>
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
import MStampEditor from "@/components/MStampEditor";
export default {
    components: {
        MStampEditor
    },
    data: () => ({
        headers: [
            {
                text: "タブ画像",
                align: "left",
                sortable: false,
                value: "tabImage"
            },
            {
                text: "スタンプ数",
                align: "right",
                sortable: false,
                value: "stampCount"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        stamps: []
    }),
    created() {
        watch("stamps", this.stamps, { url: "/stamps/admin" });
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