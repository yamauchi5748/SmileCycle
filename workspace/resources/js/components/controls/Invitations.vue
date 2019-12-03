<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="invitations"
            multi-sort
            loading-text="データを取得中..."
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>会のご案内</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        :fullscreen="!$vuetify.breakpoint.lgAndUp"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-btn color="accent" v-on="on">会のご案内作成</v-btn>
                        </template>
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
                                        <v-col cols="12">
                                            <v-menu
                                                ref="menu"
                                                v-model="menu"
                                                :close-on-content-click="false"
                                                :return-value.sync="editedItem.deadline_at"
                                                transition="scale-transition"
                                                offset-y
                                                min-width="290px"
                                            >
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field
                                                        v-model="editedItem.deadline_at"
                                                        label="締切期限"
                                                        readonly
                                                        v-on="on"
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                    v-model="editedItem.deadline_at"
                                                    no-title
                                                    scrollable
                                                >
                                                    <v-spacer></v-spacer>
                                                    <v-btn
                                                        text
                                                        color="primary"
                                                        @click="menu = false"
                                                    >取り消し</v-btn>
                                                    <v-btn
                                                        text
                                                        color="primary"
                                                        @click="$refs.menu.save(editedItem.deadline_at)"
                                                    >設定</v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-select-members
                                                v-model="editedItem.attend_members"
                                                return-object
                                            ></v-select-members>
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
            <template
                v-slot:item.deadline_at="{ item }"
            >{{item.deadline_at | date_format("yyyy年MM月dd日")}}</template>
            <template v-slot:item.created_at="{ item }">{{item.created_at | date_format}}</template>
            <template
                v-slot:item.attend_member_count="{ item }"
            >{{item.attend_members && item.attend_members.length}}</template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>データが存在しません。</template>)
        </v-data-table>
    </v-container>
</template>

<script>
import store from "../../store";
export default {
    data: () => ({
        loading: true,
        dialog: false,
        menu: false, //ダイアログの内のdata-pickerの表示切替に使用
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
                value: "attend_member_count"
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
        invitations_collection: store.collection("invitations"),
        unsubscribe: null,
        invitations: [],
        editedIndex: -1,
        editedItem: {
            title: "",
            text: "",
            images: [],
            attend_members: [],
            deadline_at: ""
        },
        defaultItem: {
            title: "",
            text: "",
            images: [],
            attend_members: [],
            deadline_at: ""
        }
    }),
    created() {
        this.invitations_collection.get().then(snapshot => {
            this.setData(snapshot);
            this.loading = false;
        });
        this.unsubscribe = this.invitations_collection.onSnapshot(this.setData);
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? "会のご案内作成"
                : "会のご案内編集";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        }
    },
    methods: {
        setData(snapshot) {
            this.invitations = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        },
        editItem(item) {
            this.editedIndex = this.invitations.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            confirm("このご案内を削除してもよろしいですか？") &&
                this.invitations_collection.doc(item._id).delete();
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
                this.invitations_collection.doc(this.editedItem._id).set({
                    ...this.editedItem,
                    deadline_at: new Date(this.editedItem.deadline_at)
                });
            } else {
                this.invitations_collection.add({
                    ...this.editedItem,
                    created_at: new Date(),
                    deadline_at: new Date(this.editedItem.deadline_at)
                });
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