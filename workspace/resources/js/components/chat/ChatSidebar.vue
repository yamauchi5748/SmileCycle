<template>
  <section class="p-sidebar">
    <nav class="layout-flex p-chats-navigation">
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
    <div class="p-search-box-wrapper">
      <input class="p-search-box" type="text" :placeholder="placeholder" v-model="search_text" />
      <figure class="p-search-icon">
        <img src="/img/search-icon.png" alt="検索アイコン" />
      </figure>
    </div>
    <v-scrollbar class="margin-left-smallest" :box-height="box_height">
      <ul class="p-room-list" ref="list_box">
        <li
          class="margin-bottom-normal"
          v-for="(room, index) in room_list"
          :key="index"
          @click="entryRoom(room)"
        >
          <room-item :room="room" />
        </li>
      </ul>
    </v-scrollbar>
    <span class="c-add-button p-add-button" @click="setBtnActive"></span>
    <!-- テスト用ボタン -->
    <span class="c-add-button p-edit-button" @click="setEditBtnActive" v-if="room_id"></span>
    <span class="c-add-button p-edit-member-button" @click="setMemberBtnActive" v-if="room_id"></span>
    <span class="c-add-button p-add-member-button" @click="setMemberAddBtnActive" v-if="room_id"></span>
    <!-- テスト用ボタン ここまで -->
    <create-room-modal class="p-modal-wrapper" :class="{active:btn_active}" />
    <!-- テスト用コンポーネント -->
    <edit-room-modal
      class="p-modal-wrapper"
      :class="{active:edit_btn_active}"
      :Room="room_list.filter(room => { return room._id == room_id})[0]"
      v-if="edit_btn_active"
    />
    <edit-member-modal
      class="p-modal-wrapper"
      :class="{active:member_btn_active}"
      :Room="room_list.filter(room => { return room._id == room_id})[0]"
      v-if="member_btn_active"
    />
    <add-member-modal
      class="p-modal-wrapper"
      :class="{active:member_add_btn_active}"
      :Room="room_list.filter(room => { return room._id == room_id})[0]"
      v-if="member_add_btn_active"
    />
    <!-- テスト用コンポーネント ここまで -->
  </section>
</template>
<script>
import VScrollbar from "../VScrollbar";
import RoomItem from "./RoomItem";
import CreateRoomModal from "./CreateRoomModal";
import EditRoomModal from "./EditRoomModal"; //テスト用
import EditMemberModal from "./EditMemberModal"; //テスト用
import AddMemberModal from "./AddMemberModal"; //テスト用
export default {
  components: {
    VScrollbar,
    RoomItem,
    CreateRoomModal,
    EditRoomModal, //テスト用
    EditMemberModal, //テスト用
    AddMemberModal //テスト用
  },
  data() {
    return {
      intervalId: undefined,
      box_height: 0,
      search_text: "",
      room_type: "",
      placeholder: "",
      btn_active: false,
      edit_btn_active: false, //テスト用
      member_btn_active: false, //テスト用
      member_add_btn_active: false, //テスト用
      room_id: this.$route.params.id //テスト用
    };
  },

  mounted: function() {
    // 初期設定はグループルーム
    this.loadRoomType("group");
    this.$root.loadChatRooms();

    // ポーリングでリストボックスの高さをリサイズイベントで取得
    this.intervalId = setInterval(this.resizeEvent, 500);
  },

  beforeDestroy() {
    // ポーリングによるイベントをリセット
    clearInterval(this.intervalId);
  },

  computed: {
    room_list: function() {
      return this.$root.chat_room_list.filter(room => {
        return (
          room.group_name.indexOf(this.search_text) != -1 &&
          (this.room_type == "group" ? room.is_group : !room.is_group)
        );
      });
    }
  },

  methods: {
    resizeEvent: function() {
      this.box_height = this.$refs.list_box.clientHeight;
    },

    setBtnActive: function() {
      this.btn_active = !this.btn_active;
    },
    // テスト用
    setEditBtnActive: function() {
      this.edit_btn_active = !this.edit_btn_active;
    },
    // テスト用
    setMemberBtnActive: function() {
      this.member_btn_active = !this.member_btn_active;
    },
    // テスト用
    setMemberAddBtnActive: function() {
      this.member_add_btn_active = !this.member_add_btn_active;
    },

    loadRoomType: function(type) {
      console.log(type);
      this.room_type = type;
      if (this.room_type === "group") {
        this.placeholder = "グループ名検索";
      } else {
        this.placeholder = "会員名検索";
      }
    },

    // ルームへ入室
    entryRoom: function(room) {
      this.room_id = room._id;
      console.log(this.room_id);
      // 既読処理
      let unread_contents_id = [];
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

.p-search-box-wrapper {
  margin: 18px 0 18px 5px;
  position: relative;
}

.p-search-box {
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
}

.p-add-button {
  position: absolute;
  bottom: 23px;
  left: 248px;
}

/* テスト用scss */
.p-add-member-button {
  position: absolute;
  background-color: pink;
  bottom: 23px;
  left: 148px;
}
/* テスト用scss */
.p-edit-button {
  position: absolute;
  background-color: brown;
  bottom: 23px;
  left: 78px;
}

/* テスト用scss */
.p-edit-member-button {
  position: absolute;
  background-color: purple;
  bottom: 23px;
  left: 0px;
}

.p-modal-wrapper {
  transform: scale(0);
  transition: 0.5s;
  &.active {
    transform: scale(1);
  }
}
</style>