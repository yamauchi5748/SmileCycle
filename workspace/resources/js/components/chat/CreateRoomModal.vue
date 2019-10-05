<template>
  <section class="layout-flex --flex-direction-column --align-items-center p-modal">
    <div
      class="layout-flex --flex-direction-column --justify-content-space-evenly --align-self-center p-modal-content"
    >
      <h2 class="p-modal-title">チャットグループを作成する</h2>
      <div class="layout-flex --flex-direction-column p-group-box">
        <span>グループ名</span>
        <input class="p-name-input" type="text" placeholder="グループ名" />
      </div>
      <div>user-list</div>
      <div class="layout-flex --justify-content-space-evenly p-group-box">
        <router-link class="normal-button p-cancel-btn" :to="'/chat-rooms'">キャンセル</router-link>
        <button class="normal-button">作成</button>
      </div>
      <router-link class="c-esc-button p-esc-btn" :to="'/chat-rooms'" />
    </div>
  </section>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
.p-modal {
  width: 100%;
  height: 100%;
  position: fixed;
  background-color: $base-color;
  z-index: 2;
}

.p-modal-content {
  width: 500px;
  height: 500px;
  position: relative;
}

.p-modal-title {
  font-size: 24px;
  font-weight: 600;
}

.p-group-box {
  width: 100%;
  span {
    font-size: 18px;
    font-weight: bold;
    margin-left: 4px;
    margin-bottom: 8px;
  }
}

.p-name-input {
  height: 51px;
  padding-left: 29px;
  font-size: 18px;
  background-color: $base-color;
  color: #707070;
  border: 1px solid #707070;
  border-radius: 7px;
  box-shadow: 0 7px 17px -12px #202020;
  outline: none;
  &:focus {
    border-color: $accent-color;
    box-shadow: 0 0 4px 4px #43b37e;
  }
}

.p-cancel-btn {
  background-color: darkgray;
}

.p-esc-btn {
  position: absolute;
  top: 20px;
  right: 20px;
}
</style>
