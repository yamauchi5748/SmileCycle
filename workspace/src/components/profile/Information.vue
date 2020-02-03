<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-row class="mt-4" justify="center">
                    <MAvatarEditor v-model="editedItem.avatar"></MAvatarEditor>
                </v-row>
                <v-row class="mt-3 display-1" justify="center">{{editedItem.name}}</v-row>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <div class="headline ml-4">情報</div>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="editedItem.ruby" label="ふりがな"></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="editedItem.tel" label="電話番号"></v-text-field>
                    </v-col>

                    <v-col cols="12">
                        <v-text-field v-model="editedItem.mail" label="メールアドレス"></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <span class="headline ml-4">秘書</span>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="editedItem.secretaryName" label="氏名"></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="editedItem.secretaryMail" label="メールアドレス"></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <span class="headline ml-4">所属</span>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="editedItem.department" label="部門"></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <VSelectCompany v-model="editedItem.companyId" label="会社名"></VSelectCompany>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field v-model="editedItem.post" label="役職"></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <v-row justify="center">
                    <v-btn @click="save" color="primary">保存する</v-btn>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { auth, axios } from "@/store";
import MAvatarEditor from "@/components/MAvatarEditor";
import VSelectCompany from "@/components/VSelectCompany";
export default {
    components: {
        MAvatarEditor,
        VSelectCompany
    },
    data: () => ({
        user: auth.user,
        editedItem: {
            avatar: "",
            name: "",
            ruby: "",
            tel: "",
            mail: "",
            companyId: "",
            post: "",
            department: "",
            secretaryName: "",
            secretaryMail: ""
        }
    }),
    created() {
        this.editedItem = Object.assign({}, this.user);
    },
    methods: {
        save() {
            confirm("現在の情報に更新しますか？") &&
                axios.post("members/" + this.user._id, this.editedItem);
        }
    }
};
</script>

<style>
</style>