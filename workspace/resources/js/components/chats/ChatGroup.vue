<template>
  <div>
    <ol>
      <li
        class="p-room-container"
        v-on:click="getName(room)"
        v-for="(room) in room_list"
        :key="room._id"
      >
        <img class="p-profile" src="/img/profile_image.jpg" />
        <div class="p-room-box-wrapper">
          <div class="p-room-box">
            <span class="p-room-name">{{ room.name }}</span>
            <span class="p-room-count">({{ room.members.length }})</span>
          </div>
          <p class="p-room-first-content">{{ room.contents[0].content }}</p>
        </div>
        <div class="p-unread-box" v-show="room.unread > 0">
          <span class="p-unread-text">{{ room.unread }}</span>
        </div>
      </li>
    </ol>
  </div>
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
          members: ["", ""],
          contents: [
            {
              content:
                "texttexttexttexttexttexttexttexttexttexttexttexttexttexttexttext"
            }
          ],
          unread: 0
        },
        {
          _id: 2,
          name: "test2",
          members: ["", ""],
          contents: [
            {
              content: "画像を送信しました"
            }
          ],
          unread: 2
        },
        {
          _id: 3,
          name: "test3",
          members: ["", ""],
          contents: [
            {
              content: "text"
            }
          ],
          unread: 3
        },
        {
          _id: 4,
          name: "test4",
          members: ["", ""],
          contents: [
            {
              content: "text"
            }
          ],
          unread: 4
        }
      ]
    };
  },
  methods: {
    getName(room) {
      this.$emit("setName", room.name);
    }
  }
};
</script>

<style lang="scss" scoped>
.p-profile {
  max-width: 20%;
  border-radius: 50%;
}

.p-room-box-wrapper {
  max-width: 50%;
  margin: 0 0 0 5%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.p-room-box {
  margin: 0 0 5%;
}

.p-room-name {
  font-size: 21px;
  font-weight: 500;
  color: #222222;
}

.p-room-count {
  font-size: 21px;
  font-weight: 500;
  color: #222222;
}

.p-room-first-content {
  font-size: 16px;
  font-weight: 500;
  opacity: 0.5;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.p-unread-box {
  width: 30px;
  height: 30px;
  background-color: lawngreen;
  border-radius: 50%;
}

.p-unread-text {
  position: relative;
  top: 24%;
  left: 34%;
}
</style>
