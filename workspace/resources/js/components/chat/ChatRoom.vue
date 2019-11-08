<template>
  <section class="p-room" v-if="room">
    <div class="p-room-header layout-flex --justify-content-space-between">
      <router-link
        class="p-room-header__back-icon layout-flex --align-items-center --justify-content-center"
        :to="{name:'chat-rooms'}"
      ></router-link>
      <h1 class="p-room-header__title-text --align-self-center">{{ room.group_name }}</h1>
      <div class="p-room-header__menu layout-flex --align-items-center">
        <button
          class="p-room-header__menu-item margin-right-small"
          v-if="room.is_group && !room.is_department && room.admin_member_id == $root.author._id"
          @click="setMenuActive"
        >
          <img src="/img/settings-icon.png" alt />
        </button>
        <button
          class="p-room-header__menu-item"
          v-if="room.is_group && !room.is_department"
          @click="del"
        >
          <img src="/img/exit.svg" alt />
        </button>
      </div>
    </div>
    <div class="p-room-contents">
      <v-scrollbar v-on:scroll="scroll" v-on:resize="scrollResize" ref="scroll">
        <chat-room-content-list
          :contents="contents"
          :room_id="room._id"
          :is_group="room.is_group ? true : false"
        />
      </v-scrollbar>
    </div>
    <div class="p-room-send layout-flex --align-items-flex-end">
      <div class="p-room-send__input-message-box">
        <p
          class="p-room-send__input-message"
          :class="{opacity: is_none_text}"
          contenteditable="true"
          ref="message"
          @focus="inputFocus"
          @blur="outputFocus"
          @input="change"
          @drop.native.stop
        >{{ placeholder }}</p>
      </div>
      <div class="p-room-send__wrapper layout-flex">
        <label
          class="p-room-send__img-btn layout-flex --align-items-center"
          for="p-room-send__img-input"
        >
          <img class="p-room-send__img-icon" src="/img/image-icon.svg" alt="image" />
          <input
            id="p-room-send__img-input"
            class="p-room-send__img-input"
            type="file"
            multiple
            @change="sendImage"
          />
        </label>
        <button
          class="p-room-send__stamp-btn layout-flex --align-items-center"
          @click="setStampActive"
        >
          <img class="p-room-send__stamp-icon" src="/img/stamp-icon.png" alt="stamp" />
        </button>
        <button
          class="p-room-send__hurry-btn normal-button --align-self-flex-end margin-left-small"
          :class="{active: is_hurry}"
          @click="changeHurry"
        >急ぎ</button>
        <button
          class="p-room-send__submit-btn normal-button --align-self-flex-end margin-left-small"
          :class="{active: !is_none_text}"
          @click="sendText"
        >送信</button>
      </div>
      <stamp-list-modal v-on:close="setStampActive" v-on:send="sendStamp" v-show="stamp_active" />
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
import ChatRoomContentList from "./ChatRoomContentList";
import EditModal from "./EditModal";
import StampListModal from "./StampListModal";
import EditRoomModal from "./EditRoomModal";
import EditMemberModal from "./EditMemberModal";
import AddMemberModal from "./AddMemberModal";
export default {
  components: {
    VScrollbar,
    VDialog,
    ChatRoomContentList,
    EditModal,
    StampListModal,
    EditRoomModal,
    EditMemberModal,
    AddMemberModal
  },
  data() {
    return {
      placeholder: "チャット",
      is_none_text: true,
      dialog_msg: {},
      async_flg: true,
      edit_active: false,
      stamp_active: false,
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

    setStampActive: function() {
      this.stamp_active = !this.stamp_active;
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

    changeHurry: function() {
      this.is_hurry = !this.is_hurry;
    },

    sendText: function() {
      /* テキストが空なら抜ける */
      if (this.is_none_text) return;
      console.log(this.$refs.message.innerText);
      const data = {
        is_hurry: this.is_hurry,
        content_type: 1,
        message: this.$refs.message.innerText
      };
      /* 初期化 */
      this.$refs.message.innerText = this.placeholder;
      this.is_none_text = true;
      this.is_hurry = false;
      this.submit(data);
    },

    sendStamp: function(stamp_id) {
      const data = {
        is_hurry: this.is_hurry,
        content_type: 2,
        stamp_id: stamp_id
      };
      this.submit(data);
    },

    sendImage: function(event) {
      const files = event.target.files;
      for (const index in files) {
        if (!files[index].type || !files[index].type.match("image")) continue;
        const data = new FormData();
        data.append("is_hurry", this.is_hurry ? 1 : 0);
        data.append("content_type", 3);
        data.append("image", files[index]);

        this.submit(data);
      }
    },

    submit: function(data) {
      this.$root.postContents(this.room._id, data).then(res => {
        /* ルームのコンテンツが空の場合 */
        if (this.room.contents[0].is_none) this.room.contents.splice(0);
        this.room.contents.push(res.content);

        //ポーリングによる実行タイミングの整合性を保つ
        window.setTimeout(
          this.$refs.scroll.scrollBottom,
          this.$root.polling_time + 1
        );
      });
    },

    inputFocus: function() {
      if (!this.is_none_text) return;
      this.$refs.message.innerText = "";
    },

    outputFocus: function() {
      if (!this.is_none_text) return;
      this.$refs.message.innerText = this.placeholder;
    },

    change: function() {
      this.is_none_text = this.$refs.message.innerText === "";
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

  @media screen and(max-width: 414px) {
    & {
      width: 100vw;
      min-width: 0;
    }
  }

  .p-room-header {
    height: 62px;
    padding: 0 20px;
    box-shadow: 0px -18px 50px black;
    line-height: 1.7rem;

    &__back-icon {
      display: none;
      width: 20px;

      &::before {
        content: "";
        left: 0;
        width: 12px;
        height: 12px;
        border-bottom: 2px solid #707070;
        border-left: 2px solid #707070;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
      }
    }

    &__title-text {
      text-decoration: none;
      font-weight: bold;
      color: #707070;
    }

    &__menu-item {
      width: 36px;
      height: 36px;
    }

    @media screen and(max-width: 414px) {
      &__back-icon {
        display: inherit;
      }
    }
  }

  .p-room-contents {
    height: 100%;
    width: 100%;
    background-color: #f2f2f2;
  }

  .p-room-send {
    $height: 36px;
    $width: 36px;

    max-height: 500px;
    padding: 0 20px 20px 20px;
    position: relative;
    background-color: #f2f2f2;

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
      padding: 10px 95px 10px 20px;
      font-size: 16px;
      font-weight: bold;
      outline: none;
      word-break: break-all;
      overflow: hidden;
    }

    &__wrapper {
      position: relative;
    }

    &__img-btn {
      height: $height;
      position: absolute;
      bottom: 5px;
      right: 230px;
    }

    &__img-icon {
      width: $width;
      height: $height;
      &:hover {
        cursor: pointer;
        opacity: 0.7;
      }
    }

    &__img-input {
      display: none;
    }

    &__stamp-btn {
      height: $height;
      position: absolute;
      bottom: 5px;
      right: 190px;
    }

    &__stamp-icon {
      width: $width;
      height: $height;
      border-radius: 50%;
      &:hover {
        cursor: pointer;
        opacity: 0.7;
      }
    }

    &__hurry-btn {
      height: $height + 10.3;
      background-color: gray;
      color: #dddddd;

      &.active {
        background-color: #0096e3;
        color: $base-color;
      }
    }

    &__submit-btn {
      height: $height + 10.3;
      background-color: gray;
      color: #dddddd;

      &.active {
        background-color: #009680;
        color: $base-color;
      }
    }

    @media screen and(max-width: 768px) {
      $height: 30px;
      $width: 30px;

      & {
        position: relative;
        flex-direction: column;
        padding: 0;
      }

      &__input-message-box {
        max-height: 191px;
        overflow: scroll;
        border: none;
        border-radius: unset;
        border-top: 1px solid #707070;
      }

      &__input-message {
        max-height: unset;
        padding: 10px;
      }

      &__wrapper {
        position: static;
      }

      &__img-btn {
        left: 10px;
      }

      &__img-icon {
        width: $width;
        height: $height;
      }

      &__stamp-btn {
        left: 50px;
      }

      &__stamp-icon {
        width: $width;
        height: $height;
      }

      &__hurry-btn {
        height: 36px;
        min-width: unset;
        margin: 0 10px 5px 0;
      }

      &__submit-btn {
        height: 36px;
        min-width: unset;
        margin: 0 10px 5px 0;
      }
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

.opacity {
  color: rgb(194, 194, 194);
}
</style>