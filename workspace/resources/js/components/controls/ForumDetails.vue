<template>
    <secondary-view>
        <template #title>みんなの掲示板詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.title" counter :max="20">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images
                    v-model="edit_images"
                    :prefix="'/forums/'+property._id+'/images/'"
                >画像</v-input-multiple-images>
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
import VInputMultipleImages from "../VInputMultipleImages.vue";
import VSelectMembers from "../VSelectMembers.vue";
export default {
    components: {
        SecondaryView,
        VInput,
        VInputMultipleImages,
        VSelectMembers
    },
    created: function() {
        const self = this;
        this.$root.getForum(this.$route.params.id).then(function(response) {
            self.property = Object.assign(
                {},
                self.property,
                response.data.forum
            );
            self.edit_images = self.property.images;
        });
    },
    data: function() {
        return {
            edit_images: [],
            property: {
                title: "",
                text: "",
                images: []
            }
        };
    },

    methods: {
        handleSubmitButtonClick: function() {
            const self = this;
            this.property.add_images = this.edit_images.filter(function(image) {
                return typeof image == "object";
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
            this.$root
                .editForum(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-forum" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        handleDeleteButtonClick: function() {
            const self = this;
            this.$root
                .deleteForum(this.property._id)
                .then(function(response) {
                    self.$router.push({ name: "controls-forum" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    }
};
</script>

<style lang="scss" scoped>
</style>