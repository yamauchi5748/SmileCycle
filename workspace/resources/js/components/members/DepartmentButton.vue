<template>
  <span
    class="p-department-button normal-button"
    :class="{active:department.status}"
    @click="onClick"
  >{{ department.name }}笑門会</span>
</template>

<script>
export default {
  props: {
    department: Object,
    change: Event
  },

  data() {
    return {};
  },

  methods: {
    onClick: function() {
      this.$emit("change", this.department.key);
    }
  }
};
</script>
<style lang="scss" scoped>
.p-department-button {
  background-color: #fff;
  color: $black;

  @media screen and(min-width: 769px) {
    &:hover {
      background-color: #009680;
      opacity: 0.65;
    }
  }
}

.active {
  background-color: #009680;
  color: #fff;
}
</style>