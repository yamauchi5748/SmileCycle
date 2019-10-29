<template>
 <input
    class="search_text"
    type="type"
    name="name"
    placeholder="名前または会社名を検索してください"
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
input[type="text"]:focus {
  border: 1px solid #009688;
  outline: 0;
}
.search_text {
    width: 402px;
    height: 48px;
    text-align: center;
    font-size: 19px;
    border: none;
    box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.24);
}
</style>