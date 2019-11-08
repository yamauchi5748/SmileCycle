<template>
  <section class="layout-flex --flex-direction-column --align-items-center p-modal">
    <div
      class="margin-top-big layout-flex --flex-direction-column --justify-content-space-around --align-self-center p-modal-content"
    >
      <div class="layout-flex --align-items-center p-group-box">
        <h2 class="p-modal-title">会員を追加する</h2>
        <span class="c-esc-button p-esc-btn" @click="setBtnActive"></span>
      </div>
      <div class="layout-flex --flex-direction-column p-group-box">
        <input
          class="margin-bottom-small p-search-box"
          type="text"
          placeholder="会員検索"
          v-model="search_text"
        />
        <add-member-list v-model="members" :search_text="search_text"></add-member-list>
      </div>
      <div class="layout-flex --justify-content-space-around p-group-box">
        <button class="normal-button p-cancel-btn" :to="'/chat-rooms'" @click="setBtnActive">キャンセル</button>
        <button class="normal-button" @click="add">保存</button>
      </div>
    </div>
    <v-dialog v-on:agree="dialogAgree" v-on:cancel="dialogCancel" v-show="dialog_active">
      <div class="p-dialog-msg-box">
        <span class="p-dialog-msg-title">{{ dialog_msg.title }}</span>
        <p class="p-dialog-msg-body">{{ dialog_msg.body }}</p>
      </div>
    </v-dialog>
  </section>
</template>
<script>
import AddMemberList from "./AddMemberList";
import VDialog from "../VDialog";
export default {
  components: {
    AddMemberList,
    VDialog
  },
  props: {
    Room: Object,
    closeModal: Event
  },

  data: function() {
    return {
      room: this.Room,
      add_members: [],
      members: {},
      search_text: "",
      dialog_msg: {},
      dialog_confirm: false,
      dialog_active: false
    };
  },

  created: function() {
    this.$root.member_list.filter(member => {
      for (const index in this.room.members) {
        if (this.room.members[index]._id == member._id) {
          return false;
        }
      }
      this.$set(this.members, member._id, false);
    });
  },

  methods: {
    setBtnActive: function() {
      this.$emit("closeModal");
    },

    setDialogActive: function(is_active) {
      this.dialog_active = is_active;
    },

    dialogAgree: function() {
      console.log("ok");
      this.setDialogActive(false);

      const data = {
        add_members: this.add_members
      };
      this.$root.addChatRoomMember(this.room._id, data).then(res => {
        this.room.members = res.members;
        this.dialog_confirm = false;
        this.add_members = [];
        this.setBtnActive();
      });
    },

    dialogCancel: function() {
      console.log("no");
      this.setDialogActive(false);
    },

    add: function() {
      let msg = "";
      for (const index in this.$root.member_list) {
        const member = this.$root.member_list[index];
        if (this.members[member._id]) {
          msg += "・" + member.name + "\n";
          this.add_members.push(member._id);
        }
      }
      this.dialog_msg.title = "以下の会員をルームに追加します";
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
  overflow: auto;
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

.p-dialog-msg-box {
  padding-right: 10px;
  font-weight: bold;
  overflow-y: auto;
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

@media screen and(max-width: 414px) {
  .p-modal-content {
    width: calc(100% - 20px);
    height: 100%;
    min-height: unset;
    position: relative;
  }

  .p-list {
    height: 255px;
  }

  .p-esc-btn {
    top: -10px;
  }
}
</style>
