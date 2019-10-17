<template>
  <div class="details" v-if="room">
    <div class="name">
      <span>{{ room.group_name }}</span>
      <button
        v-if="!room.is_department && room.admin_member_id == $root.author._id"
        @click="setMenuActive"
      >
        <img src="/img/settings-icon.png" alt />
      </button>
    </div>
    <div class="contents">
      <v-scrollbar class="margin-left-smallest" :box-height="box_height">
        <ol class="history" ref="list_box">
          <li v-for="(content, index) in contents" :key="index">
            <div class="content" v-if="!content.is_none">
              <div class="profile">
                <img :src="'/members/' + content.sender_id + '/profile-image'" alt="profile" />
              </div>
              <div class="signature">
                <span>{{ content.sender_name }}</span>
                <span>{{ content.created_at }}</span>
              </div>
              <div class="message">
                <span v-if="content.content_type == '1'">{{ content.message }}</span>
                <img
                  class="p-content-image"
                  :src="'/stamp-images/' + content.stamp_id"
                  alt="スタンプ"
                  v-if="content.content_type == '2'"
                />
                <img
                  class="p-content-image"
                  :src="'/chat-rooms/' + room._id + '/images/' + content.content_id"
                  alt="画像"
                  v-if="content.content_type == '3'"
                />
              </div>
            </div>
          </li>
        </ol>
      </v-scrollbar>
      <div class="send-content">
        <div class="input-box">
          <button>
            <img class="upload-image" src alt />
          </button>
          <p class="upload-message" contenteditable="true"></p>
          <button>
            <img src="/img/stamp-icon.png" alt="stamp" class="stamp" />
          </button>
        </div>
        <button class="normal-button">send</button>
      </div>
    </div>
    <edit-modal
      class="p-animation"
      :class="{active:edit_active}"
      v-on:close="setMenuActive"
      v-on:openModal="openModal"
    />
    <edit-room-modal :Room="room" v-on:closeModal="closeModal" v-if="edit_room_active" />
    <add-member-modal :Room="room" v-on:closeModal="closeModal" v-if="add_member_active" />
    <edit-member-modal :Room="room" v-on:closeModal="closeModal" v-if="edit_member_active" />
  </div>
</template>
<script>
import VScrollbar from "../VScrollbar";
import EditModal from "./EditModal";
import EditRoomModal from "./EditRoomModal";
import EditMemberModal from "./EditMemberModal";
import AddMemberModal from "./AddMemberModal";
export default {
  components: {
    VScrollbar,
    EditModal,
    EditRoomModal,
    EditMemberModal,
    AddMemberModal
  },
  data() {
    return {
      intervalId: undefined,
      box_height: 0,
      edit_active: false,
      edit_room_active: false,
      add_member_active: false,
      edit_member_active: false
    };
  },

  created: function() {
    // ポーリングでリストボックスの高さをリサイズイベントで取得
    this.intervalId = setInterval(this.resizeEvent, 500);
  },

  beforeDestroy() {
    // ポーリングによるイベントをリセット
    clearInterval(this.intervalId);
  },

  computed: {
    room: function() {
      return this.$root.chat_room_list.filter(room => {
        return room._id === this.$route.params.id;
      })[0];
    },

    contents: function() {
      return this.room.contents.reverse();
    }
  },

  methods: {
    resizeEvent: function() {
      if (!this.$refs.list_box) return;
      this.box_height = this.$refs.list_box.clientHeight + 23;
    },

    setMenuActive: function() {
      this.edit_active = !this.edit_active;
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
  }
};
</script>
<style lang="scss" scoped>
.details {
  background-color: $base-color;
  height: 100%;
  display: grid;
  grid-template-rows: 63px 1fr;
  div {
    margin: 0px;
    margin-top: 20px;
  }

  .name {
    display: flex;
    justify-content: space-between;
    border-bottom: 0.1px solid #707070;
    height: 43px;
    padding: 0 16px;
    align-items: center;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    color: $black;
  }

  .contents {
    margin: 0 0 0 16px;
    height: 100%;
    display: grid;
    grid-template-rows: 1fr;
    flex-direction: column;
    position: relative;
    overflow-y: hidden;
    overflow-x: hidden;
    .contents-inner {
      height: 100%;
      .history {
        width: calc(100% + 17px);
        height: 0;
        overflow-y: scroll;
        li {
          width: 100%;
        }
      }
    }
  }
}
.content {
  display: grid;
  grid-template-columns: 1fr 9fr;
  grid-template-rows: auto auto;
  width: 100%;
  background-color: #f2f2f2;
  position: relative;
  .profile {
    grid-column: 1/1;
    grid-row: 1/1;
    margin: 0px;
    padding: 0px;

    img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
    }
  }
  .signature {
    padding: 0px;
    margin: 0px;
    grid-column: 2/2;
    grid-row: 1/1;
    font-size: 16px;
    font-weight: bold;
    align-self: center;
    margin: 0px 20px;

    span {
      margin: 0px 10px;
    }
  }
  .message {
    padding: 0px;
    margin: 0px;
    grid-column: 2/2;
    grid-row: 2/2;
    font-size: 16px;
    margin: 0px 20px;
    .p-content-image {
      width: 140px;
      height: 140px;
    }
  }
}
.send-content {
  padding: 23px 0;
  width: 100%;
  display: flex;
  background-color: $base-color;
  max-height: 500px;
  .input-box {
    display: flex;
    position: relative;
    flex-grow: 1;
    margin: 0 6px 0 0;
    border: 1px solid #707070;
    border-radius: 4px;
    outline: none;
    overflow-y: scroll;
    .upload-message {
      box-sizing: border-box;
      width: 400px;
      flex-grow: 1;
      font-size: 30px;
      outline: none;
      padding: 10px 40px 10px 10px;
      line-height: 1;
    }
    button {
      position: absolute;
      bottom: 0;
      right: 0;
      .stamp {
        height: 100%;
      }
    }
  }
  .normal-button {
    align-self: flex-end;
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
</style>










