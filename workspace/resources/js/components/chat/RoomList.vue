<template>
  <v-scrollbar :box-height="box_height">
    <ul class="p-room-list" ref="list_box">
      <li class="margin-bottom-normal" v-for="(room, index) in room_list" :key="index">
        <router-link class="layout-flex" :to="{name:'chat-room',params:{id: room._id}}">
          <figure class="p-room-profile-box">
            <img class="p-room-profile" :src="'/chat-rooms/' + room._id + '/profile-image'" />
          </figure>
          <div
            class="layout-flex --flex-direction-column --justify-content-center p-room-primary-box-wrapper"
          >
            <div class="p-room-primary-box">
              <span>{{ room.group_name }}</span>
              <span>({{ room.members.length }})</span>
            </div>
            <p class="p-room-first-content" v-if="room.contents.length > 0">
              <span v-if="room.contents[0].content_type == '1'">{{ room.contents[0].message }}</span>
              <span v-if="room.contents[0].content_type == '2'">スタンプを送信しました</span>
              <span v-if="room.contents[0].content_type == '3'">画像を送信しました</span>
            </p>
          </div>
          <div class="--align-self-center p-unread-box" v-show="unreadCount(room)">
            <span>{{ unread_count }}</span>
          </div>
        </router-link>
      </li>
    </ul>
  </v-scrollbar>
</template>
<script>
import VScrollbar from "../VScrollbar";
export default {
  components: {
    VScrollbar
  },
  props: ["roomList"],
  data() {
    return {
      intervalId: undefined,
      room_list: this.roomList,
      box_height: 0,
      unread_count: 0
    };
  },

  mounted: function() {
    // ポーリングでリストボックスの高さをリサイズイベントで取得
    this.intervalId = setInterval(this.resizeEvent, 10);
  },

  beforeDestroy() {
    // ポーリングによるイベントをリセット
    clearInterval(this.intervalId);
  },

  methods: {
    resizeEvent: function() {
      this.box_height = this.$refs.list_box.clientHeight;
    },

    unreadCount: function(room) {
      const unread_contents = room.contents.filter(content => {
        return content.unread;
      });
      this.unread_count = unread_contents.length;
      return this.unread_count;
    }
  },

  watch: {
    roomList: function(val, oldVal) {
      this.room_list = val;
    }
  }
};
</script>
<style lang="scss" scoped>
// リセット
a:-webkit-any-link {
  color: #606060;
  text-decoration: none;
}

.p-room-list {
  width: 304px;
  padding-bottom: 58px;
}

.p-room-profile-box {
  flex-grow: 1;
}

.p-room-profile {
  max-width: 47px;
  border-radius: 50%;
}

.p-room-primary-box-wrapper {
  width: 154px;
  flex-grow: 5;
}

.p-room-primary-box {
  font-size: 16px;
  font-weight: 500;
  color: #707070;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  span {
    font-weight: bold;
  }
}

.p-room-first-content {
  font-size: 14px;
  font-weight: 370;
  opacity: 0.5;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  text-decoration: none;
}

.p-unread-box {
  width: 30px;
  height: 30px;
  text-align: center;
  line-height: 31px;
  background-color: $accent-color;
  color: white;
  border-radius: 50%;
}
</style>
