<template>
    <div class="p-controls">
        <controls-sidebar class="p-siebar"></controls-sidebar>
        <router-view class="p-content"></router-view>
    </div>
</template>
<script>
import ControlsSidebar from "./ControlsSidebar";
export default {
    components: {
        ControlsSidebar
    }
};
</script>
<style lang="scss" scoped>
.p-controls {
    height: 100%;
    display: grid;
    grid-template-columns: 180px 1fr;
    grid-template-rows: 1fr;
}

.p-content {
    overflow-y: scroll;
    border-left: solid 1px rgba(0, 0, 0, 0.2);
    border-right: solid 1px rgba(0, 0, 0, 0.2);
}
</style>