<template>
    <secondary-view v-loaded="is_loaded">
        <template #title>会のご案内詳細</template>
        <template #body>
            {{is_loaded}}
            <div class="input-wrapper">
                <v-input v-model="property.title" counter :max="25">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images
                    v-model="edit_images"
                    :prefix="'/invitations/'+property._id+'/images/'"
                >画像</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <v-input-date v-model="property.deadline_at">締め切り時刻</v-input-date>
            </div>
            <div class="input-wrapper">
                <div class="input-title">招待者</div>
                <v-select-members v-model="edit_attend_members"></v-select-members>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button" @click="handleDeleteButtonClick">削除する</button>
                <button class="normal-button margin-left-auto" @click="handleSubmitButtonClick">保存する</button>
            </div>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput.vue";
import VInputDate from "../VInputDate.vue";
import VInputMultipleImages from "../VInputMultipleImages.vue";
import VSelectMembers from "../VSelectMembers.vue";
export default {
    data: function() {
        return {
            is_loaded:false,
            edit_images: [],
            edit_attend_members: [],
            property: {
                title: "",
                text: "",
                images: [],
                deadline_at: "",
                attend_members: []
            }
        };
    },
    created: function() {
        const self = this;
        this.$root
            .getAdminInvitation(this.$route.params.id)
            .then(function(response) {
                self.property = Object.assign(
                    {},
                    self.property,
                    response.data.invitation
                );
                self.property.deadline_at =
                    self.property.deadline_at &&
                    self.property.deadline_at.slice(0, 10);
                self.edit_images = self.property.images;
                self.edit_attend_members = self.property.attend_members.map(
                    function(member) {
                        return member._id;
                    }
                );
                self.is_loaded = true;
            });
    },
    methods: {
        handleSubmitButtonClick: function() {
            const self = this;
            this.property.add_images = this.edit_images.filter(function(
                edit_image
            ) {
                return typeof edit_image == "object";
            });
            this.property.delete_images = this.property.images.filter(function(
                edit_image
            ) {
                return (
                    -1 ==
                    self.edit_images.findIndex(function(image) {
                        return edit_image == image;
                    })
                );
            });
            this.property.add_attend_members = this.edit_attend_members.filter(
                function(edit_attend_member) {
                    return (
                        -1 ==
                        self.property.attend_members.findIndex(function(
                            attend_member
                        ) {
                            return edit_attend_member == attend_member._id;
                        })
                    );
                }
            );
            this.property.delete_attend_members = this.property.attend_members
                .filter(function(attend_member) {
                    return (
                        -1 ==
                        self.edit_attend_members.findIndex(function(
                            edit_attend_member
                        ) {
                            return attend_member._id == edit_attend_member;
                        })
                    );
                })
                .map(function(member) {
                    return member._id;
                });
            this.$root
                .editAdminInvitation(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-invitation" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        handleDeleteButtonClick: function() {
            const self = this;
            this.$root
                .deleteAdminInvitation(this.property._id)
                .then(function(response) {
                    self.$router.push({ name: "controls-invitation" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    },
    components: {
        SecondaryView,
        VInput,
        VInputDate,
        VInputMultipleImages,
        VSelectMembers
    }
};
</script>

<style lang="scss" scoped>
</style>