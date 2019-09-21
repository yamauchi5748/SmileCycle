<template>
    <label class="p-label">
        <span class="p-title" v-if="$slots.default">
            <slot></slot>
        </span>
        <input
            v-if="!multiline"
            class="p-input"
            :type="type"
            :placeholder="placeholder"
            v-model="inputElement"
        />
        <textarea
            v-else
            class="p-input-area"
            :type="type"
            :placeholder="placeholder"
            v-model="inputElement"
        ></textarea>
        <template v-if="counter">
            <span class="p-counter">{{counterText}}</span>
        </template>
    </label>
</template>
<script>
export default {
    props: {
        value: {},
        type: { type: String, default: "text" },
        placeholder: { type: String },
        counter: { type: Boolean, default: false },
        max: { type: Number },
        multiline: { type: Boolean, default: false }
    },
    computed: {
        inputElement: {
            get() {
                return this.value;
            },
            set(new_value) {
                this.$emit("input", new_value);
                if (this.max) {
                    this.$emit("input", new_value.slice(0, this.max));
                }
            }
        },
        counterText() {
            let text = this.inputElement.length;
            if (this.max) {
                text += "/" + this.max;
            }
            return text;
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
.p-input {
    display: block;
    width: 100%;
    height: 24px;
    border: none;
    border-bottom: solid $accent-color 2px;
    font-size: 18px;
}
.p-input-area {
    display: block;
    width: 100%;
    height: 150px;
    border: none;
    border-bottom: solid $accent-color 2px;
    font-size: 18px;
    resize: none;
}
.p-counter {
    display: block;
    margin-top: 6px;
    margin-left: auto;
}
</style>