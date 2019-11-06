<template>
    <secondary-view v-loaded="is_loaded">
        <template #title>会社詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.name" :error="errors.name" counter :max="140">会社名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.address" :error="errors.address">住所</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.telephone_number" :error="errors.telephone_number">電話番号</v-input>
            </div>
            <div class="buttons-wrapper --space-between">
                <button class="flat-button" @click="handleDeleteButtonClick">削除する</button>
                <button class="normal-button" @click="handlePostButtonClick">保存する</button>
            </div>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput";
export default {
    data: function() {
        return {
            is_loaded: false,
            errors: {},
            property: {}
        };
    },
    components: {
        VInput,
        SecondaryView
    },
    created: function() {
        // 対象の会社情報を取得
        const self = this;
        this.$root.getCompany(this.$route.params.id).then(function(response) {
            self.property = response.data.company;
            self.is_loaded = true;
        });
    },
    methods: {
        //会社編集
        handlePostButtonClick: function() {
            const self = this;
            this.$root
                .editCompany(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-company" });
                })
                .catch(function(error) {
                    self.errors = error.response.data.errors;
                });
        },
        //会社削除
        handleDeleteButtonClick: function() {
            const self = this;
            this.$root
                .deleteCompany(this.property._id)
                .then(function(response) {
                    self.$router.push({ name: "controls-company" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    }
};
</script>