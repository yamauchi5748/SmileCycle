<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="companies"
            multi-sort
            loading-text="データ取得中..."
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title>会社</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog
                        v-model="dialog"
                        :fullscreen="!$vuetify.breakpoint.lgAndUp"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-btn color="accent" v-on="on">会社作成</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.name"
                                                label="会社名"
                                                :rules="[rules.required]"
                                                validate-on-blur
                                                counter="20"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.telephone_number"
                                                label="電話番号"
                                                mask="phone"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.address" label="住所"></v-text-field>
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
                text: "会社名",
                align: "left",
                sortable: true,
                value: "name"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        companies_collection: [],
        companies: [],
        unsubscribe: null, //リスナーのデタッチ用の関数が入る
        editedIndex: -1,
        editedItem: {
            name: "",
            address: "",
            telephone_number: ""
        },
        defaultItem: {
            name: "",
            address: "",
            telephone_number: ""
        },
    }),
    created() {
        this.companies_collection.get().then(snapshot => {
            this.setData(snapshot);
            this.loading = false;
        });
        this.unsubscribe = this.companies_collection.onSnapshot(this.setData);
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "会社作成" : "会社編集";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    methods: {
        setData(snapshot) {
            this.companies = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        },
        editItem(item) {
            this.editedIndex = this.companies.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },
        deleteItem(item) {
            confirm("この会社を削除してもよろしいですか？") &&
                this.companies_collection.doc(item._id).delete();
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
                this.companies_collection
                    .doc(this.editedItem._id)
                    .set(this.editedItem);
            } else {
                this.companies_collection.add(this.editedItem);
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