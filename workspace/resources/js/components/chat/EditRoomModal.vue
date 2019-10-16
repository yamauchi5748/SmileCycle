<template>
  <section class="layout-flex --flex-direction-column --align-items-center p-modal">
    <div
      class="margin-top-big layout-flex --flex-direction-column --justify-content-space-around --align-self-center p-modal-content"
    >
      <div class="layout-flex --align-items-center p-group-box">
        <h2 class="p-modal-title">チャットグループを編集する</h2>
        <span class="c-esc-button p-esc-btn" @click="setBtnActive"></span>
      </div>
      <figure class="layout-flex --justify-content-center p-room-icon-box-wrapper">
        <label class="p-room-icon-box" for="file-input">
          <img
            class="p-room-icon"
            :src="'/chat-rooms/' + room._id + '/profile-image'"
            ref="img_preview"
          />
          <img class="p-camera-icon" src="/img/camera.png" />
          <input id="file-input" type="file" ref="img_input" @change="preview" />
        </label>
      </figure>
      <div class="layout-flex --flex-direction-column --justify-content-center p-group-box">
        <span>グループ名</span>
        <span class="alert" v-show="name_alert">ルーム名が入力されていません</span>
        <input class="p-name-input" type="text" placeholder="グループ名" v-model="new_group_name" />
      </div>
      <div class="layout-flex --justify-content-space-around p-group-box">
        <button class="normal-button p-delete-btn" :to="'/chat-rooms'" @click="del">削除</button>
        <button class="normal-button" @click="edit">保存</button>
      </div>
    </div>
    <v-dialog v-on:agree="dialogAgree" v-on:cancel="dialogCancel" v-show="dialog_active">
      <div class="p-dialog-msg-box">
        <span class="p-dialog-msg-title">{{ dialog_msg.title }}</span>
      </div>
    </v-dialog>
  </section>
</template>
<script>
import EditMemberList from "./EditMemberList";
import VDialog from "../VDialog";
export default {
  components: {
    EditMemberList,
    VDialog
  },
  props: {
    Room: Object
  },

  data: function() {
    return {
      name_alert: false,
      room: this.Room,
      new_group_name: this.Room.group_name,
      dialog_msg: {},
      dialog_active: false
    };
  },

  methods: {
    setBtnActive: function() {
      this.$parent.setEditBtnActive();
    },

    setDialogActive: function(is_active) {
      this.dialog_active = is_active;
    },

    dialogAgree: function() {
      this.setDialogActive(false);

      this.$root.deleteChatRoom(this.room._id).then(res => {
        this.setBtnActive();
        this.$router.push({ path: "/chat-rooms" });
      });
    },

    dialogCancel: function() {
      this.setDialogActive(false);
    },

    preview: function() {
      let img_preview_el = this.$refs.img_preview;
      const file = this.$refs.img_input.files[0];
      const reader = new FileReader();

      // 画像ファイル以外の場合は何もしない
      if (file.type.indexOf("image") < 0) {
        return false;
      }

      // ファイル読み込みが完了した際のイベント登録
      reader.onload = function(e) {
        // .prevewの領域の中にロードした画像を表示するimageタグを追加
        img_preview_el.src = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    edit: function() {
      this.name_alert = this.new_group_name.length < 1; // グループ名が入力されていなければアラート
      if (this.name_alert) return;

      const file = this.$refs.img_input.files[0];
      const data = new FormData();
      data.append("new_group_name", this.new_group_name);

      if (file && file.type.match("image")) {
        data.append("new_icon", file);
      }
      this.$root.editChatRoom(this.room._id, data).then(res => {
        this.room.group_name = ""; // RoomItemのwatchで検知するため
        this.room.group_name = res.group_name;
        this.setBtnActive();
      });
    },

    del: function() {
      this.dialog_msg.title = "ルームを削除してもよろしいですか？";
      this.setDialogActive(true);
    }
  }
};
</script>
<style lang="scss" scoped>
.p-modal {
  width: 100%;
  height: 100%;
  position: absolute;
  background-color: $base-color;
  z-index: 2;
}

.p-modal-content {
  width: 700px;
  min-height: 400px;
  position: relative;
}

.p-modal-title {
  font-size: 24px;
  font-weight: 600;
}

.p-group-box {
  width: 100%;
  .alert {
    color: #ac1f1f;
    font-size: 14px;
  }
  span {
    margin-bottom: 4px;
    font-size: 18px;
    font-weight: bold;
  }
}

.p-room-icon-box-wrapper {
  .p-room-icon-box {
    position: relative;
    .p-camera-icon {
      position: absolute;
      width: 28px;
      height: 28px;
      bottom: 1px;
      right: 1px;
      border-radius: 50%;
      border: solid 1px darkcyan;
    }
    .p-room-icon {
      width: 98px;
      height: 98px;
      border-radius: 50%;
    }
  }
  #file-input {
    display: none;
  }
  &:hover {
    cursor: pointer;
  }
}

.p-name-input {
  height: 51px;
  padding-left: 29px;
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
}

.p-edit-member-button {
  width: 150px;
}

.p-delete-btn {
  background-color: brown;
}

.p-esc-btn {
  margin: 0 0 0 auto;
}
</style>
