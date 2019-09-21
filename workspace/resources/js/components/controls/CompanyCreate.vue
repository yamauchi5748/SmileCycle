<template>
    <div class="view controls-secondary-view">
        <div class="controls-secondary-header">
            <button @click="goBack" class="go-back-button">←</button>
            <h2 class="title">会社作成</h2>
        </div>
        <div class="controls-secondary-body">
            <div class="input-area">
                <v-input v-model="name" counter :max="140">会社名</v-input>
                <v-input v-model="address">住所</v-input>
                <v-input v-model="phone_number">電話番号</v-input>
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
            name: "",
            address: "",
            phone_number: ""
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