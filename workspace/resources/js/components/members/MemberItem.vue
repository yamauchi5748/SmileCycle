<template>
  <div class="p-member layout-flex">
    <figure class="p-member__profile">
      <img :src="'/members/' + member._id + '/profile-image'" alt />
    </figure>
    <div
      class="p-member__data-box margin-left-normal layout-flex --flex-direction-column --justify-content-space-around"
    >
      <p class="p-member__data-wrapper">
        <span>会員名</span>
        <span class="p-member__data --name">{{member.name}} ({{ member.ruby }})</span>
      </p>
      <p class="p-member__data-wrapper">
        <span>役職名</span>
        <span class="p-member__data --post">{{member.post}}</span>
      </p>
      <p class="p-member__data-wrapper">
        <span>会社名</span>
        <span class="p-member__data --company">会社</span>
      </p>
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
    margin-left: 5px;
    font-size: 20px;
  }
}
</style>