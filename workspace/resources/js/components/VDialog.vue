<template>
  <div class="layout-flex --justify-content-space-around --align-items-center p-dialog-box">
    <div class="p-overlay" @click="cancel"></div>
    <div class="p-dialog">
      <span class="p-dialog-title">確認画面</span>
      <slot></slot>
      <div class="layout-flex --justify-content-space-around p-dialog-btn-box">
        <button class="normal-button p-cancel-btn" @click="cancel">キャンセル</button>
        <button class="normal-button" @click="agree">OK</button>
      </div>
    </div>
  </div>
</template>

<script>
import VScrollbar from "./VScrollbar";
export default {
  components: {
    VScrollbar
  },
  props: {
    value: Boolean,
    active: Event
  },
  methods: {
    close: function() {
      this.$emit("active", false);
    },

    cancel: function() {
      this.$emit("input", false);
      this.close();
    },

    agree: function() {
      this.$emit("input", true);
      this.close();
    }
  }
};
</script>

<style lang="scss" scoped>
@mixin window($width: 100%, $height: 100%) {
  width: $width;
  height: $height;
  z-index: 3;
}

.p-dialog-box {
  @include window();
  position: fixed;
  .p-overlay {
    @include window($height: 850px);
    top: -60px;
    position: fixed;
    background-color: rgba($color: #000000, $alpha: 0.5);
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