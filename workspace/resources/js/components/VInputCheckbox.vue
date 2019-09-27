<template>
    <div class="p-checkbox-wrapper">
        <input class="p-checkbox" type="checkbox" v-model="check" v-on="listeners" />
        <div class="p-checkbox-background" :class="{active:check}"></div>
    </div>
</template>

<script>
export default {
    props: ["value"],
    computed: {
        check: {
            get() {
                return this.value;
            },
            set(new_value) {
                this.$emit("input", new_value);
            }
        },
        listeners: function() {
            if (this.$listeners.input) {
                delete this.$listeners.input;
            }
            return this.$listeners;
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
    border: solid 2px rgb(0, 0, 0, 0.64);
    box-sizing: border-box;
    pointer-events: none;
    background-repeat: no-repeat;
    background-position: center;
    &.active {
        border: none;
        background-image: url(/img/check.svg);
        background-color: $accent-color;
    }
}
.p-checkbox-wrapper {
    position: relative;
    display: inline-flex;
    width: 44px;
    height: 44px;
    justify-content: center;
    align-items: center;
}
</style>