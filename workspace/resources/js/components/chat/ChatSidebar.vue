<template>
  <section class="p-sidebar">
    <nav class="layout-flex --justify-content-space-around p-chats-navigation">
      <span
        class="p-chats-nav-container"
        :class="{active:(room_type == 'group')}"
        @click="loadRoomType('group')"
      >グループ</span>
      <span
        class="p-chats-nav-container"
        :class="{active:(room_type == 'member')}"
        @click="loadRoomType('member')"
      >会員</span>
    </nav>
    <input class="p-search-box" type="text" placeholder="グループ名検索" />
    <figure class="p-search-icon">
      <img src="/img/search-icon.png" alt="検索アイコン" />
    </figure>
    <room-list />
    <router-link class="c-add-button p-add-button" :to="{name:'chat-room-create'}" />
  </section>
</template>
<script>
import RoomList from "./RoomList";
export default {
  components: {
    RoomList
  },
  data() {
    return {
      room_type: "group"
    };
  },
  methods: {
    loadRoomType: function(type) {
      this.room_type = type;
    }
  }
};
</script>
<style lang="scss" scoped>
.p-sidebar {
  width: 314px;
  background-color: rgba($sub-color, 0.45);
  display: flex;
  flex-direction: column;
}

.p-chats-navigation {
  border-bottom: solid 0.05px #606060;
  cursor: pointer;

  .p-chats-nav-container {
    padding: 32px 45px 9px;
    font-size: 22px;
    color: #707070;
    &.active {
      color: $accent-color;
    }
  }
}

.p-search-box {
  height: 51px;
  margin: 18px 9px;
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

.p-search-icon {
  position: absolute;
  top: 155px;
  left: 18px;
}

.p-add-button {
  position: absolute;
  bottom: 23px;
  left: 198px;
}
</style>