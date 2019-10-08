<template>
    <secondary-view>
        <template #title>会社登録</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.name" counter :max="140">会社名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.address" counter :max="128">住所</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.telephone_number">電話番号</v-input>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button" @click="$router.go(-1)">取り消し</button>
                <button class="normal-button" @click="handleClick">登録する</button>
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
            property: {
                name: "ちぇけちぇけ",
                address: "fjfeaej",
                telephone_number: "faklesf"
            }
        };
    },
    methods: {
        handleClick: function() {
            this.$root.createCompany(this.property).catch(function(error) {
                console.error(error);
            });
        }
    },
    components: {
        VInput,
        SecondaryView
    }
};
</script>