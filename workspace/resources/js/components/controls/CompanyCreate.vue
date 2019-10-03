<template>
    <secondary-view>
        <template #title>会社登録</template>
        <template #body>
                <div class="input-wrapper">
                    <v-input v-model="name" counter :max="140">会社名</v-input>
                </div>
                <div class="input-wrapper">
                    <v-input v-model="address" counter :max="128">住所</v-input>
                </div>
                <div class="input-wrapper">
                    <v-input v-model="phone_number">電話番号</v-input>
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
export default {
    data: function() {
        return {
            name: "",
            address: "",
            phone_number: ""
        };
    },
    components: {
        VInput,
        SecondaryView
    }
};
</script>