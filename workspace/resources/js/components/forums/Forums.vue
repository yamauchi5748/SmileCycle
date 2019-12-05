<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-row>
                    <div class="headline ml-4">みんなの掲示板</div>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        :fullscreen="!$vuetify.breakpoint.lgAndUp"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-btn color="accent" v-on="on">みんなの掲示板作成</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">みんなの掲示板作成</span>
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
                </v-row>
                <v-divider></v-divider>
            </v-col>
            <v-col cols="12" md="6" v-for="forum in forums" :key="forum._id">
                <forum-item :forum="forum"></forum-item>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ForumItem from "./ForumItem";
export default {
    data: () => ({
        dialog: false,
        forums_collection: [],
        forums: [],
        editedIndex: -1,
        editedItem: {
            title: "",
            text: "",
            images: []
        },
        defaultItem: {
            title: "",
            text: "",
            images: []
        }
    }),
    created() {
        this.forums_collection.get().then(this.setData);
        this.unsubscribe = this.forums_collection.onSnapshot(this.setData);
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
            confirm("このご案内を削除してもよろしいですか？") &&
                this.forums_collection.doc(item._id).delete(item);
        },

        close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },

        save() {
            this.forums_collection.add({
                ...this.editedItem,
                created_at: new Date()
            });
            this.close();
        }
    },
    destroyed() {
        this.unsubscribe();
    },
    components: { ForumItem }
};
</script>
