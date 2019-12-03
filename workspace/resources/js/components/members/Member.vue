<template>
  <section class="p-member">
    <div class="p-member__info-box layout-flex --justify-content-space-around">
      <div class="p-member__info --left layout-flex --flex-direction-column --align-items-center --justify-content-space-around">
        <span class="p-member__info__data --ruby">{{ member.ruby }}</span>
        <span class="p-member__info__data --name">{{ member.name }}</span>
        <span class="p-member__info__data --tel">{{ member.telephone_number }}</span>
        <span class="p-member__info__data --mail">{{ member.mail }}</span>
      </div>
      <figure class="p-member__info --center">
        <img class="p-member__info__profile" :src="'/members/' + member._id + '/profile-image'" alt />
      </figure>
      <div class="p-member__info --right layout-flex --flex-direction-column --justify-content-space-around">
        <p class="p-member__info__data-wrapper">
          <span>部門名</span>
          <span class="p-member__info__data --department">{{ member.department_name }}</span>
        </p>
        <p class="p-member__info__data-wrapper">
          <span>会社名</span>
          <span class="p-member__info__data --company">{{ member.company_name }}</span>
        </p>
        <p class="p-member__info__data-wrapper">
          <span>役職名</span>
          <span class="p-member__info__data --post">{{ member.post }}</span>
        </p>
      </div>
    </div>
    <div></div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      member: {}
    };
  },

  mounted() {
    this.$root.getMember(this.$route.params.id).then(res => {
      console.log(res);
      this.member = res.data.member;
    });
  },

  methods: {}
};
</script>
<style lang="scss" scoped>
.p-member {
  &__info__profile {
    height: 150px;
    border-radius: 50%;
  }

  &__info__data {
      font-size: 20px;
  }

  .--name {
    font-size: 35px;
  }
}
</style>