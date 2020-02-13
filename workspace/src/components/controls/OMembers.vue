<template>
    <v-container>
        <v-data-table :headers="headers" :items="members" multi-sort class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>会員</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn color="accent" @click="controlEditor('createItem')">会員登録</v-btn>
                    <MMemberEditor ref="editor"></MMemberEditor>
                </v-toolbar>
            </template>
            <template v-slot:item.avatar="{ item }">
                <v-avatar size="32">
                    <img :src="'/api/images/'+(item.avatar || '69616d746865617661746172')" />
                </v-avatar>
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
import MMemberEditor from "@/components/MMemberEditor";
export default {
    components: {
        MMemberEditor
    },
    data: () => ({
        headers: [
            {
                text: "プロフ画像",
                align: "left",
                sortable: false,
                value: "avatar"
            },
            {
                text: "名前",
                align: "left",
                sortable: true,
                value: "name"
            },
            { text: "ふりがな", align: "left", sortable: true, value: "ruby" },
            { text: "役職名", align: "left", sortable: true, value: "post" },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        members: []
    }),
    created() {
        watch("members", this.members);
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