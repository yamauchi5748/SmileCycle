<template>
  <label class="p-label">
    <span class="p-title">
      <slot></slot>
    </span>
    <select class="p-select" ref="select" v-model="inputElement">
      <option
        v-for="(company,index) in companies"
        :key="index"
        :value="company._id"
      >{{ company.name }}</option>
    </select>
  </label>
</template>
<script>
export default {
  props: {
    value: { type: String }
  },
  created: function() {
    const vm = this;
    this.$root.loadCompanies().then(function() {
      vm.companies = vm.$root.company_list;
    });
  },
  data: function() {
    return { companies: [] };
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
.p-select {
  display: block;
  width: 100%;
  height: 32px;
  border: none;
  border-bottom: solid $accent-color 2px;
  box-sizing: border-box;
  font-size: 18px;
  line-height: 1.8rem;
}
</style>