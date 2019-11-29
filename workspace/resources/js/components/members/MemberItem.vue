<template>
  <div class="p-member layout-flex">
    <figure class="p-member__profile">
      <img :src="'/members/' + member._id + '/profile-image'" alt />
    </figure>
    <div
      class="p-member__data-box margin-left-normal layout-flex --flex-direction-column --justify-content-space-around"
    >
      <span class="p-member__data --name">{{member.name}} ({{ member.ruby }})</span>
      <span class="p-member__data --post">{{member.post}}</span>
      <span class="p-member__data --company">会社</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    member: Object
  },

  data() {
    return {};
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