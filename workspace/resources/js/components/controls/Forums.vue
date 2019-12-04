<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="forums"
            multi-sort
            loading-text="データを取得中..."
            :loading="loading"
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
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.title" label="タイトル"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea
                                                v-model="editedItem.text"
                                                label="本文"
                                                no-resize
                                            ></v-textarea>
                                        </v-col>
                                        <v-col cols="12">
                                            <!-- デザインの考案 -->
                                            <v-file-input accept="image/*" multiple label="画像"></v-file-input>
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
            <template v-slot:item.title="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.title}}</span>
            </template>
            <template v-slot:item.text="{ item }">
                <span class="d-inline-block text-truncate" style="max-width:200px;">{{item.text}}</span>
            </template>
            <template v-slot:item.created_at="{ item }">{{item.created_at | date_format}}</template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>データが存在しません。</template>
        </v-data-table>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        loading: true,
        dialog: false,
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
        forums_collection: [],
        unsubscribe: null,
        forums: [],
        editedIndex: -1,
        editedItem: {
            title: "",
            text: "",
            images: [],
            comments: []
        },
        defaultItem: {
            title: "",
            text: "",
            images: [],
            comments: []
        }
    }),
    created() {
        this.forums_collection.get().then(snapshot => {
            this.setData(snapshot);
            this.loading = false;
        });
        this.unsubscribe = this.forums_collection.onSnapshot(this.setData);
    },
    computed: {
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
        setData(snapshot) {
            this.forums = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        },
        editItem(item) {
            this.editedIndex = this.forums.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            confirm("この投稿を削除してもよろしいですか？") &&
                this.forums_collection.doc(item._id).delete();
        },

        close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },

        save() {
            this.forums_collection
                .doc(this.editedItem._id)
                .set(this.editedItem);
            this.close();
        }
    },
    destroyed() {
        this.unsubscribe();
    }
};
</script>

<style>
</style>