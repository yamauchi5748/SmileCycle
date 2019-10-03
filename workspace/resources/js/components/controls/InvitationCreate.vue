<template>
    <secondary-view>
        <template #title>会のご案内投稿</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="title" counter :max="20">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="images">画像</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <v-input-date>締め切り時刻</v-input-date>
            </div>
            <div class="input-wrapper">
                <div class="input-title">招待者</div>
                <v-select-members v-model="attend_members"></v-select-members>
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
import VInputMultipleImages from "../VInputMultipleImages";
import VInputCheckbox from "../VInputCheckbox";
import VSelectMembers from "../VSelectMembers";
import VInputDate from "../VInputDate";
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
        VSelectMembers,
        VInputDate,
        SecondaryView
    }
};
</script>
<style lang="scss" scoped>
</style>