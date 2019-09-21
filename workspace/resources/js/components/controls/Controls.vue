<template>
    <div class="p-controls">
        <sidebar class="p-siebar"></sidebar>
        <div class="p-primary-view">
            <router-view class="p-content"></router-view>
        </div>
    </div>
</template>
<script>
import Sidebar from "./ControlsSidebar";
export default {
    components: {
        Sidebar
    }
};
</script>
<style lang="scss" scoped>
.p-controls {
    display: grid;
    grid-template-columns: 180px 1fr;
}
/*
@media screen and (max-width: $inner-width) {
    .p-controls {
        grid-template-columns: unset;
    }
    .p-sidebar{
        order: 1;
    }
    .p-primary-view{
        order: 2;
    }
}
*/
.p-primary-view {
    display: flex;
    justify-content: center;
    border-left: solid 1px rgba(0, 0, 0, 0.2);
    border-right: solid 1px rgba(0, 0, 0, 0.2);
}
.p-content {
    width: 100%;
    max-width: 650px;
    min-width: 320px;
}
</style>