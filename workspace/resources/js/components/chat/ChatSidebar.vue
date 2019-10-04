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
    <div class="layout-flex --align-items-center p-search-box">
      <figure class="margin-left-small">
        <img src="/img/search-icon.png" alt="検索アイコン" />
      </figure>
      <input type="text" placeholder="グループ名検索" />
    </div>
    <room-list />
    <button class="c-add-button p-add-button"></button>
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
  margin: 18px 9px;
  height: 51px;
  background-color: $base-color;
  border: 1px solid #707070;
  border-radius: 7px;
  box-shadow: 0 7px 17px -12px #202020;

  input {
    width: 90%;
    font-size: 18px;
    color: #707070;
    border: none;
    border-radius: inherit;
    outline: none;
  }
}

.p-add-button {
  bottom: 23px;
  left: 198px;
}

.c-add-button {
  width: 52px;
  height: 52px;
  background-color: $accent-color;
  color: white;
  border-radius: 50%;
  position: absolute;
  box-shadow: 0 12px 23px -9px $black;
  &:before {
    content: "";
    width: 14px;
    border-bottom: solid;
    color: $base-color;
    position: absolute;
    top: 24px;
    left: 19px;
  }
  &:after {
    content: "";
    height: 14px;
    border-left: solid;
    color: $base-color;
    position: absolute;
    top: 18px;
    left: 25px;
  }
  &:hover {
    cursor: pointer;
  }
}
</style>