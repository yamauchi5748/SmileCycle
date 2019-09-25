<template>
    <div class="p-checkbox-wrapper">
        <div class="p-checkbox-background" :class="{active:checked}"></div>
        <input class="p-checkbox" type="checkbox" v-model="checked" />
    </div>
</template>

<script>
export default {
    props: {
        value: Boolean
    },
    computed: {
        checked: {
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
.p-checkbox {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    border-radius: 50%;
    appearance: none;
    outline: none;

    &:hover {
        background-color: $accent-transparent-color;
    }
}
.p-checkbox-background {
    position: relative;
    width: 20px;
    height: 20px;
    border: solid 2px rgba(0, 0, 0, 0.64);
    box-sizing: border-box;
    pointer-events: none;
    border-collapse: collapse;
    z-index: 1;

    background-repeat: no-repeat;
    background-position: center;
    &.active {
        border: none;
        background-image: url(/img/check.svg);
        background-color: $accent-color;
    }
}
.p-checkbox-wrapper {
    display: inline-flex;
    position: relative;
    padding: 12px;
    justify-content: center;
    align-items: center;
}
</style>