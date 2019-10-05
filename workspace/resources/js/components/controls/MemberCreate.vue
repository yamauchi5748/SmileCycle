<template>
    <secondary-view>
        <template #title>会員作成</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.name" counter :max="15">会員名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.ruby" counter :max="30">ふりがな</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.phone_number" counter>電話番号</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.mail">メールアドレス</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.company_id" counter :max="140">会社名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.post" counter :max="50">役職</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.department_name" counter>部門</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.secretary_name">秘書名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.secretary_mail">秘書メールアドレス</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.password" type="password" counter :max="100">パスワード</v-input>
            </div>
            <div class="input-wrapper">
                <v-input
                    v-model="property.password_confirmation"
                    type="password"
                    counter
                    :max="100"
                >パスワード再入力</v-input>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button" @click="$router.go(-1)">取り消し</button>
                <button class="normal-button" @click="handleClick">登録する</button>
            </div>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput";
export default {
    data: function() {
        return {
            property: {
                name: "",
                ruby: "",
                post: "",
                mail: "",
                phone_number: "",
                company_id: "",
                department_name: "",
                secretary_name: "",
                secretary_mail: "",
                password: "",
                password_confirmation: ""
            }
        };
    },
    methods: {
        handleClick: function() {
            this.$root.createMember(this.property).catch(function(error) {
                console.error(error);
            });
        }
    },
    components: {
        VInput,
        SecondaryView
    }
};
</script>