<template>
    <secondary-view v-loaded="is_loaded">
        <template #title>会員詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.name">会員名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.ruby" counter :max="50">ふりがな</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.telephone_number" counter>電話番号</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.mail">メールアドレス</v-input>
            </div>
            <div class="input-wrapper">
                <v-select v-model="property.company_id">会社名</v-select>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.post" counter>役職</v-input>
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
                <button class="flat-button" @click="handleDeleteButtonClick">削除する</button>
                <button class="normal-button" @click="handlePostButtonClick">保存する</button>
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
            errprs: {},
            property: {},
            is_loaded:false
        };
    },
    created: function() {
        const self = this;
        this.$root
            .getMember(this.$route.params.id)
            .then(function(response) {
                self.property = response.data.member;
                self.is_loaded = true;
            })
            .catch(function(error) {
                console.error(error);
            });
    },
    methods: {
        handlePostButtonClick: function() {
            const self = this;
            this.$root
                .editMember(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-member" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        handleDeleteButtonClick: function() {
            const self = this;
            this.$root
                .deleteMember(this.property._id)
                .then(function(response) {
                    self.$router.push({ name: "controls-member" });
                })
                .catch(function(error) {
                    console.error(error);
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

<style lang="scss" scoped>
</style>