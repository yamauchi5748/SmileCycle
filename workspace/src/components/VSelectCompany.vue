<template>
    <v-select
        :readonly="readonly"
        :label="label"
        v-model="selected"
        :items="companies"
        item-text="name"
        item-value="id"
        :rules="rules"
    ></v-select>
</template>

<script>
import { watch } from "@/store";
export default {
    props: {
        readonly: Boolean,
        label: String,
        value: String,
        rules: Array
    },
    data: () => ({
        companies: []
    }),
    created() {
        watch("companies", this.companies);
    },
    computed: {
        selected: {
            get() {
                return this.value;
            },
            set(new_value) {
                this.$emit("input", new_value);
            }
        }
    }
};
</script>

<style>
</style>