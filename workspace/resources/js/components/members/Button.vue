<template>
  <button type="button" class="myButton"　onclick="onclick" @click="onClick" :disabled="ripple">
    <transition name="ripple" @enter="rippleEnter" @after-enter="afterRippleEnter">
      <span v-if="ripple" ref="ripple" class="ripple"/>
    </transition>
    <span class="label">
      <slot>{{name}}</slot>
    </span>
  </button>
</template>

<script>
export default {
  data() {
    return {
      ripple: false,
      x: 0,
      y: 0
    };
  },
  props: {
    name: { type: String, require: true },
    onclick: {type: String, require: true},
  },
  methods: {
    onClick(e) {
      this.x = e.layerX;
      this.y = e.layerY;
      this.ripple = !this.ripple;
      this.$emit("click");
    },
    rippleEnter() {
      this.$refs.ripple.style.top = `${this.y}px`;
      this.$refs.ripple.style.left = `${this.x}px`;
    },
    afterRippleEnter() {
      this.ripple = false;
    }
  }
};
</script>

<style lang="scss" scoped>
$button-color: #ffffff;

.myButton {
  border: none;
  position: relative;
  font-size: 14px;
　text-align: center;
　line-height: 50px;
  width: 94px;
  height: 36px;
  border-radius: 4px;
  overflow: hidden;
  background-color: $button-color;
  cursor: pointer;
  color: #000000;
  transition: background-color 0.2s;
  border: solid 1px #95989a;
  &:hover {
    background-color: #009688;
    .label {
        color: #ffffff;
        transform: translateY(1px);
    }
  }
  &:focus {
    background-color: #009688;
    outline: none;
  }
  &:disabled {
    background-color: #009688;
    .label {
      opacity: 0.5;
      transform: translateY(1px);
    }
  }
}
.label {
  display: block;
  pointer-events: none;
  color: #000000;
  transform: translateY(0);
  transition: transform 0.2s;
}
.ripple {
  display: block;
  width: 20px;
  height: 20px;
  border-radius: 10px;
  position: absolute;
  top: 0;
  left: 0;
  pointer-events: none;
  background-color: rgba(lighten($button-color, 20%), 0.8);
  opacity: 0;
  transform: translate(-50%, -50%) scale(10);
  transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
  &-enter {
    opacity: 1;
    transform: translate(-50%, -50%) scale(0);
  }
}
</style>
