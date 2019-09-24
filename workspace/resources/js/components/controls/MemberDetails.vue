<template>
    <secondary-view>
        <template #title>会員詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="ruby" counter :max="50">ふりがな</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="phone_number" counter>電話番号</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="mail">メールアドレス</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="company_id">会員名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="post" counter>役職</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="department_name" counter>部門</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="password" type="password" counter>パスワード</v-input>
            </div>
            <div class="buttons-wrapper --space-between">
                <button class="flat-button">削除する</button>
                <button class="normal-button">保存する</button>
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
            profile_image: null,
            name: "",
            ruby: "",
            phone_number: "",
            mail: "",
            company_id: "",
            post: "",
            department_name: "",
            password: ""
        };
    },
    created: function() {
        this.$root.loadMembers();
        console.log(
            this.$root.members.find(member => {
                return member._id == this.$route.params.id;
            })
        );
    },
    components: {
        VInput,
        SecondaryView
    }
};
</script>

<style lang="scss" scoped>
</style>