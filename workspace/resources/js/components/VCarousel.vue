<template>
    <div class="carousel">
        <ul class="carousel-inner">
            <li
                v-show="current_carousel_idx == idx"
                class="carousel-item"
                v-for="(src ,idx) in images"
                :key="idx"
            >
                <img class="carousel-image" :src="src" />
            </li>
        </ul>
        <ul class="selector">
            <li
                :class="{active:current_carousel_idx == idx}"
                class="selector-item"
                v-for="(src ,idx) in images"
                :key="idx"
            >
                <img @click="select(idx)" class="selector-image" :src="src" />
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            current_carousel_idx: 0,
            images: [
                "/img/invitation-post-image.jpg",
                "/img/stamp.svg",
                "/img/invitation-post-image.jpg",
                "/img/stamp.svg"
            ]
        };
    },
    methods: {
        select(idx) {
            this.current_carousel_idx = idx;
        }
    }
};
</script>

<style lang="scss" scoped>
.carousel {
    width: 100%;
    overflow: hidden;
    &-inner {
        position: relative;
        display: flex;
        width: 100%;
        height: 400px;
    }
    &-item {
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        background-color: $base-color;
    }
    &-image {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: block;
        max-width: 100%;
        max-height: 100%;
        margin: auto;
    }
}
.selector {
    display: flex;
    justify-content: center;
    height: 48px;
    margin-top: 4px;
    &-item {
        position: relative;
        height: 100%;
        width: 64px;
        &.active {
            opacity: 0.5;
        }
    }
    &-image {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: block;
        max-width: 100%;
        max-height: 100%;
        margin: auto;
    }
}
</style>