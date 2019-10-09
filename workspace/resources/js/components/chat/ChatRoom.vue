<template>
  <div class="details">
    <div class="name">
      <span v-if="room">{{ room.group_name }}</span>
    </div>
    <div class="contents">
      <div class="history">
        <ol>
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
      </div>
      <div class="send-content">
        <div class="input-box">
          <button><img class="upload-image" src alt /></button>
          <p class="upload-message" contentEditable="true"></p>
          <button><img src="/img/stamp-icon.png" alt="stamp" class="stamp" /></button>
        </div>
        <button class="normal-button">send</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      auth: true,
      result: true,
      is_group: true,
      contents: [
        //最大10件まで取得
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/18 10:40",
          already_read: 0
        },
        {
          _id: "68b02ded-fb25-4154-abdc-1f78a3b0ce49",
          sender_id: "ae96095c-dc5b-4fa3-83b6-4ccec79a7f94",
          sender_name: "bear",
          content_type: "4", //1:テキスト, 2:スタンプ, 3:画像, 4:動画
          content_id: "372b0690-d917-46f7-8fce-2f87d14e4bbc",
          created_at: "2019/09/20 10:50",
          already_read: 0
        }
      ]
    };
  },

  computed: {
    room: function() {
      return this.$root.chat_room_list.filter(room => {
        return room._id === this.$route.params.id;
      })[0];
    }
  },

  methods: {
  /*
    test(e) {
      console.log("hello: " + e.target.value.length);
      console.log(e.target.clientHeight);
      console.log(e.target.span);
      console.log(e.target);
//      e.execCommand('bold');
      if (e.target.value.length == 33) {
        e.target.style.color = "red";
      }
    },
    */
    test2(e) {
        console.log("-----------------");
        // document.execCommand(bold);
        console.log(e);
        console.log(e.target);
        // console.log(this.$route.params);
        /*
        this.$root
          .loadChatContents(this.$route.params.id)
          .then(res => {
              console.log(res);
          })
          .catch(error => {
            console.log(error);
          });
          */
    },
  }
};
</script>
<style lang="scss" scoped>
.details {
  flex-grow: 1;
  flex-direction: column;
  background-color: $base-color;
  height: 100%;
  div {
    margin: 0px;
    margin-top: 20px;
  }

  .name {
    border-bottom: .1px solid #707070;
    height: 43px;
    padding: 0 16px;
    justify-content: flex-start;
    align-items: center;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    color: $black;
  }

  .contents {
    margin: 0 16px;
    width: 100%;
    height: 727px;
    flex-direction: column;
    position: relative;
    overflow-y: hidden;
    overflow-x: hidden;
    .history {
      width: calc(100% + 17px);
      height: 60%;
      overflow-y: scroll;
      ol {
        width: 100%;
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
  .profile {
    grid-column: 1/1;
    grid-row: 1/1;
    margin: 0px;
    padding: 0px;

    img {
    width: 100%;
    heighht: 100%;
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
  position: absolute;
  width: 100%;
  display: flex;
  .input-box {
    display: flex;
    flex-grow: 1;
    margin: 0px;
    border: 1px solid #707070;
    border-radius: 4px;
    outline: none;
    img {
    }
    .upload-message {
      box-sizing: border-box;
      width: 400px;
      flex-grow: 1;
      font-size: 30px;
      outline: none;
      padding: 10px;
      line-height: 1;
    }
    button{
      align-self: flex-end;
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










