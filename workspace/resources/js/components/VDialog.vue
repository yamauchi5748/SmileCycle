<template>
  <div class="layout-flex --justify-content-space-around --align-items-center p-dialog-box">
    <div class="p-overlay" @click="close"></div>
    <div class="p-dialog">
      <span class="p-dialog-title">確認画面</span>
      <slot class="p-slot"></slot>
      <div class="layout-flex --justify-content-space-around p-dialog-btn-box">
        <button class="normal-button p-cancel-btn" @click="close">キャンセル</button>
        <button class="normal-button" @click="close">OK</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: Boolean
  },
  methods: {
    close: function() {
      this.$emit("input", false);
    }
  }
};
</script>

<style lang="scss" scoped>
@mixin window($width: 100%, $height: 100%) {
  width: $width;
  height: $height;
}

.p-dialog-box {
  @include window();
  position: fixed;
  .p-overlay {
    @include window();
    position: fixed;
    background-color: rgba($color: #000000, $alpha: 0.5);
    z-index: 2;
  }

  .p-dialog {
    max-width: 700px;
    max-height: 700px;
    padding: 0 50px;
    display: grid;
    grid-template-rows: 50px 1fr 60px;
    background-color: $base-color;
    border-radius: 20px;
    z-index: 3;
    .p-dialog-title {
      justify-self: center;
      align-self: center;
      font-weight: bold;
      font-size: 21px;
    }
    .p-dialog-btn-box {
        padding-top: 10px;
    }
  }
}

.p-cancel-btn {
  background-color: darkgray;
}
</style>