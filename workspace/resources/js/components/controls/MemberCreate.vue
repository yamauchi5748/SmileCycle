<template>
    <div class="view controls-secondary-view">
        <div class="controls-secondary-header">
            <button @click="goBack" class="go-back-button">←</button>
            <h2 class="title">会員作成</h2>
        </div>
        <div class="controls-secondary-body">
            <div class="input-area">
                <v-input v-model="name" counter :max="20">会員名</v-input>
                <v-input v-model="ruby" counter :max="50">ふりがな</v-input>
                <v-input v-model="phone_number" counter>電話番号</v-input>
                <v-input v-model="mail">メールアドレス</v-input>
                <v-input v-model="company_id">会員名</v-input>
                <v-input v-model="post" counter>役職</v-input>
                <v-input v-model="department_name" counter>部門</v-input>
                <v-input v-model="password" type="password" counter>パスワード</v-input>
            </div>
        </div>
        <div class="controls-secondary-footer">
            <button class="flat-button">取り消し</button>
            <button class="normal-button">登録する</button>
        </div>
    </div>
</template>

<script>
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
    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        }
    },
    components: {
        VInput
    }
};
</script>

<style lang="scss" scoped>
</style>