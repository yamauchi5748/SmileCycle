<template>
    <div class="fill-height d-flex justify-center align-center">
        <v-select
            v-model="store.profile"
            item-text="name"
            return-object
            :items="store.members.data"
        ></v-select>
    </div>
</template>

<script>
import store from "../store";
export default {
    data: () => ({
        store
    })
};
</script>

<style>
</style>