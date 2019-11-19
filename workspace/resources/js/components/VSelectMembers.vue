<template>
    <v-select
        :label="label"
        v-model="selected"
        :items="members"
        item-text="name"
        item-value="_id"
        multiple
        chips
    ></v-select>
</template>

<script>
import store from "../store";
export default {
    props: {
        label: String,
        value: Array
    },
    data: () => ({
        headers: [
            {
                text: "会員名",
                align: "left",
                sortable: true,
                value: "name"
            }
        ],
        store
    }),
    computed: {
        selected: {
            get() {
                return this.value;
            },
            set() {
                this.$emit("input", this.value);
            }
        },
        members() {
            return this.store.members.data;
        }
    }
};
</script>

<style>
</style>