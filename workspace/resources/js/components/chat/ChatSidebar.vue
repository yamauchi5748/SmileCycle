<template>
  <section class="p-sidebar">
    <nav class="layout-flex p-chats-navigation">
      <span
        class="p-chats-nav-container"
        :class="{active:(room_type == 'group')}"
        @click="loadRoomType('group')"
      >グループ</span>
      <div class="c-unread-box p-unread-box__group" v-if="group_unread > 0">
        <span :class="{'c-more-tag--sidebar':group_unread_more_active}">{{ group_unread }}</span>
      </div>
      <span
        class="p-chats-nav-container"
        :class="{active:(room_type == 'member')}"
        @click="loadRoomType('member')"
      >会員</span>
      <div class="c-unread-box p-unread-box__member" v-if="member_unread > 0">
        <span :class="{'c-more-tag--sidebar':member_unread_more_active}">{{ member_unread }}</span>
      </div>
    </nav>
    <div class="p-search-box-wrapper">
      <input class="p-search-box" type="text" :placeholder="placeholder" v-model="search_text" />
      <figure class="p-search-icon">
        <img src="/img/search-icon.png" alt="検索アイコン" />
      </figure>
    </div>
    <v-scrollbar class="margin-left-smallest" ref="scroll">
      <ul class="p-room-list">
        <li
          class="p-room-list__item margin-bottom-normal"
          :class="{active:isActive(index)}"
          v-for="(room, index) in room_list"
          :key="index"
          @click="entryRoom(room, index)"
        >
          <room-item :room="room" />
        </li>
      </ul>
    </v-scrollbar>
    <span class="c-add-button p-add-button" @click="setBtnActive"></span>
    <create-room-modal
      class="p-modal-wrapper"
      :class="{active:btn_active}"
      v-on:create="createRoom"
    />
  </section>
</template>
<script>
import VScrollbar from "../VScrollbar";
import RoomItem from "./RoomItem";
import CreateRoomModal from "./CreateRoomModal";
export default {
  components: {
    VScrollbar,
    RoomItem,
    CreateRoomModal
  },
  data() {
    return {
      active_index: -1,
      box_height: 0,
      search_text: "",
      room_type: "",
      placeholder: "",
      btn_active: false,
      group_unread_active: false,
      member_unread_active: false,
      group_unread_more_active: false,
      member_unread_more_active: false
    };
  },

  mounted: function() {
    // 初期設定はグループルーム
    this.loadRoomType("group");
  },

  computed: {
    room_list: function() {
      return this.$root.chat_room_list.filter(room => {
        return (
          room.group_name.indexOf(this.search_text) != -1 &&
          (this.room_type == "group" ? room.is_group : !room.is_group)
        );
      });
    },

    group_unread: function() {
      let unread_count = 0;
      this.$root.chat_room_list.filter(room => {
        if (room.is_group) {
          unread_count += room.contents.filter(content => {
            return content.unread;
          }).length;
        }
      });

      if (unread_count > 99) {
        this.group_unread_more_active = true;
        unread_count = 99;
      }
      return unread_count;
    },

    member_unread: function() {
      let unread_count = 0;
      this.$root.chat_room_list.filter(room => {
        if (!room.is_group) {
          unread_count += room.contents.filter(content => {
            return content.unread;
          }).length;
        }
      });

      if (unread_count > 99) {
        this.member_unread_more_active = true;
        unread_count = 99;
      }
      return unread_count;
    }
  },

  methods: {
    setBtnActive: function() {
      this.btn_active = !this.btn_active;
    },

    isActive: function(index) {
      return index === this.active_index;
    },

    loadRoomType: function(type) {
      this.$refs.scroll.scrollTop();
      this.room_type = type;
      if (this.room_type === "group") {
        this.placeholder = "グループ名検索";
      } else {
        this.placeholder = "会員名検索";
      }
    },

    // ルーム作成イベント
    createRoom: function() {
      this.loadRoomType("group");
    },

    // ルームへ入室
    entryRoom: function(room, index) {
      this.active_index = index;
      // 既読処理
      let unread_contents_id = [];
      room.unread = 0;
      for (const index in room.contents) {
        if (room.contents[index].unread) {
          room.contents[index].unread = false;
          unread_contents_id.push(room.contents[index]._id);
        }
      }
      if (unread_contents_id.length < 1) return;
      this.$root.alreadyRead(room._id, unread_contents_id);
    }
  }
};
</script>
<style lang="scss" scoped>
.p-sidebar {
  background-color: rgba($sub-color, 0.45);
  display: flex;
  flex-direction: column;
}

.p-chats-navigation {
  border-bottom: solid 0.05px #606060;
  cursor: pointer;

  .p-chats-nav-container {
    width: 50%;
    text-align: center;
    padding: 32px 0 9px;
    font-size: 22px;
    color: #707070;
    &.active {
      color: $accent-color;
    }
  }
}

@mixin p-unread-box($width: 0, $height: 0, $top: 0, $left: 0) {
  position: absolute;
  top: $top;
  left: $left;
  width: $width;
  height: $height;
  line-height: $height + 2px;
}

.p-unread-box {
  &__group {
    @include p-unread-box(
      $width: 25px,
      $height: 25px,
      $top: 10px,
      $left: 125px
    );
  }
  &__member {
    @include p-unread-box(
      $width: 25px,
      $height: 25px,
      $top: 10px,
      $left: 262px
    );
  }
}

.p-search-box-wrapper {
  margin: 18px 5px;
  position: relative;
}

.p-search-box {
  width: calc(100% - 10px - 2px - 48px); // 100% - margin - border - padding;
  height: 51px;
  padding: 0 29px;
  font-size: 18px;
  background-color: $base-color;
  color: $black;
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
  top: 18px;
  left: 8px;
}

.p-room-list {
  width: 304px;
  padding-bottom: 58px;

  &__item {
    padding: 4px;

    &:hover {
      background-color: rgba(#ff9900, 0.2);
      border-radius: 10px;
    }
  }

  .active {
    background: aliceblue;
    border-radius: 10px;
  }
}

.p-add-button {
  position: absolute;
  bottom: 23px;
  left: 248px;
}

.p-modal-wrapper {
  visibility: hidden;
  opacity: 0;
  transition: 0.1s;
  &.active {
    visibility: unset;
    opacity: 1;
  }
}
</style>