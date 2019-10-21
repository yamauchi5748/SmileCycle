<template>
    <secondary-view>
        <template #title>スタンプ作成</template>
        <template #body>
            <div class="input-wrapper">
                <v-input-image v-model="property.tab_image">タブ画像</v-input-image>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="property.stamps">スタンプ</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <label class="input-label">
                    <v-input-checkbox v-model="property.is_all"></v-input-checkbox>全ての会員が利用する
                </label>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <v-select-members v-model="property.members"></v-select-members>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button">取り消し</button>
                <button class="normal-button" @click="handleSubmitButtonClick">登録する</button>
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
            property: {
                tab_image: null,
                stamps: [],
                is_all: true,
                members: []
            }
        };
    },
    created: function() {
        this.$root.loadMembers();
    },
    methods: {
        handleSubmitButtonClick: function() {
            this.$root.createStampGroup(this.property);
        }
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