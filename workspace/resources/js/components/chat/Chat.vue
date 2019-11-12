<template>
  <div class="p-chats">
    <chat-sidebar :class="{close:is_close}"></chat-sidebar>
    <router-view></router-view>
  </div>
</template>
<script>
import ChatSidebar from "./ChatSidebar";
export default {
  components: {
    ChatSidebar
  },
  computed: {
    is_close: function() {
      return this.$route.params.id;
    }
  }
};
</script>
<style lang="scss" scoped>
.p-chats {
  height: 100%;
  min-height: 534px;
  display: grid;
  grid-template-columns: 324px 1fr;
  line-height: 1.4rem;
  position: relative;
}

@media screen and(max-width: 414px) {
  .p-chats {
    display: block;
    min-height: unset;
  }

  .close {
    display: none;
  }
}
</style>
