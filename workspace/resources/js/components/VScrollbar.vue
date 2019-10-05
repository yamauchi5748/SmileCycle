<template>
  <div class="c-scrollbar_hider_wrapper" ref="scrollbar_hider_wrapper">
    <div
      class="c-scrollbar_hider"
      ref="scrollbar_hider"
      @scroll="loadScrollValue($refs.scrollbar_hider.scrollTop)"
    >
      <slot></slot>
    </div>
    <div class="c-scrollbar_track" v-show="is_scroll">
      <div
        class="c-scrollbar_bar"
        ref="scrollbar_bar"
        :style="{
            height:scrollbar_height + 'px', 
            transform:scrollbar_value
          }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "VScrollbar",
  props: ["boxHeight"],
  data() {
    return {
      is_scroll: false,
      box_height: this.boxHeight,
      scroll_box_height: 0,
      scrollbar_height: 100,
      scrollbar_value: "translateY(0px)",
      drag_screen: 0
    };
  },

  mounted: function() {
    // ウィンドウ幅の変更を検知するイベントを追加
    window.addEventListener("resize", this.handleResize);
    this.loadScrollBarHeight();
  },

  beforeDestroy: function() {
    // コンポーネント消滅時にイベントを削除
    window.removeEventListener("resize", this.handleResize);
  },

  methods: {
    handleResize: function() {
      // ウィンドウ幅が変わったタイミングで発火
      this.loadScrollBarHeight();
    },

    loadScrollBarHeight: function() {
      this.scroll_box_height = this.$refs.scrollbar_hider_wrapper.clientHeight;
      this.is_scroll = this.box_height - this.scroll_box_height > 0;

      // スクロールバーの大きさ
      const percentage = this.scroll_box_height / this.box_height;
      this.scrollbar_height =
        this.scroll_box_height * percentage > 56
          ? this.scroll_box_height * percentage
          : 56;
    },

    loadScrollValue: function(scroll_value) {
      // スクロールする割合
      const percentage =
        scroll_value / (this.box_height - this.scroll_box_height);

      const top_height =
        (this.scroll_box_height - this.scrollbar_height - 20) * percentage;

      this.scrollbar_value = "translateY(" + top_height + "px)";
    }
  },

  watch: {
    boxHeight: function(val, oldVal) {
      this.box_height = val;
      this.loadScrollBarHeight();
    }
  }
};
</script>

<style lang="scss" scoped>
.c-scrollbar_hider_wrapper {
  height: 100%;
  position: relative;
  overflow: hidden;
}

.c-scrollbar_hider {
  overflow-y: scroll;
  outline: none;
  position: absolute;
  top: 0;
  left: 0;
  right: -50px;
  bottom: 0;
  height: 100%;
  transform: translateZ(0);
  scroll-behavior: smooth;
}

.c-sidebar {
  overflow-y: scroll;
  overflow-x: hidden;
  outline: none;
  position: absolute;
  top: 0;
  left: 0;
  right: -50px;
  bottom: 0;
  height: 100%;
  transform: translateZ(0);
}

.c-scrollbar_track {
  width: 8px;
  position: absolute;
  right: 4px;
  top: 4px;
  bottom: 4px;
  &:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: -4px;
    background: none;
  }
}

.c-scrollbar_bar {
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  border-radius: 4px;
  background: $accent-color;
  opacity: 0.5;
  cursor: default;
  outline: none;
  will-change: transform;
  height: 100px;
  transform: translateY(10px);
}
</style>