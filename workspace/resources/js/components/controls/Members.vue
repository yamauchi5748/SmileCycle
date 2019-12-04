<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="members"
            multi-sort
            loading-text="データ取得中..."
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>会員</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        :fullscreen="!$vuetify.breakpoint.lgAndUp"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-btn color="accent" v-on="on">会員作成</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.name" label="名前"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.ruby" label="ふりがな"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.telephone_number"
                                                type="tel"
                                                label="電話番号"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.mail" label="メールアドレス"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-select-company
                                                v-model="editedItem.company_id"
                                                label="会社"
                                            ></v-select-company>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.post" label="役職"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-select
                                                v-model="editedItem.department_name"
                                                :items="['愛媛笑門会','東京笑門会','大阪笑門会','鎌倉笑門会']"
                                                label="部門"
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.secretary_name"
                                                label="秘書名"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.secretary_mail"
                                                label="秘書メールアドレス"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.password"
                                                type="password"
                                                label="パスワード"
                                            ></v-text-field>
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
            <template v-slot:item.profile_img="{ item }">
                <v-avatar color="grey" size="32">
                    <img :src="item.profile_img" />
                </v-avatar>
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
import VSelectCompany from "../VSelectCompany";
export default {
    data: () => ({
        loading: true,
        dialog: false,
        headers: [
            {
                text: "プロフ画像",
                align: "left",
                sortable: false,
                value: "profile_img"
            },
            {
                text: "名前",
                align: "left",
                sortable: true,
                value: "name"
            },
            { text: "ふりがな", align: "left", sortable: true, value: "ruby" },
            { text: "役職名", align: "left", sortable: true, value: "post" },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        members_collection: [],
        unsubscribe: null,
        members: [],
        editedIndex: -1,
        editedItem: {
            name: "",
            ruby: "",
            telephone_number: "",
            mail: "",
            company_id: "",
            post: "",
            department_name: "",
            secretary_name: "",
            secretary_mail: "",
            password: ""
        },
        defaultItem: {
            name: "",
            ruby: "",
            telephone_number: "",
            mail: "",
            company_id: "",
            post: "",
            department_name: "",
            secretary_name: "",
            secretary_mail: "",
            password: ""
        }
    }),
    created() {
        this.members_collection.get().then(snapshot => {
            this.setData(snapshot);
            this.loading = false;
        });
        this.unsubscribe = this.members_collection.onSnapshot(this.setData);
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "会員作成" : "会員編集";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    methods: {
        setData(snapshot) {
            this.members = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        },
        editItem(item) {
            this.editedIndex = this.members.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            confirm("この会社を削除してもよろしいですか？") &&
                this.members_collection.doc(item._id).delete();
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
                this.members_collection
                    .doc(this.editedItem._id)
                    .set(this.editedItem);
            } else {
                this.members_collection.add(this.editedItem);
            }
            this.close();
        }
    },
    destroyed() {
        this.unsubscribe();
    },
    components: {
        VSelectCompany
    }
};
</script>

<style>
</style>