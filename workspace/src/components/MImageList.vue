<template>
    <v-sheet color="black">
        <v-carousel v-if="value.length" hide-delimiter-background height="370">
            <v-carousel-item
                v-for="(name,index) in value"
                :key="index"
                :src="'/api/images/'+name"
                @click.stop="deleteImage(name)"
                contain
            ></v-carousel-item>
        </v-carousel>
    </v-sheet>
</template>

<script>

export default {
    props: {
        value: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        deleteImage(name) {
            confirm("この画像を削除しますか？") &&
                this.$emit("input", this.value.filter(val => name != val));
        }
    }
};
</script>

<style>
</style>