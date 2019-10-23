<template>
  <div class="p-chats">
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
  display: grid;
  grid-template-columns: 324px 1fr;
  line-height: 1.4rem;
  position: relative;
  overflow: hidden;
}
</style>
