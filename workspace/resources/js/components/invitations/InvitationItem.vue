<template>
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="headline">{{invitation.title}}</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-carousel show-arrows-on-hover v-if="invitation.images.length > 0">
            <v-carousel-item v-for="image in invitation.images" :key="image" :src="image" contain></v-carousel-item>
        </v-carousel>
        <v-card-text class="font-regular black--text">{{invitation.text}}</v-card-text>
        <v-divider></v-divider>
        <v-card-title>
            招待者
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="検索..."
                single-line
                hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table :headers="headers" :items="invitation.attend_members" :search="search" dense>
            <template v-slot:item.status="{ item }">{{ ["未回答","参加","不参加"][item.status]}}</template>
        </v-data-table>
        <p class="text-center">回答締切期限:{{invitation.deadline_at | date_format}}</p>
        <v-card-actions class="mt-12 d-flex justify-space-around">
            <v-btn outlined color="accent">不参加</v-btn>
            <v-btn outlined color="accent">参加</v-btn>
        </v-card-actions>
        <div class="mx-4 text-right caption grey--text">投稿日時:{{invitation.created_at | date_format}}</div>
    </v-card>
</template>

<script>
export default {
    props: {
        invitation: {
            type: Object,
            require: true
        }
    },
    data() {
        return {
            search: "",
            headers: [
                {
                    text: "会員名",
                    align: "left",
                    sortable: false,
                    value: "name"
                },
                {
                    text: "ふりがな",
                    align: "left",
                    sortable: true,
                    value: "ruby"
                },
                {
                    text: "",
                    align: "right",
                    sortable: true,
                    value: "status"
                }
            ]
        };
    }
};
</script>

<style>
</style>