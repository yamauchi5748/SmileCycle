<template>
  <div>{{member}}</div>
</template>

<script>
export default {
  data() {
    return {};
  },

  computed: {
      member: function() {
      return this.$root.member_list.filter(member => {
        return member._id === this.$route.params.id;
      })[0];
    }
  },

  methods: {}
};
</script>
<style lang="scss" scoped>
.p-member {
  &__profile img {
    height: 96px;
    border-radius: 50%;
  }

  &__data-box {
  }

  &__data {
    font-size: 20px;
  }
}
</style>