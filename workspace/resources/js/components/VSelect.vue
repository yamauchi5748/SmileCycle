<template>
    <label class="p-label">
        <span class="p-label-text" :class="{focus:is_focus}">
            <slot></slot>
        </span>
        <select
            class="p-select"
            :class="{focus:is_focus}"
            ref="select"
            v-model="inputElement"
            @focus="handleFocus"
            @blur="handleBlur"
        >
            <option
                v-for="(company,index) in companies"
                :key="index"
                :value="company._id"
            >{{ company.name }}</option>
        </select>
        <template v-if="error">
            <span class="p-message">{{error}}</span>
        </template>
    </label>
</template>
<script>
export default {
    props: {
        value: { type: String },
        error: {}
    },
    data: function() {
        return {
            is_focus: false,
            companies: []
        };
    },
    created: function() {
        const vm = this;
        this.$root.loadCompanies().then(function() {
            vm.companies = vm.$root.company_list;
        });
    },
    computed: {
        inputElement: {
            get() {
                return this.value;
            },
            set(new_company_id) {
                this.$emit("input", new_company_id);
            }
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
.p-select {
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
.p-message {
    display: flex;
    padding: 6px 12px 0;
    font-size: 14px;
    align-items: flex-end;
    color: #00000099;
}
</style>