<template>
    <v-sheet>
        <v-card class="d-flex flex-wrap">
            <v-img
                class="flex-grow-0 flex-shrink-0 ma-1"
                aspect-ratio="1"
                v-for="(name,index) in value"
                :key="index"
                height="65"
                width="65"
                :src="'/api/images/'+name"
                @click.stop="deleteImage(name)"
            >
                <template v-slot:placeholder>
                    <v-row class="fill-height ma-0" align="center" justify="center">
                        <v-progress-circular indeterminate color="grey"></v-progress-circular>
                    </v-row>
                </template>
            </v-img>
        </v-card>
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
                this.$emit(
                    "input",
                    this.value.filter(val => name != val)
                );
        }
    }
};
</script>

<style>
</style>