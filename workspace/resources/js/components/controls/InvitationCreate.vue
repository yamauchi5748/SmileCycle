<template>
    <div class="view controls-secondary-view">
        <div class="controls-secondary-header">
            <button @click="goBack" class="go-back-button">←</button>
            <h2 class="title">会のご案内投稿</h2>
        </div>
        <div class="controls-secondary-body">
            <div class="input-area">
                <v-input v-model="title" counter :max="25">タイトル</v-input>
                <v-input v-model="text" counter :max="500" multiline>本文</v-input>
                <div class="input-wrapper">
                    <span class="input-title">画像</span>
                    <v-input-image v-model="images"></v-input-image>
                </div>
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
import VInputImage from "../VInputImage"
export default {
    data: function() {
        return {
            title: "",
            text: "",
            images: [],
        };
    },
    mounted() {
        this.list["controls"];
    },
    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        },
    },
    components: {
        VInput,
        VInputImage
    }
};
</script>
<style lang="scss" scoped>
</style>