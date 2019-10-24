<template>
    <label class="p-label">
        <span v-if="$slots.default" class="p-label-text" :class="{focus:is_focus}">
            <slot></slot>
        </span>
        <input
            v-if="!multiline"
            class="p-input"
            :class="{focus:is_focus}"
            :type="type"
            :placeholder="placeholder"
            v-model="inputElement"
            @focus="handleFocus"
            @blur="handleBlur"
        />
        <textarea
            v-else
            class="p-input-area"
            :class="{focus:is_focus}"
            :type="type"
            :placeholder="placeholder"
            v-model="inputElement"
            @focus="handleFocus"
            @blur="handleBlur"
        ></textarea>
        <template v-if="error || counter">
            <span class="p-message">
                {{error}}
                <span class="p-counter">{{counterText}}</span>
            </span>
        </template>
    </label>
</template>
<script>
export default {
    props: {
        value: { type: String },
        error: {},
        type: { type: String, default: "text" },
        placeholder: { type: String },
        counter: { type: Boolean, default: false },
        max: { type: Number },
        multiline: { type: Boolean, default: false }
    },
    data: function() {
        return {
            is_focus: false
        };
    },
    computed: {
        inputElement: {
            get: function() {
                return this.value;
            },
            set: function(new_value) {
                this.$emit("input", new_value);
                if (this.max) {
                    this.$emit("input", new_value.slice(0, this.max));
                }
            }
        },
        counterText: function() {
            if (!this.inputElement) {
                if (this.max) {
                    return 0 + "/" + this.max;
                } else {
                    return;
                }
            }
            let text = this.inputElement.length;
            if (this.max) {
                text += "/" + this.max;
            }
            return text;
        }
    },
    methods: {
        handleFocus: function(event) {
            this.is_focus = true;
        },
        handleBlur: function(event) {
            this.is_focus = false;
        }
    }
};
</script>
<style lang="scss" scoped>
.p-label {
    position: relative;
    display: flex;
    flex-direction: column;
    background-color: #ffffff;
}
.p-label-text {
    position: absolute;
    display: inline-flex;
    top: -6px;
    left: 12px;
    padding: 0 4px;
    background-color: inherit;
    font-size: 12px;
    font-weight: 600;
    color: rgba($color: #000000, $alpha: 0.6);
    user-select: none;
    &.focus {
        color: rgba($color: $accent-color, $alpha: 0.87);
    }
}
%input {
    display: flex;
    width: 100%;
    height: 56px;
    padding: 16px 12px;
    border: none;
    border: solid 1px rgba($color: #000000, $alpha: 0.12);
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    color: rgba($color: #000000, $alpha: 0.87);
    outline: none;
    align-items: center;
    &:hover {
        border: solid 1px rgba($color: #000000, $alpha: 1);
    }
    &.focus {
        border: solid 2px rgba($color: $accent-color, $alpha: 0.87);
    }
}
.p-input {
    @extend %input;
}
.p-input-area {
    @extend %input;
    line-height: 28px;
    min-height: 160px;
    resize: none;
}
.p-message {
    display: flex;
    padding: 6px 12px 0;
    font-size: 14px;
    align-items: flex-end;
    color: #00000099;
}
.p-counter {
    display: block;
    margin-left: auto;
}
</style>