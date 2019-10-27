<template>
  <section class="layout-flex --flex-direction-column --align-items-center p-modal">
    <div
      class="margin-top-big layout-flex --flex-direction-column --justify-content-space-around --align-self-center p-modal-content"
    >
      <h2 class="p-modal-title">チャットグループを作成する</h2>
      <div class="layout-flex --flex-direction-column p-group-box">
        <span>グループ名</span>
        <span class="alert" v-show="name_alert">ルーム名が入力されていません</span>
        <input class="p-name-input" type="text" placeholder="グループ名" v-model="group_name" />
      </div>
      <div class="layout-flex --flex-direction-column p-group-box">
        <span>参加する会員</span>
        <span class="alert" v-show="members_alert">参加する会員が選択されていません</span>
        <v-select-members class="p-list-box" v-model="members" ref="list_box"></v-select-members>
      </div>
      <div class="layout-flex --justify-content-space-around p-group-box">
        <button class="normal-button p-cancel-btn" :to="'/chat-rooms'" @click="setBtnActive">キャンセル</button>
        <button class="normal-button" @click="roomCreate">作成</button>
      </div>
      <span class="c-esc-button p-esc-btn" @click="setBtnActive"></span>
    </div>
  </section>
</template>
<script>
import VSelectMembers from "../VSelectMembers";
export default {
  components: {
    VSelectMembers
  },

  props: {
    create: Event
  },

  data: function() {
    return {
      group_name: "",
      members: [],
      name_alert: false,
      members_alert: false
    };
  },

  methods: {
    setBtnActive: function() {
      this.$parent.setBtnActive();
    },

    roomCreate: function() {
      this.name_alert = this.group_name.length < 1; // グループ名が入力されていなければアラート
      this.members_alert = this.members.length < 1; // 参加する会員が選択されていなければアラート
      if (this.name_alert || this.members_alert) return;

      const data = {
        is_group: true,
        group_name: this.group_name,
        members: this.members
      };

      // チャットルーム作成
      this.$root.createChatRoom(data).then(room_list => {
        this.setBtnActive();

        /* ルーム作成イベントを発行 */
        this.$emit("create");
      });
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
  overflow: auto;
}

.p-modal-content {
  width: 700px;
  min-height: 700px;
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

.p-list-box {
  height: 389px;
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

.p-cancel-btn {
  background-color: darkgray;
}

.p-esc-btn {
  position: absolute;
  top: 20px;
  right: 20px;
}
</style>
