<template>
  <section class="p-sidebar">
    <nav class="layout-flex --justify-content-space-around p-chats-navigation">
      <span class="p-chats-nav-container p-chats-nav-active">グループ</span>
      <span class="p-chats-nav-container">会員</span>
    </nav>
    <div class="layout-flex --align-items-center p-search-box">
      <figure class="margin-left-small">
        <img src="/img/search-icon.png" alt="検索アイコン" />
      </figure>
      <input type="text" placeholder="グループ名検索" />
    </div>
    <div class="c-scrollbar_hider_wrapper">
      <div class="c-scrollbar_hider" ref="scrollbar_hider" @scroll="height_value">
        <ul class="p-room-list">
          <li class="margin-bottom-normal" v-for="(room, index) in room_list" :key="index">
            <router-link
              class="layout-flex --justify-content-center"
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
                <span>{{ 10 }}</span>
              </div>
            </router-link>
          </li>
        </ul>
      </div>
      <div class="c-scrollbar_track" ref="scrollbar">
        <div class="c-scrollbar_bar"></div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      scrollbar_height: "0px",
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
        }
      ]
    };
  },
  mounted() {
    const el = this.$refs.scrollbar_hider;
    this.scrollbar_height = el.getBoundingClientRect().top;
    console.log(this.scrollbar_height);
  },
  methods: {
    height_value: function() {
      const el = this.$refs.scrollbar_hider;
      this.scrollbar_height = el.getBoundingClientRect().top;
      console.log(this.scrollbar_height);
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

.p-sidebar {
  width: 278px;
  background-color: rgba($sub-color, 0.45);
  display: flex;
  flex-direction: column;
}

.p-chats-navigation {
  padding: 32px 0 9px;
  border-bottom: solid 0.05px #606060;
  cursor: pointer;

  .p-chats-nav-container {
    font-size: 22px;
    color: #707070;
  }

  .p-chats-nav-active {
    color: $accent-color;
  }
}

.p-room-list {
  width: 278px;
}

.p-search-box {
  margin: 18px 9px 37px;
  height: 36px;
  background-color: $base-color;
  border: 1px solid #707070;
  box-shadow: 0 7px 17px -12px #202020;

  input {
    width: 90%;
    font-size: 16px;
    color: #707070;
    border: none;
    outline: none;
  }
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

.c-scrollbar_hider_wrapper {
  height: 100%;
  position: relative;
  overflow-x: hidden;
  overflow-y: hidden;
}

.c-scrollbar_hider {
  overflow-y: scroll;
  outline: none;
  position: absolute;
  top: 0;
  left: 0;
  right: -50px;
  bottom: 0;
  height: 100%;
  transform: translateZ(0);
}

.c-sidebar {
  overflow-y: scroll;
  overflow-x: hidden;
  outline: none;
  position: absolute;
  top: 0;
  left: 0;
  right: -50px;
  bottom: 0;
  height: 100%;
  transform: translateZ(0);
}

.c-scrollbar_track {
  position: absolute;
  right: 4px;
  top: 4px;
  bottom: 4px;
  width: 8px;
  &:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: -4px;
    background: none;
  }
}

.c-scrollbar_bar {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  border-radius: 4px;
  background: $accent-color;
  opacity: 0.5;
  cursor: default;
  outline: none;
  z-index: 1;
  will-change: transform;
  height: 370.671px;
  transform: translateY(10px);
}
</style>