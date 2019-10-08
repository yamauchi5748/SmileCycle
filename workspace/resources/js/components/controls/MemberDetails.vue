<template>
    <secondary-view>
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
            <div class="buttons-wrapper --space-between">
                <button class="flat-button" @click="handleDeleteButtonClick">削除する</button>
                <button class="normal-button" @click="handlePostButtonClick">保存する</button>
            </div>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput";
export default {
    components: {
        VInput,
        SecondaryView
    },
    data: function() {
        return {
            property: {}
        };
    },
    created: function() {
        this.$root
            .getMember(this.$route.params.id)
            .then(res => {
                this.setData(res.data.member);
                console.log(res);
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        handlePostButtonClick: function() {
            this.$root
                .editMember(this.property)
                .then(function(res) {
                    console.log("会員編集成功しました");
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        handleDeleteButtonClick: function() {
            this.$root
                .deleteMember(this.property._id)
                .then(function(res) {
                    console.log("会員削除しました");
                    this.$route.go(-1);
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        // データをセット
        setData: function(member) {
            this.property = member;
        }
    }
};
</script>

<style lang="scss" scoped>
</style>