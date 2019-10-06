<template>
  <div class="tabs">
    <label class="tab_item" >愛媛笑門会</label>
    <label class="tab_item" >東京笑門会</label>
    <label class="tab_item" >大阪笑門会</label>
      </div>
</template>

<script>
export default {
  data() {
    return {
     deploy_name: [
        { id: 1, name: '愛媛笑門会'},
        { id: 2, name: '大阪笑門会'},
        { id: 3, name: '鎌倉笑門会'}
      ]
    }
  }
}
</script>

<style lang="scss">
.tab_item {
  width: 94px;
  height: 36px;
  border-radius: 2px;
  box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.24);
  background-color: #ffffff;
  margin: 0 auto;
}
.tab_item:hover {
  opacity: 0.75;
}
</style>