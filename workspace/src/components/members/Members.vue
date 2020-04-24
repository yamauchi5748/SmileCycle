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
            <ViewMember ref="viewer" />
            <v-data-table
                @click:row="view"
                :headers="headers"
                :items="members"
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
import ViewMember from "@/components/ViewMember";

export default {
    components: {
        ViewMember
    },
    data: () => ({
        search: "",
        headers: [
            {
                text: "プロフ画像",
                align: "center",
                sortable: false,
                value: "avatar"
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
                value: "companyName"
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
                value: "department"
            }
        ],
        members: []
    }),
    created() {
        watch("members", this.members);
    },
    methods:{
        view(member){
            this.$refs.viewer.view(member);
        }
    }
};
</script>

<style>
.max-height {
    max-height: 600px;
    overflow-y: scroll;
}
</style>