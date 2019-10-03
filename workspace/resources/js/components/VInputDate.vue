<template>
    <label class="p-label">
        <span class="p-title" v-if="$slots.default">
            <slot></slot>
        </span>
        <input type="date" />
    </label>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.p-label {
    display: flex;
    flex-direction: column;
}
.p-title {
    display: inline-flex;
    margin-bottom: 12px;
    font-size: 14px;
    font-weight: bold;
}
</style>