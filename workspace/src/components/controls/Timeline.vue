<template>
    <v-container>
        <v-data-table :headers="headers" :items="timelines" multi-sort class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>タイムライン</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <MTimelineEditor ref="editor"></MTimelineEditor>
                </v-toolbar>
            </template>
            <template v-slot:item.title="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.title}}</span>
            </template>
            <template v-slot:item.text="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.text}}</span>
            </template>
            <template v-slot:item.created_at="{ item }">{{item.created_at | fromNow}}</template>
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
import MTimelineEditor from "@/components/MTimelineEditor";
export default {
    components: {
        MTimelineEditor
    },
    data: () => ({
        headers: [
            {
                text: "投稿者",
                align: "left",
                sortable: false,
                value: "name"
            },
            {
                text: "タイトル",
                align: "left",
                sortable: false,
                value: "title"
            },
            {
                text: "本文頭",
                align: "left",
                sortable: false,
                value: "text"
            },
            {
                text: "作成日時",
                align: "right",
                sortable: true,
                value: "created_at"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        timelines: []
    }),
    created() {
        watch("timelines", this.timelines);
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