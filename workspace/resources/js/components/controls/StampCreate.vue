<template>
    <secondary-view>
        <template #title>スタンプ作成</template>
        <template #body>
            <div class="input-wrapper">
                <v-input-image v-model="tab_image">タブ画像</v-input-image>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="stamp_images">スタンプ</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <label class="input-label">
                    <v-input-checkbox v-model="is_all"></v-input-checkbox>利用者を制限する
                </label>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <v-select-members v-model="members"></v-select-members>
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
import VInputImage from "../VInputImage";
import VInputMultipleImages from "../VInputMultipleImages.vue";
import VInputCheckbox from "../VInputCheckbox";
import VSelectMembers from "../VSelectMembers";
export default {
    data: function() {
        return {
            tab_image: "/img/invitation-post-image.jpg",
            is_all: false,
            stamp_images: [
                "/img/invitation-post-image.jpg",
                "/img/invitation-post-image.jpg",
                "/img/invitation-post-image.jpg"
            ],
            members: []
        };
    },
    created: function() {
        this.$root.loadMembers();
    },
    components: {
        VInputImage,
        VInputMultipleImages,
        VInputCheckbox,
        VSelectMembers,
        SecondaryView
    }
};
</script>