<template>
    <div class="loading" v-loaded.shadow="is_loaded">
        <img class="p-img" :src="src" v-on="$listeners" @load="handleLoad" />
        <div class="shadow"></div>
    </div>
</template>

<script>
export default {
    props: {
        src: String
    },
    data: function() {
        return {
            is_loaded: false
        };
    },
    methods: {
        handleLoad: function() {
            this.is_loaded = true;
        }
    }
};
</script>

<style lang="scss" scoped>
.p-img {
    height: inherit;
    width: inherit;
    display: inherit;
}
</style>