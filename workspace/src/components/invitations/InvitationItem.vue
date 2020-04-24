<template>
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="headline">{{invitation.title}}</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-sheet color="black" v-if="invitation.images.length > 0">
            <v-carousel show-arrows-on-hover hide-delimiter-background height="300">
                <v-carousel-item
                    v-for="url in invitation.images"
                    :key="url"
                    :src="'/api/images/' + url"
                    contain
                ></v-carousel-item>
            </v-carousel>
        </v-sheet>
        <v-card-text
            class="font-regular black--text"
            style="white-space: pre-line"
        >{{invitation.text}}</v-card-text>
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
        <v-data-table
            :headers="headers"
            :items="invitation.members"
            :search="search"
            :mobile-breakpoint="0"
            dense
        >
            <template v-slot:item="{item}">
                <tr>
                    <td>{{invitation.membersTable[item].name}}</td>
                    <td>{{invitation.membersTable[item].ruby}}</td>
                    <td>{{invitation.statusTable && ["未回答","参加","不参加"][invitation.statusTable[item]] || "未回答"}}</td>
                </tr>
            </template>
        </v-data-table>
        <p class="text-center">回答締切期限:{{invitation.deadline_at}}</p>
        <v-card-actions class="mt-12 d-flex justify-space-around">
            <v-btn @click="setStatus(2)" outlined color="accent">不参加</v-btn>
            <v-btn @click="setStatus(1)" outlined color="accent">参加</v-btn>
        </v-card-actions>
        <div class="mx-4 text-right caption grey--text">投稿日時:{{invitation.created_at | fromNow}}</div>
    </v-card>
</template>

<script>
import { axios } from "@/store";
export default {
    props: {
        invitation: {
            type: Object,
            require: true
        }
    },
    data: () => ({
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
    }),
    methods: {
        getStatus(id) {
            try {
                return this.invitation.statusStatus[id][
                    ("未回答", "参加", "不参加")
                ];
            } catch (error) {
                return "未回答";
            }
        },
        setStatus(status) {
            axios.put("invitations/" + this.invitation.id + "/status", {
                status
            });
        }
    }
};
</script>

<style>
</style>