<template>
  <router-link class="layout-flex" :to="{name:'chat-room',params:{id: room._id}}">
    <figure class="p-room-profile-box">
      <img class="p-room-profile" :src="img_url" />
    </figure>
    <div
      class="layout-flex --flex-direction-column --justify-content-center p-room-primary-box-wrapper"
    >
      <div class="p-room-primary-box">
        <span>{{ room.group_name }}</span>
        <span v-show="room.is_group">({{ room.members.length }})</span>
      </div>
      <p class="p-room-first-content" v-if="room.contents.length > 0">
        <span
          v-if="room.contents[room.contents.length - 1].content_type == '1'"
        >{{ room.contents[room.contents.length - 1].message }}</span>
        <span v-if="room.contents[room.contents.length - 1].content_type == '2'">スタンプを送信しました</span>
        <span v-if="room.contents[room.contents.length - 1].content_type == '3'">画像を送信しました</span>
      </p>
    </div>
    <div class="--align-self-center p-unread-box" v-show="unreadCount">
      <span>{{ unreadCount }}</span>
    </div>
  </router-link>
</template>
<script>
export default {
  props: {
    room: Object
  },
  data: function() {
    return {
      img_url: ""
    };
  },

  mounted: function() {
    this.img_url = "/chat-rooms/" + this.room._id + "/profile-image";
  },

  computed: {
    unreadCount: function() {
      return this.room.unread;
    }
  },

  watch: {
    room: {
      handler: function(val, oldVal) {
        this.img_url = "/chat-rooms/" + this.room._id + "/profile-image";
        if (val._id === oldVal._id) {
          this.img_url =
            "/chat-rooms/" + this.room._id + "/profile-image?" + Math.random();
        }
      },
      deep: true
    }
  }
};
</script>
<style lang="scss" scoped>
// リセット
a {
  color: #606060;
  text-decoration: none;
}

.p-room-profile-box {
  flex-grow: 1;
}

.p-room-profile {
  height: 47px;
  width: 47px;
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
