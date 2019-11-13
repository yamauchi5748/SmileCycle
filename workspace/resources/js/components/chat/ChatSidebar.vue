<template>
  <section class="p-sidebar">
    <nav class="layout-flex p-chats-navigation">
      <div class="p-chats-navigation__container-wrapper">
        <span
          class="p-chats-navigation__container"
          :class="{active:(room_type == 'group')}"
          @click="loadRoomType('group')"
        >グループ</span>
        <div class="p-chats-navigation__unread-box--group c-unread-box" v-if="group_unread > 0">
          <span :class="{'c-more-tag--sidebar':group_unread_more_active}">{{ group_unread }}</span>
        </div>
      </div>
      <div class="p-chats-navigation__container-wrapper">
        <span
          class="p-chats-navigation__container"
          :class="{active:(room_type == 'member')}"
          @click="loadRoomType('member')"
        >会員</span>
        <div class="p-chats-navigation__unread-box--member c-unread-box" v-if="member_unread > 0">
          <span :class="{'c-more-tag--sidebar':member_unread_more_active}">{{ member_unread }}</span>
        </div>
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
          class="p-room-list__item margin-bottom-smaller"
          :class="{active:isActive(room._id)}"
          v-for="(room, index) in room_list"
          :key="index"
          @click="entryRoom(room)"
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
      return this.$root.chat_room_list
        .filter(room => {
          return (
            room.group_name.indexOf(this.search_text) != -1 &&
            (this.room_type == "group" ? room.is_group : !room.is_group)
          );
        })
        .slice()
        .sort(function(comparison_target, comparison_source) {
          /* 部門グループは上位に表示 */
          if (
            comparison_target.is_department &&
            !comparison_source.is_department
          ) {
            return -1;
          } else if (
            !comparison_target.is_department &&
            comparison_source.is_department
          ) {
            return 1;
          } else {
            /* コンテンツがなければ */
            if (
              !comparison_target.contents[0].created_at &&
              comparison_source.contents[0].created_at
            ) {
              /* 最新コンテンツとルーム作成日時の比較 */
              return comparison_target.created_at >
                comparison_source.contents[
                  comparison_source.contents.length - 1
                ].created_at
                ? -1
                : 1;
            } else if (
              comparison_target.contents[0].created_at &&
              !comparison_source.contents[0].created_at
            ) {
              /* 最新コンテンツとルーム作成日時の比較 */
              return comparison_target.contents[
                comparison_target.contents.length - 1
              ].created_at > comparison_source.created_at
                ? -1
                : 1;
            } else if (
              !comparison_target.contents[0].created_at &&
              !comparison_source.contents[0].created_at
            ) {
              /* ルーム作成日時の比較 */
              return comparison_target.contents[
                comparison_target.contents.length - 1
              ].created_at > comparison_source.created_at
                ? -1
                : 1;
            } else {
              /* 最新投稿日時の降順 */
              return comparison_target.contents[
                comparison_target.contents.length - 1
              ].created_at >
                comparison_source.contents[
                  comparison_source.contents.length - 1
                ].created_at
                ? -1
                : 1;
            }
          }
        });
    },

    group_unread: function() {
      let unread_count = 0;
      this.$root.chat_room_list.filter(room => {
        if (room.is_group) {
          unread_count += room.unread
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
          unread_count += room.unread;
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

    isActive: function(room_id) {
      return room_id === this.$route.params.id;
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
    entryRoom: function(room) {
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
  height: 100%;
  position: relative;
  background-color: rgba(255, 209, 140);
  display: flex;
  flex-direction: column;
}

@media screen and(max-width: 414px) {
  .p-sidebar {
    width: 100%;
    position: static;
  }
}

.p-chats-navigation {
  cursor: pointer;

  &__container-wrapper {
    width: 100%;
    position: relative;
    padding-top: 32px;
  }

  &__container {
    width: 100%;
    display: inline-block;
    text-align: center;
    font-size: 22px;
    color: #707070;
    border-bottom: solid 0.05px #606060;
    padding-bottom: 9px;
    &.active {
      color: $accent-color;
    }
  }

  @mixin p-unread-box($width: 0, $height: 0, $top: 0, $right: 0) {
    position: absolute;
    top: $top;
    right: $right;
    width: $width;
    height: $height;
    line-height: $height + 2px;
  }

  &__unread-box {
    &--group {
      @include p-unread-box($width: 25px, $height: 25px, $top: 10px, $right: 0);
    }
    &--member {
      @include p-unread-box(
        $width: 25px,
        $height: 25px,
        $top: 10px,
        $right: 25px
      );
    }
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
  width: 100%;
  padding-bottom: 58px;

  /* モバイル端末 */
  @media screen and (max-width: 768px), (width: 1024px) {
    & {
      width: calc(100% - 15px);
    }
  }

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
  right: 21px;
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