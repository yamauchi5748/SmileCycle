<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="forums"
            multi-sort
            loading-text="データを取得中..."
            :loading="store.forums.loading"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>みんなの掲示板</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        :fullscreen="!$vuetify.breakpoint.lgAndUp"
                        max-width="500px"
                    >
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-form ref="form" lazy-validation>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="editedItem.title"
                                                    label="タイトル"
                                                    :rules="validation.titleRules"
                                                    :counter="20"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-textarea
                                                    v-model="editedItem.text"
                                                    label="本文"
                                                    :rules="validation.textRules"
                                                    :counter="500"
                                                    required
                                                    no-resize
                                                ></v-textarea>
                                            </v-col>
                                            <v-col cols="12">
                                                <!-- デザインの考案 -->
                                                <v-file-input accept="image/*" multiple label="画像"></v-file-input>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-form>
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
            <template v-slot:item.title="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.title}}</span>
            </template>
            <template v-slot:item.text="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.text}}</span>
            </template>
            <template v-slot:item.created_at="{ item }">
                <span
                    class="d-inline-block text-truncate"
                    style="max-width:200px;"
                >{{item.created_at}}</span>
            </template>
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
import validation from "../../validation";
export default {
    data: () => ({
        dialog: false,
        validation,
        headers: [
            {
                text: "投稿者",
                align: "left",
                sortable: false,
                value: "sender_name"
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
        store,
        editedIndex: -1,
        editedItem: {
            title: "",
            text: "",
            images: [""]
        },
        defaultItem: {
            title: "",
            text: "",
            images: []
        }
    }),
    computed: {
        forums() {
            return this.store.forums.data;
        },
        formTitle() {
            return "投稿編集";
        }
    },
    watch: {
        dialog(val) {
            val || this.close();
        }
    },
    methods: {
        editItem(item) {
            this.editedIndex = this.forums.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            const index = this.forums.indexOf(item);
            if (confirm("この投稿を削除してもよろしいですか？")) {
                // 削除
                this.forums.splice(index, 1);
            }
        },

        close() {
            this.dialog = false;
            setTimeout(() => {
                this.$refs.form.resetValidation();
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },

        save() {
            if (this.$refs.form.validate()) {
                //保存
                Object.assign(this.forums[this.editedIndex], this.editedItem);

                this.close();
            }
        }
    }
};
</script>

<style>
</style>