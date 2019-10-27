<template>
  <section class="p-room" v-if="room">
    <div class="p-room-header layout-flex --justify-content-space-between">
      <h1 class="p-room-header__title-text --align-self-center">{{ room.group_name }}</h1>
      <div class="p-room-header__menu layout-flex --align-items-center">
        <button
          class="p-room-header__menu-item margin-right-small"
          v-if="!room.is_department && room.admin_member_id == $root.author._id"
          @click="setMenuActive"
        >
          <img src="/img/settings-icon.png" alt />
        </button>
        <button
          class="p-room-header__menu-item"
          v-if="room.is_group && !room.is_department"
          @click="del"
        >退出ボタン</button>
      </div>
    </div>
    <div class="p-room-contents">
      <v-scrollbar v-on:scroll="scroll" v-on:resize="scrollResize" ref="scroll">
        <ol class="p-room-contents__list" v-if="!contents[0].is_none">
          <li
            class="p-room-contents__list-item layout-flex"
            v-for="(content, index) in contents"
            :key="index"
          >
            <figure class="p-flex--left">
              <img
                class="p-room-contents__profile"
                :src="'/members/' + content.sender_id + '/profile-image'"
                alt="profile"
              />
            </figure>
            <div class="p-flex--right">
              <div class="p-room-contents__signature layout-flex margin-bottom-small">
                <span class="p-room-contents__signature-name">{{ content.sender_name }}</span>
                <time
                  class="p-room-contents__signature-date margin-left-small"
                  :datetime="content.created_at"
                >{{ content.created_at }}</time>
              </div>
              <p
                class="p-room-contents__text"
                v-if="content.content_type == '1'"
              >{{ content.message }}</p>
              <img
                class="p-room-contents__image"
                :src="'/stamp-images/' + content.stamp_id"
                alt="スタンプ"
                v-if="content.content_type == '2'"
              />
              <img
                class="p-room-contents__image"
                :src="'/chat-rooms/' + room._id + '/images/' + content.content_id"
                alt="画像"
                v-if="content.content_type == '3'"
              />
            </div>
          </li>
        </ol>
      </v-scrollbar>
    </div>
    <div class="p-room-send layout-flex --align-items-center">
      <div class="p-room-send__input-message-box">
        <p class="p-room-send__input-message" contenteditable="true" ref="message"></p>
      </div>
      <button class="p-room-send__stamp-btn layout-flex">
        <img src="/img/stamp-icon.png" alt="stamp" />
      </button>
      <button
        class="p-room-send__submit-btn normal-button --align-self-flex-end margin-left-small"
        @click="submit"
      >送信</button>
    </div>
    <v-dialog v-on:agree="dialogAgree" v-on:cancel="dialogCancel" v-show="dialog_active">
      <div class="p-dialog-msg-box">
        <h2 class="p-dialog-msg-title">{{ dialog_msg.title }}</h2>
        <p class="p-dialog-msg-body">{{ dialog_msg.body }}</p>
      </div>
    </v-dialog>
    <edit-modal
      class="p-animation"
      :class="{active:edit_active}"
      v-on:close="setMenuActive"
      v-on:openModal="openModal"
    />
    <edit-room-modal :Room="room" v-on:closeModal="closeModal" v-if="edit_room_active" />
    <add-member-modal :Room="room" v-on:closeModal="closeModal" v-if="add_member_active" />
    <edit-member-modal :Room="room" v-on:closeModal="closeModal" v-if="edit_member_active" />
  </section>
