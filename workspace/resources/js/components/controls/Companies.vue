<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="companies"
            multi-sort
            loading-text="データ取得中..."
            :loading="store.companies.loading"
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
                                <v-form ref="form" lazy-validation>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="editedItem.name"
                                                    label="会社名"
                                                    :rules="validation.companyNameRules"
                                                    :counter="140"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="editedItem.telephone_number"
                                                    label="電話番号"
                                                    :rules="validation.telRules"
                                                     hint="数値のみの入力にしてください。ハイフン(-)不要"
                                                    persistent-hint
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="editedItem.address"
                                                    label="住所"
                                                    :rules="validation.addressRules"
                                                    :counter="140"
                                                    required
                                                ></v-text-field>
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
                text: "会社名",
                align: "left",
                sortable: true,
                value: "name"
            },
            { text: "", align: "right", sortable: false, value: "action" }
        ],
        store,
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

    computed: {
        companies() {
            return this.store.companies.data;
        },
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
        editItem(item) {
            this.editedIndex = this.companies.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            confirm("この会社を削除してもよろしいですか？") &&
                store.companies.delete(item);
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
                if (this.editedIndex > -1) {
                    store.companies.edit(this.editedItem);
                } else {
                    store.companies.create(this.editedItem);
                }
                this.close();
            }
        }
    }
};
</script>

<style>
</style>