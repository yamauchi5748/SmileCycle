<template>
  <section class="layout-flex --flex-direction-column --align-items-center p-modal">
    <div
      class="margin-top-big layout-flex --flex-direction-column --justify-content-space-around --align-self-center p-modal-content"
    >
      <div class="layout-flex --align-items-center p-group-box">
        <h2 class="p-modal-title">会員を編集する</h2>
        <span class="c-esc-button p-esc-btn" @click="setBtnActive"></span>
      </div>
      <div class="layout-flex --flex-direction-column p-group-box">
        <input
          class="margin-bottom-small p-search-box"
          type="text"
          placeholder="会員検索"
          v-model="search_text"
        />
        <edit-member-list
          class="p-list-box"
          v-model="members"
          :search_text="search_text"
          ref="list_box"
        ></edit-member-list>
      </div>
      <div class="layout-flex --justify-content-space-around p-group-box">
        <button class="normal-button p-cancel-btn" :to="'/chat-rooms'" @click="setBtnActive">キャンセル</button>
        <button class="normal-button" @click="edit">保存</button>
      </div>
    </div>
    <v-dialog v-model="dialog_active" v-show="dialog_active">
      <div class="p-dialog-msg-box">
        <span class="p-dialog-msg-title">{{ dialog_msg.title }}</span>
        <p class="p-dialog-msg-body">{{ dialog_msg.body }}</p>
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
      room: this.Room,
      members: {},
      search_text: "",
      dialog_msg: {},
      dialog_active: false
    };
  },

  created: function() {
    for (const index in this.room.members) {
      const member_id = this.room.members[index]._id;
      this.$set(this.members, member_id, true);
    }
  },

  methods: {
    setBtnActive: function() {
      this.$parent.setMemberBtnActive();
    },

    edit: function() {
      let msg = "";
      for (const index in this.room.members) {
        const member = this.room.members[index];
        if (!this.members[member._id]) {
          msg += "・" + member.name + "\n";
        }
      }
      this.dialog_msg.title = "以下の会員を退出させますか？";
      this.dialog_msg.body = msg;
      this.dialog_active = true;
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
  z-index: 1;
}

.p-modal-content {
  width: 700px;
  min-height: 600px;
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

.p-search-box {
  width: 259px;
  height: 41px;
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

.p-list-box {
  height: 259px;
}

.p-dialog-msg-box {
  display: grid;
  grid-template-rows: 40px 1fr;
  justify-content: center;
  font-weight: bold;
  .p-dialog-msg-title {
    font-size: 18px;
  }

  .p-dialog-msg-body {
    white-space: pre-wrap;
  }
}

.p-cancel-btn {
  background-color: darkgray;
}

.p-esc-btn {
  margin: 0 0 0 auto;
}
</style>
