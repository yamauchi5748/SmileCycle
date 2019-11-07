<template>
    <secondary-view>
        <template #title>会員作成</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.name" :error="errors.name" counter :max="15">会員名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.ruby" :error="errors.ruby" counter :max="30">ふりがな</v-input>
            </div>
            <div class="input-wrapper">
                <v-input
                    v-model="property.telephone_number"
                    :error="errors.telephone_number"
                    counter
                >電話番号</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.mail" :error="errors.mail">メールアドレス</v-input>
            </div>
            <div class="input-wrapper">
                <v-select v-model="property.company_id" :error="errors.company_id">会社名</v-select>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.post" :error="errors.post" counter :max="50">役職</v-input>
            </div>
            <div class="input-wrapper">
                <v-input
                    v-model="property.department_name"
                    :error="errors.department_name"
                >部門</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.secretary_name" :error="errors.secretary_name">秘書名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.secretary_mail" :error="errors.secretary_mail">秘書メールアドレス</v-input>
            </div>
            <div class="input-wrapper">
                <v-input
                    v-model="property.password"
                    :error="errors.password"
                    type="password"
                    counter
                    :max="100"
                >パスワード</v-input>
            </div>
            <div class="input-wrapper">
                <v-input
                    v-model="property.password_confirmation"
                    :error="errors.password_confirmation"
                    type="password"
                    counter
                    :max="100"
                >パスワード再入力</v-input>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button" @click="$router.push({name:'controls-member'})">取り消し</button>
                <button class="normal-button" @click="handleClick">登録する</button>
            </div>
        </template>
    </secondary-view>
</template>
<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput";
import VSelect from "../VSelect";
export default {
    data: function() {
        return {
            errors: {},
            property: {
                name: "会員名",
                ruby: "かいいんめい",
                post: "社長",
                mail: "a@a.a",
                phone_number: "090-2822-2222",
                company_id: "",
                department_name: "愛媛笑門会",
                password: "1234abcd",
                password_confirmation: "1234abcd"
            }
        };
    },
    methods: {
        handleClick: function() {
            const self = this;
            this.$root
                .createMember(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-member" });
                })
                .catch(function(error) {
                    self.errors = error.response.data.errors;
                });
        }
    },
    components: {
        VSelect,
        VInput,
        SecondaryView
    }
};
</script>