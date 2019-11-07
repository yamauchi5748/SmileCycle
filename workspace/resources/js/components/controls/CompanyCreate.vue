<template>
    <secondary-view>
        <template #title>会社登録</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="property.name" :error="errors.name" counter :max="140">会社名</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="property.address" :error="errors.address" counter :max="128">住所</v-input>
            </div>
            <div class="input-wrapper">
                <v-input
                    v-model="property.telephone_number"
                    :error="errors.telephone_number"
                    type="tel"
                >電話番号</v-input>
            </div>
            <div class="buttons-wrapper">
                <button class="flat-button" @click="$router.push({name:'controls-company'})">取り消し</button>
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
            errors: {},
            property: {
                name: "",
                address: "",
                telephone_number: ""
            }
        };
    },
    methods: {
        handleClick: function() {
            const self = this;
            this.$root
                .createCompany(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-company" });
                })
                .catch(function(error) {
                    self.errors = error.response.data.errors;
                });
        }
    },
    components: {
        VInput,
        SecondaryView
    }
};
</script>