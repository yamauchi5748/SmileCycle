<template>
  <div class="c-scrollbar_hider_wrapper" ref="scrollbar_hider_wrapper">
    <div
      class="c-scrollbar_hider"
      ref="scrollbar_hider"
      @scroll="loadScrollValue($refs.scrollbar_hider.scrollTop)"
    >
      <div class="c-list" ref="list_box">
        <slot></slot>
      </div>
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
  props: {
    scroll: Event,
    resize: Event
  },
  data() {
    return {
      intervalId: undefined,
      is_scroll: false,
      box_height: 0,
      scroll_box_height: 0,
      scrollbar_height: 100,
      scrollbar_value: "translateY(0px)"
    };
  },

  mounted: function() {
    // ウィンドウ幅の変更を検知するイベントを追加
    window.addEventListener("resize", this.handleResize);

    // ポーリングでリストボックスの高さをリサイズイベントで取得
    this.intervalId = setInterval(this.resizeEvent, this.$root.polling_time);
  },

  beforeDestroy: function() {
    // コンポーネント消滅時にイベントを削除
    window.removeEventListener("resize", this.handleResize);

    // ポーリングによるイベントをリセット
    clearInterval(this.intervalId);
  },

  methods: {
    handleResize: function() {
      // ウィンドウ幅が変わったタイミングで発火
      this.loadScrollBarHeight();
    },

    resizeEvent: function() {
      if (!this.$refs.scrollbar_hider_wrapper) return;
      if (!this.$refs.list_box) return;
      this.scroll_box_height = this.$refs.scrollbar_hider_wrapper.clientHeight;
      this.box_height = this.$refs.list_box.clientHeight + 23;
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

      /* スクロールイベントを発行 */
      this.$emit("scroll", percentage * 100);
    },

    scrollBottom: function() {
      this.$refs.scrollbar_hider.scrollTop =
        this.box_height - this.scroll_box_height;
      this.loadScrollValue(this.$refs.scrollbar_hider.scrollTop);
    }
  },

  watch: {
    box_height: function(val, oldVal) {
      /* リサイズイベントを発行 */
      this.$emit("resize", val, oldVal);
      this.loadScrollBarHeight();

      if (oldVal <= 0 || val < oldVal) return;
      this.$refs.scrollbar_hider.scrollTop += val - oldVal;
      this.loadScrollValue(this.$refs.scrollbar_hider.scrollTop);
    },

    scroll_box_height: function(val, oldVal) {
      this.loadScrollBarHeight();
      this.loadScrollValue(this.$refs.scrollbar_hider.scrollTop);
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
  overflow-x: hidden;
  outline: none;
  position: absolute;
  top: 0;
  left: 0;
  right: -50px;
  bottom: 0;
  height: 100%;
  transform: translateZ(0);
  //scroll-behavior: smooth;
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
  z-index: 1;
}

.c-list {
  width: calc(100% - 50px);
}
</style>