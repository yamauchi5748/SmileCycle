<template>
  <v-scrollbar :box-height="box_height">
    <ul class="p-room-list" ref="room_list">
      <li class="margin-bottom-normal" v-for="(room, index) in room_list" :key="index">
        <router-link
          class="layout-flex --justify-content-space-evenly"
          :to="{name:'chat-room',params:{id: room._id}}"
        >
          <figure>
            <img class="margin-right-smallest p-room-profile" src="/img/profile_image.jpg" />
          </figure>
          <div
            class="layout-flex --flex-direction-column --justify-content-center margin-left-smallest p-room-primary-box-wrapper"
          >
            <div class="margin-bottom-smaller p-room-primary-box">
              <span>{{ room.name }}</span>
              <span>({{ room.members.length }})</span>
            </div>
            <p
              class="p-room-first-content"
              v-if="room.contents.length > 0"
            >{{ room.contents[0].content }}</p>
          </div>
          <div class="--align-self-center p-unread-box" v-show="1 > 0">
            <span>{{ 1 }}</span>
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
  data() {
    return {
      box_height: 100,
      room_list: [
        {
          _id: 1,
          name: "test1fehfheihifhihifhiehihfiheifhih",
          members: [{ _id: "1", name: "you1" }, { _id: "0", name: "me" }],
          contents: []
        },
        {
          _id: 2,
          name: "ベアーズちーむ",
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
        },
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
        },
        {
          _id: 1,
          name: "test1fehfheihifhihifhiehihfiheifhih",
          members: [{ _id: "1", name: "you1" }, { _id: "0", name: "me" }],
          contents: []
        },
        {
          _id: 2,
          name: "ベアーズちーむ",
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
        },
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
  mounted: function() {
    this.box_height = this.$refs.room_list.clientHeight;
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
  width: 314px;
  padding-bottom: 58px;
}

.p-room-profile {
  max-width: 57px;
  border-radius: 50%;
}

.p-room-primary-box-wrapper {
  width: 154px;
}

.p-room-primary-box {
  font-size: 17px;
  font-weight: 500;
  color: #707070;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.p-room-first-content {
  font-size: 15px;
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
  line-height: 30px;
  background-color: $accent-color;
  color: white;
  border-radius: 50%;
}
</style>
