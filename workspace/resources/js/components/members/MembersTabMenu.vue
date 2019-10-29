<template>
  <button @click="$emit('input',id ,name)" :class="[active, 'tab']">
    {{ name }}
  </button>
</template>

<script>
export default {
  props: {
    id: Number,
    name: String,
    value: Number
  },
  computed: {
    active() {
      return this.value === this.id ? 'active' : false
    }
  }

}
</script>

<style scoped>
.tab {
  width: 94px;
  height: 36px;
  border-radius: 2px;
  margin-left : 10px ;
  box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.24);
  font-family: Roboto;
  font-size: 14px;
  background: #fff;
  color: #000000;
  border: none;
  line-height: 24px;
}
.tab:hover {
  font-family: Roboto;
  font-size: 14px;
  color: #ffffff;
  background: #009688
}
.active {
  font-family: Roboto;
  font-size: 14px;
  color: #ffffff;
  background:  #009688;
}
</style>