<template>
    <secondary-view>
        <template #title>会のご案内投稿</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.title" counter :max="20">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="property.images">画像</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <v-input-date v-model="property.deadline_at">締め切り時刻</v-input-date>
            </div>
            <div class="input-wrapper">
                <div class="input-title">招待者</div>
                <v-select-members v-model="property.attend_members"></v-select-members>
            </div>
            <div class="buttons-wrapper">
                <button class="normal-button margin-left-auto" @click="handleSubmitButtonClick">登録する</button>
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
            property: {
                title: "",
                text: "",
                images: [],
                attend_members: [],
                deadline_at:""
            }
        };
    },
    methods: {
        handleSubmitButtonClick: function() {
            const self = this;
            this.$root
                .createAdminInvitation(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-invitation" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
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