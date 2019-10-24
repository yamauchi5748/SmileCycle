<template>
    <label class="p-label">
        <span class="p-title" v-if="$slots.default">
            <slot></slot>
        </span>
        <input type="date" v-model="date" />
    </label>
</template>

<script>
export default {
    props: ["value"],
    computed: {
        date: {
            get() {
                return this.value;
            },
            set(new_value) {
                this.$emit("input", new_value);
            }
        }
    }
};
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