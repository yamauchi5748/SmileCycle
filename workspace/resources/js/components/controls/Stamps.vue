<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="stamps"
            :loading="store.stamps.loading"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>スタンプ</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        :fullscreen="!$vuetify.breakpoint.lgAndUp"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-btn color="accent" v-on="on">スタンプ作成</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-file-input label="タブ画像"></v-file-input>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-file-input small-chips multiple label="スタンプ"></v-file-input>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close">取り消し</v-btn>
                                <v-btn color="blue darken-1" text @click="save">保存する</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.stamp_count="{ item }">{{item.stamps.length}}</template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>データが存在しません。</template>
        </v-data-table>
    </v-container>
</template>

<script>
import store from "../../store";
export default {
    data: () => ({
        dialog: false,
        headers: [
            {
                text: "タブ画像",
                align: "left",
                sortable: false,
                value: "tab_image"
            },
            {
                text: "スタンプ数",
                align: "right",
                sortable: false,
                value: "stamp_count"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        store,
        editedIndex: -1,
        editedItem: {
            tab_image: "",
            stamps: []
        },
        defaultItem: {
            tab_image: "",
            stamps: []
        }
    }),

    computed: {
        stamps() {
            return this.store.stamps.data;
        },
        formTitle() {
            return this.editedIndex === -1 ? "スタンプ作成" : "スタンプ編集";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    methods: {
        editItem(item) {
            this.editedIndex = this.stamps.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            confirm("このスタンプを削除してもよろしいですか？") &&
                store.stamps.delete(item);
        },

        close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },

        save() {
            if (this.editedIndex > -1) {
                store.stamps.edit(this.editedItem);
            } else {
                store.stamps.create(this.editedItem);
            }
            this.close();
        }
    }
};
</script>

<style>
</style>