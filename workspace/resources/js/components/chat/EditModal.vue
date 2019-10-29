<template>
  <div class="p-modal">
    <div class="p-overlay" @click="setActive"></div>
    <ul class="layout-flex --flex-direction-column">
      <li id="1" @click="listener">ルーム編集</li>
      <li id="2" @click="listener">会員追加</li>
      <li id="3" @click="listener">会員編集</li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    close: Event,
    openModal: Event
  },
  methods: {
    setActive: function() {
      this.$emit("close");
    },

    listener: function(e) {
      this.$emit("openModal", e.srcElement.id);
    }
  }
};
</script>
<style lang="scss" scoped>
.p-modal {
  margin: 0 !important;
  position: absolute;
  top: 54px;
  right: 20px;
  z-index: 1;
  .p-overlay {
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: -114px;
    right: -20px;
    opacity: 0;
  }
  ul {
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    padding: 12px 0;
    background-color: $base-color;
    border-radius: 10px;
    border: solid 1px #707070;
  }
  li {
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    color: #707070;
    &:hover {
      background-color: $sub-color;
      cursor: pointer;
    }
  }
}
</style>
