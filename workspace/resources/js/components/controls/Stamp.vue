<template>
    <section class="view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">12種</h2>
            <router-link class="normal-button margin-left-auto" :to="{name:'controls-stamp-create'}">スタンプを登録する</router-link>
        </div>
        <ul
            class="debug p-layout-stamp-tab-list layout-grid --justify-content-space-between margin-top-big"
        >
            <li v-for="n in 10" :key="n">
                <router-link :to="'test'" append>
                    <img class="debug" height="120" width="120" />
                </router-link>
            </li>
        </ul>
    </section>
</template>
<script>
export default {
    data() {
        return {
            isDialogOpen: false,
            title: "",
            text: "",
            files: []
        };
    },
    methods: {
        handleDragOver(event) {
            event.stopPropagation();
            event.preventDefault();
            event.dataTransfer.dropEffect = "copy";
        },
        handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();
            for (let file of event.dataTransfer.files) {
                this.files.push(file);
            }
        }
    }
};
</script>
<style lang="scss" scoped>
.p-layout-stamp-tab-list {
    grid-template-columns: repeat(3, 120px);
    grid-row-gap: 16px;
}
</style>
