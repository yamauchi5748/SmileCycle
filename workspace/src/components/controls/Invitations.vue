<template>
    <v-container>
        <v-data-table :headers="headers" :items="invitations" multi-sort class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>会のご案内</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn color="accent" @click="controlEditor('createItem')">会のご案内作成</v-btn>
                    <MInvitationsEditor ref="editor"></MInvitationsEditor>
                </v-toolbar>
            </template>
            <template v-slot:item.title="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.title}}</span>
            </template>
            <template v-slot:item.text="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.text}}</span>
            </template>
            <template v-slot:item.membersCount="{ item }">{{item.members.length}}</template>
            <template v-slot:item.deadline_at="{ item }">{{item.deadline_at}}</template>
            <template v-slot:item.created_at="{ item }">{{item.created_at | fromNow}}</template>
            <template
                v-slot:item.attend_member_count="{ item }"
            >{{item.attend_members && item.attend_members.length}}</template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="controlEditor('editItem',item)">mdi-pencil</v-icon>
                <v-icon small @click="controlEditor('deleteItem',item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>データが存在しません。</template>)
        </v-data-table>
    </v-container>
</template>

<script>
import { watch } from "@/store";
import MInvitationsEditor from "@/components/MInvitationEditor";
export default {
    components: {
        MInvitationsEditor
    },
    data: () => ({
        headers: [
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
                text: "招待人数",
                align: "left",
                sortable: false,
                value: "membersCount"
            },
            {
                text: "締切日",
                align: "right",
                sortable: true,
                value: "deadline_at"
            },
            {
                text: "作成日時",
                align: "right",
                sortable: true,
                value: "created_at"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        invitations: []
    }),
    created() {
        watch("invitations", this.invitations, { url: "/invitations/admin" });
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