<template>
 <input
    class="search_text"
    type="type"
    name="name"
    placeholder="検索する"
    @input="updateValue"
  />
</template>

<script>
export default {
  name: "MyInput",
  props: {
    name: { type: String, require: true },
    placeholder: { type: String, require: false }
  },
  methods: {
    updateValue: function(e) {
      this.$emit("input", e.target.value);
    }
  }
};
</script>
<style lang="scss">
.search_text {
    width: 402px;
    height: 48px;
    text-align: center;
    font-size: 22px;
    box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.24);
}
</style>