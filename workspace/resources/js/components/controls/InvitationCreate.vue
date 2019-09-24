<template>
    <secondary-view>
        <template #title>会のご案内投稿</template>
        <template #body>
                <div class="inputwrapper">
                    <v-input v-model="title" counter :max="25">タイトル</v-input>
                </div>
                <div class="input-wrapper">
                    <v-input v-model="text" counter :max="500" multiline>本文</v-input>
                </div>
                <div class="input-wrapper">
                    <v-input-image v-model="images">画像</v-input-image>
                </div>
                <div class="buttons-wrapper">
                    <button class="flat-button">取り消し</button>
                    <button class="normal-button">登録する</button>
                </div>
        </template>
    </secondary-view>
</template>
<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput";
import VInputImage from "../VInputImage";
export default {
    data: function() {
        return {
            title: "",
            text: "",
            images: []
        };
    },
    components: {
        VInput,
        VInputImage,
        SecondaryView
    }
};
</script>
<style lang="scss" scoped>
</style>