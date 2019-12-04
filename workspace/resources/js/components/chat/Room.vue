<template>
  <div v-if="room" class="fill-height d-flex flex-column">
    <v-toolbar dense flat class="flex-grow-0 flex-shrink-0">
      <v-btn :to="{name:'chat'}" exact text icon :class="{'d-none':$vuetify.breakpoint.lgAndUp}">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>{{room.group_name}}</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-menu offset-y>
        <template v-slot:activator="{ on }">
          <v-btn text icon v-on="on">
            <v-icon>mdi-settings-outline</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item link @click="editRoom">
            <v-list-item-title>編集</v-list-item-title>
          </v-list-item>
          <v-list-item link @click="exitRoom">
            <v-list-item-title>退出</v-list-item-title>
          </v-list-item>
          <v-list-item link @click="deleteRoom">
            <v-list-item-title>削除</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <!-- グループ編集 -->
      <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="600px">
        <v-card>
          <v-card-title>
            <span class="headline">グループ編集</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-text-field v-model="editedItem.name" label="ルーム名"></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12">
                  <v-select-members v-model="editedItem.members" label="ルームメンバー"></v-select-members>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">取り消し</v-btn>
            <v-btn color="blue darken-1" text @click="save">保存する</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-divider></v-divider>
    <v-list ref="contents" color="transparent" flat class="p-contents flex-grow-1 flex-shrink-1">
      <message v-for="content in room.contents" :key="content._id" :content="content"></message>
    </v-list>
    <v-textarea
      v-model="message"
      append-icon="mdi-face"
      append-outer-icon="mdi-send"
      :placeholder="placeholder"
      @click:append-outer="sendMessage"
      rows="1"
      row-height="44"
      auto-grow
      hide-details
      outlined
      class="mb-4 mx-4 flex-grow-0 flex-shrink-0"
    ></v-textarea>
  </div>
  <not-found v-else></not-found>
</template>
<script>
import NotFound from "./NotFound";
import Message from "./Message";
export default {
  data: () => ({
    placeholder: "チャット",
    dialog: false,
    message: "",
    room_unsubscribe: null,
    contents_unsubscribe: null,
    editedItem: {
      name: "",
      members: []
    }
  }),
  watch: {
    dialog(val) {
      val || this.close();
    },
    $route() {
      this.loadRoom();
    }
  },
  computed: {
    room() {
      return this.$root.chat_room_list.filter(room => {
        return room._id === this.$route.params.id;
      })[0];
    }
  },
  methods: {
    loadRoom() {
      this.unsubscribe();

      /** 既読処理 **/
      let unread_contents = new Array();
      for (const index in this.room.contents) {
        if (this.room.contents[index].unread) {
          unread_contents.push(this.room.contents[index]._id);
          this.room.unread--;
          this.room.contents[index].unread = false;
        }
      }

      if (unread_contents.length < 1) return;

      this.$root.alreadyRead(this.room._id, unread_contents).then(res => {
        console.log(res);
      });
    },
    setRoomData(doc) {
      this.room = {
        ...doc.data(),
        _id: doc.id
      };
    },
    setContentsData(snapshot) {
      this.contents = snapshot.docs.map(doc => ({
        ...doc.data(),
        _id: doc.id
      }));
      this.$nextTick(this.scrollToTop);
    },
    sendMessage() {
      if (!this.message) return;
      this.$root
        .postContents(this.room._id, {
          content_type: 1,
          message: this.message,
          is_hurry: false
        })
        .then(res => {
          this.room.contents.push(res.content);
          this.placeholder = "";
          this.$nextTick(this.scrollToTop);
        })
        .catch(error => {
          this.placeholder = "送信できませんでした";
        });
      this.placeholder = "送信中...";
      this.message = "";
    },
    //コンテンツ一覧の一番下までスクロール
    scrollToTop() {
      this.$refs.contents.$el.scrollTop = this.$refs.contents.$el.scrollHeight;
    },
    editRoom() {
      this.editedItem = Object.assign({}, this.room);
      this.dialog = true;
    },
    exitRoom() {
      /*
                退出処理をかく
            */
      this.$router.replace({ name: "chat-not-found" });
    },
    deleteRoom() {
      this.room_doc.delete();
      this.$router.replace({ name: "chat-not-found" });
    },
    close() {
      this.dialog = false;
    },
    save() {
      this.room_doc.set(this.editedItem);
      this.close();
    },
    unsubscribe() {
      this.room_unsubscribe && this.room_unsubscribe();
      this.contents_unsubscribe && this.contents_unsubscribe();
    }
  },
  destroyed() {
    this.unsubscribe();
  },
  components: {
    NotFound,
    Message
  }
};
</script>

<style scoped>
.p-contents {
  height: 0px;
  overflow-y: scroll;
}
</style>