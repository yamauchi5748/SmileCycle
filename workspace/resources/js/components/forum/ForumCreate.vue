<template>
    <secondary-view>
        <template #title>みんなの掲示板投稿</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="title" counter :max="25">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="images">画像</v-input-multiple-images>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button">取り消し</button>
                <button class="normal-button">登録する</button>
            </div>
        </template>
    </secondary-view>
</template>
<script>
import SecondaryView from "../controls/SecondaryView.vue";
import VInput from "../VInput";
import VInputMultipleImages from "../VInputMultipleImages";
import VInputCheckbox from "../VInputCheckbox";
export default {
    data: function() {
        return {
            title: "",
            text: "",
            images: [],
            attend_members: []
        };
    },
    components: {
        VInput,
        VInputMultipleImages,
        VInputCheckbox,
        SecondaryView
    }
};
</script>
<style lang="scss" scoped>
</style>