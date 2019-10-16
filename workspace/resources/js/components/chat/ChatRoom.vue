<template>
  <div class="details">
    <div class="name">
      <span v-if="room">{{ room.group_name }}</span>
      <button>
        <img src="/img/settings-icon.png" alt />
      </button>
    </div>
    <div class="contents">
      <v-scrollbar class="margin-left-smallest" :box-height="box_height">
        <ol class="history" ref="list_box">
          <li v-for="(content, index) in contents" :key="index">
            <div class="content">
              <div class="profile">
                <img src="/img/profile_image.jpg" alt="profile" />
              </div>
              <div class="signature">
                <span>{{ content.sender_name }}</span>
                <span>{{ content.created_at }}</span>
              </div>
              <div class="message">{{ content.content_id }}</div>
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
  </div>
</template>
<script>
import VScrollbar from "../VScrollbar";
export default {
  components: {
    VScrollbar
  },
  data() {
    return {
      intervalId: undefined,
      box_height: 0,
      auth: true,
      result: true,
      is_group: true,
      contents: [
        //$B:GBg(B10$B7o$^$G<hF@(B
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:$B%F%-%9%H(B, 2:$B%9%?%s%W(B, 3:$B2hA|(B, 4:$BF02h(B
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        }
      ]
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
    }
  },

  methods: {
    resizeEvent: function() {
      this.box_height = this.$refs.list_box.clientHeight + 23;
    }
  }
};
</script>
<style lang="scss" scoped>
.details {
  background-color: $base-color;
  height: 100%;
  position: relative;
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
</style>










