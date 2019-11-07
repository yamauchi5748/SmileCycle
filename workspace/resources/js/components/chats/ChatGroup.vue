<template>
  <ul>
    <li
      class="room-container"
      v-on:click="getName(room)"
      v-for="(room) in room_list"
      :key="room._id"
    >
      <img class="profile" src="/img/profile_image.jpg" />
      <div class="room-box-wrapper">
        <div class="room-box">
          <span class="room-name">{{ room.name }}</span>
          <span class="room-count">({{ room.members.length }})</span>
        </div>
        <p class="room-first-content" v-if="room.contents.length > 0">{{ room.contents[0].content }}</p>
      </div>
      <div class="unread-box" v-show="unread(room) > 0">
        <span class="unread-text">{{ unread(room) }}</span>
      </div>
    </li>
  </ul>
</template>
<script>
export default {
  props: ["roomName", "showDetails"],
  data: function() {
    return {
      room_list: [
        {
          _id: 1,
          name: "test1",
          members: [{ _id: "1", name: "you1" }, { _id: "0", name: "me" }],
          contents: []
        },
        {
          _id: 2,
          name: "test2",
          members: [{ _id: "0", name: "me" }, { _id: "2", name: "you2" }],
          contents: [
            {
              content: "画像を送信しました",
              unread: true
            }
          ]
        },
        {
          _id: 3,
          name: "test3",
          members: [{ _id: "3", name: "you3" }, { _id: "0", name: "me" }],
          contents: [
            {
              content: "text",
              unread: false
            }
          ]
        },
        {
          _id: 4,
          name: "test4",
          members: [{ _id: "0", name: "me" }, { _id: "4", name: "you4" }],
          contents: [
            {
              content:
                "texttexttexttexttexttexttexttexttexttexttexttexttexttexttexttext",
              unread: true
            },
            {
              content:
                "texttexttexttexttexttexttexttexttexttexttexttexttexttexttexttext",
              unread: true
            }
          ]
        }
      ]
    };
  },
  methods: {
    getName(room) {
      this.$emit("setName", room.name);
    },
    unread: function(room) {
      const unread_contents = room.contents.filter(content => {
        return content.unread;
      });
      return unread_contents.length;
    }
  }
};
</script>

<style lang="scss" scoped>
.room-container {
  display: flex;
  margin-bottom: 6%;
  cursor: pointer;
}

.profile {
  max-width: 20%;
  border-radius: 50%;
}

.room-box-wrapper {
  max-width: 50%;
  margin: 0 0 0 5%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.room-box {
  margin: 0 0 5%;
  .room-name {
    font-size: 21px;
    font-weight: 500;
    color: #222222;
  }
  .room-count {
    font-size: 21px;
    font-weight: 500;
    color: #222222;
  }
}

.room-first-content {
  font-size: 16px;
  font-weight: 500;
  opacity: 0.5;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.unread-box {
  width: 30px;
  height: 30px;
  background-color: $accent-color;
  color: white;
  border-radius: 50%;
  .unread-text {
    position: relative;
    top: 24%;
    left: 34%;
  }
}
</style>
