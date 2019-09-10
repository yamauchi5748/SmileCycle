<template>
  <div class="controls">
    <div class="controls-header">
      <h1 class="controls-title">管理</h1>
      <p>管理者用のページです。</p>
    </div>
    <div class="controls-body">
      <div class="controls-tab">
        <router-link :to="{name:'controls-invitation'}" class="tab-link"  exact-active-class="active">会のご案内</router-link>
        <router-link :to="{name:'controls-member'}" class="tab-link"  exact-active-class="active">会員</router-link>
        <router-link :to="{name:'controls-company'}" class="tab-link"  exact-active-class="active">会社</router-link>
        <router-link :to="{name:'controls-stamp'}" class="tab-link"  exact-active-class="active">スタンプ</router-link>
      </div>
      <div class="controls-pane">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted: function() {
  },
};
</script>
<style lang="scss">
.controls {
  margin: 0 60px;
  .controls-header {
    .controls-title {
      margin-top: 20px;
      font-size: 24px;
    }
    p {
      margin: 18px 0 18px;
    }
  }
}

.controls-tab {
  display: flex;
  .tab-link {
    display: flex;
    height: 48px;
    padding: 0 16px;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    color: $accent-color;

    &.active {
      box-shadow: 1px 0 0 rgba(0, 0, 0, 0.2);
      color: $black;
      background-color: $base-color;
    }
  }
}
.controls-pane {
  margin-bottom: 48px;
  padding: 28px 56px;
  box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  background-color: $base-color;
  .pane-header {
    display: flex;
    align-items: center;
  }
  .pane-body {
  }
  .item-count {
    margin-right: auto;
    font-size: 1.25rem;
    font-weight: 900;
  }
}
</style>