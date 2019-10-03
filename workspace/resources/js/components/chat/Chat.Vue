<template>
  <div class="layout-flex p-chats">
    <chat-sidebar></chat-sidebar>
    <router-view></router-view>
  </div>
</template>
<script>
import ChatSidebar from "./ChatSidebar";
export default {
  components: {
    ChatSidebar
  }
};
</script>
<style lang="scss" scoped>
.p-chats {
    height: 100%;
}
</style>