</template>
<script>
import VScrollbar from "../VScrollbar";
import VDialog from "../VDialog";
import EditModal from "./EditModal";
import EditRoomModal from "./EditRoomModal";
import EditMemberModal from "./EditMemberModal";
import AddMemberModal from "./AddMemberModal";
export default {
  components: {
    VScrollbar,
    VDialog,
    EditModal,
    EditRoomModal,
    EditMemberModal,
    AddMemberModal
  },
  data() {
    return {
      dialog_msg: {},
      async_flg: true,
      edit_active: false,
      dialog_active: false,
      edit_room_active: false,
      add_member_active: false,
      edit_member_active: false,
      is_hurry: false
    };
  },

  computed: {
    room: function() {
      return this.$root.chat_room_list.filter(room => {
        return room._id === this.$route.params.id;
      })[0];
    },

    contents: function() {
      return this.room.contents;
    }
  },

  methods: {
    scroll: function(scroll_percentage) {
      if (scroll_percentage < 10 && this.async_flg && this.room) {
        this.async_flg = !this.async_flg;
        this.$root
          .loadChatRoomContents(this.room._id, this.room.contents.length)
          .then(() => {
            this.async_flg = !this.async_flg;
          });
      }
    },

    scrollResize: function(val, oldVal) {
      /* 現在のスクロール画面を保持する */
      if (oldVal > 0 && val > oldVal) {
        this.$refs.scroll.scrollKeep("bottom", val - oldVal);
      }
    },

    setMenuActive: function() {
      this.edit_active = !this.edit_active;
    },

    setDialogActive: function(is_active) {
      this.dialog_active = is_active;
    },

    dialogAgree: function() {
      this.setDialogActive(false);
      this.$root.exitChatRoom(this.room._id);
      this.$router.push({ path: "/chat-rooms" });
    },

    dialogCancel: function() {
      this.setDialogActive(false);
    },

    del: function() {
      this.dialog_msg.title = "ルームを退出しますか？";
      this.dialog_msg.body = "ルーム管理者が退出するとルーム自体削除されます";
      this.setDialogActive(true);
    },

    submit: function() {
      console.log(this.$refs.message.innerText);
      const data = {
        is_hurry: this.is_hurry,
        content_type: 1,
        message: this.$refs.message.innerText
      };
      this.$refs.message.innerText = "";

      this.$root.chatSubmit(this.room._id, data).then(res => {
        if (this.room.contents[0].is_none) this.room.contents.splice(0);
        this.room.contents.push(res.content);

        /* ルームをソート */
        let last_departnebt_index = 0;
        for (const index in this.$root.chat_room_list) {
          const room = this.$root.chat_room_list[index];
          if (room.is_department) last_departnebt_index++;
          if (room._id == this.room._id) {
            this.$root.chat_room_list.splice(index, 1);
            this.$root.chat_room_list.splice(last_departnebt_index, 0, room);
          }
        }

        //ポーリングによる実行タイミングの整合性を保つ
        window.setTimeout(
          this.$refs.scroll.scrollBottom,
          this.$root.polling_time + 1
        );
      });
    },

    openModal: function(target_id) {
      this.setMenuActive();
      switch (target_id) {
        case "1":
          this.edit_room_active = true;
          break;

        case "2":
          this.add_member_active = true;
          break;

        case "3":
          this.edit_member_active = true;
          break;
      }
    },

    closeModal: function() {
      this.edit_room_active = false;
      this.add_member_active = false;
      this.edit_member_active = false;
    }
  },

  watch: {
    room: function(val, oldVal) {
      // ビュー全体がレンダリングされた後にのみ実行されるコード
      this.$nextTick(function() {
        // ポーリングによる実行タイミングの整合性を保つ
        window.setTimeout(
          this.$refs.scroll.scrollBottom,
          this.$root.polling_time + 1
        );
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.p-room {
  min-width: 444px;
  height: 100%;
  display: grid;
  grid-template-rows: 63px 1fr;
  background-color: $base-color;
  overflow-y: hidden;
  line-height: normal;

  .p-room-header {
    height: 62px;
    padding: 0 20px;
    box-shadow: 0px -18px 50px black;
    line-height: 1.7rem;

    &__title-text {
      text-decoration: none;
      font-weight: bold;
      color: #707070;
    }
  }

  .p-room-contents {
    height: 100%;
    width: 100%;
    background-color: #f2f2f2;

    &__list {
      height: 100%;
      padding: 20px;
    }

    &__list-item {
      width: 100%;
      margin-bottom: 20px;
    }

    &__profile {
      width: 57px;
      height: 57px;
      border-radius: 50%;
    }

    &__signature-name {
      font-size: 18px;
      font-weight: bold;
    }

    &__signature-date {
      font-size: 13px;
    }

    &__text {
      font-size: 16px;
      font-weight: bold;
      color: #444444;
      white-space: pre-wrap;
      word-break: break-all;
    }

    &__image {
      width: 140px;
      height: 140px;
    }
  }

  .p-room-send {
    $height: 46px;

    max-height: 500px;
    padding: 20px;
    position: relative;
    background-color: $base-color;

    &__input-message-box {
      width: 100%;
      height: 100%;
      border: 1px solid #707070;
      border-radius: 4px;
      box-sizing: border-box;
      outline: none;
    }

    &__input-message {
      max-height: 350px;
      padding: 10px 70px 10px 20px;
      font-size: 16px;
      font-weight: bold;
      outline: none;
      word-break: break-all;
      overflow: hidden;
    }

    &__stamp-btn {
      height: $height;
      position: absolute;
      bottom: 20px;
      right: 123px;
    }

    &__submit-btn {
      height: $height;
    }
  }
}

.p-dialog-msg-box {
  padding-right: 10px;
  display: grid;
  grid-template-rows: 40px 1fr;
  justify-content: center;
  font-weight: bold;
  overflow-y: auto;
  .p-dialog-msg-title {
    font-size: 18px;
  }

  .p-dialog-msg-body {
    font-size: 15px;
    white-space: pre-wrap;
  }
}

.p-animation {
  visibility: hidden;
  opacity: 0;
  transition: 0.1s;
  &.active {
    visibility: unset;
    opacity: 1;
  }
}

.p-flex {
  &--right {
    width: 100%;
    max-width: 736px;
    padding: 8px 0 0 12px;
  }
}
</style>










