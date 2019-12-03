<template>
    <v-container>
        <v-data-table :headers="headers" :items="stamps" :loading="loading" class="elevation-1">
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
        loading: true,
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
        stamps_collection: store.collection("stamps"),
        unsubscribe: null,
        stamps: [],
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
    created() {
        this.stamps_collection.get().then(snapshot => {
            this.setData(snapshot)
            this.loading = false;
        });
        this.unsubscribe = this.stamps_collection.onSnapshot(this.setData);
    },
    computed: {
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
        setData(snapshot) {
            this.stamps = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        },
        editItem(item) {
            this.editedIndex = this.stamps.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            confirm("このスタンプを削除してもよろしいですか？") &&
                this.stamps_collection.doc(item._id).delete();
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
                this.stamps_collection
                    .doc(this.editedItem._id)
                    .set(this.editedItem);
            } else {
                this.stamps_collection.add(this.editedItem);
            }
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