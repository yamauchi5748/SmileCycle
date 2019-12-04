<template>
  <div class="fill-height">
    <v-navigation-drawer app clipped :mobile-break-point="0" :width="sidebar_width">
      <div class="fill-height d-flex flex-column">
        <v-tabs fixed-tabs v-model="room_type" class="flex-grow-0 flex-shrink-0">
          <v-tab>個人</v-tab>
          <v-tab>グループ</v-tab>
        </v-tabs>
        <v-divider></v-divider>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="検索..."
          clearable
          single-line
          hide-details
          dense
          outlined
          class="mx-2 mt-2 flex-grow-0 flex-shrink-0"
        ></v-text-field>
        <v-list nav class="p-rooms flex-grow-1 flex-shrink-1">
          <v-list-item
            v-for="room in rooms"
            :key="room._id"
            link
            :to="{name:'chat-room',params:{id:room._id}}"
          >
            <v-list-item-avatar color="grey">
              <img :src="'/chat-rooms/' + room._id + '/profile-image'" />
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{room.group_name}}</v-list-item-title>
              <v-list-item-subtitle>{{latestContentsText(room)}}</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action v-if="room.unread">
              <v-badge>
                <template v-slot:badge>{{room.unread}}</template>
              </v-badge>
            </v-list-item-action>
          </v-list-item>
        </v-list>
        <!-- チャットルーム作成ダイアログ -->
        <v-dialog v-model="dialog" :fullscreen="!$vuetify.breakpoint.lgAndUp" max-width="600px">
          <template v-slot:activator="{ on }">
            <v-btn v-on="on" fab fixed bottom right color="accent" class="mr-3">
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">グループ作成</span>
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
              <v-btn color="blue darken-1" text @click="save">作成する</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </div>
    </v-navigation-drawer>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    room_type: 0, // 個人 == 0 , グループ == 1
    search: null,
    rooms_collection: [],
    unsubscribe: null,
    editedItem: {
      name: "",
      members: []
    },
    defaultItem: {
      name: "",
      members: []
    }
  }),
  watch: {
    $route() {
      if (this.$route.name == "chat") {
        this.$router.replace({ name: "chat-not-found" });
      }
    },
    dialog(val) {
      val || this.close();
    }
  },
  computed: {
    rooms() {
      return this.$root.chat_room_list
        .filter(room => {
          // 表示用にフィルターをかける
          if (
            !(
              (this.room_type == 0 && !room.is_group) ||
              (this.room_type == 1 && room.is_group)
            )
          ) {
            return false;
          }
          return room.group_name.indexOf(this.search ? this.search : "") !== -1;
        })
        .slice()
        .sort(function(comparison_target, comparison_source) {
          /* 部門グループは上位に表示 */
          if (
            comparison_target.is_department &&
            !comparison_source.is_department
          ) {
            return -1;
          } else if (
            !comparison_target.is_department &&
            comparison_source.is_department
          ) {
            return 1;
          } else {
            /* コンテンツがなければ */
            if (
              !comparison_target.contents[0].created_at &&
              comparison_source.contents[0].created_at
            ) {
              /* 最新コンテンツとルーム作成日時の比較 */
              return comparison_target.created_at >
                comparison_source.contents[
                  comparison_source.contents.length - 1
                ].created_at
                ? -1
                : 1;
            } else if (
              comparison_target.contents[0].created_at &&
              !comparison_source.contents[0].created_at
            ) {
              /* 最新コンテンツとルーム作成日時の比較 */
              return comparison_target.contents[
                comparison_target.contents.length - 1
              ].created_at > comparison_source.created_at
                ? -1
                : 1;
            } else if (
              !comparison_target.contents[0].created_at &&
              !comparison_source.contents[0].created_at
            ) {
              /* ルーム作成日時の比較 */
              return comparison_target.contents[
                comparison_target.contents.length - 1
              ].created_at > comparison_source.created_at
                ? -1
                : 1;
            } else {
              /* 最新投稿日時の降順 */
              return comparison_target.contents[
                comparison_target.contents.length - 1
              ].created_at >
                comparison_source.contents[
                  comparison_source.contents.length - 1
                ].created_at
                ? -1
                : 1;
            }
          }
        });
    },
    // レスポンシブ対応
    sidebar_width() {
      if (this.$vuetify.breakpoint.lgAndUp) {
        return "300";
      } else if (
        this.$route.name == "chat" ||
        this.$route.name == "chat-not-found"
      ) {
        return "100%";
      } else if (this.$route.name == "chat-room") {
        return "0";
      } else {
        return "0";
      }
    }
  },
  methods: {
    // ルームの最新のコンテンツを表示用文字列にする
    latestContentsText(room) {
      if (room.contents && room.contents[0] && room.contents[0].message) {
        return room.contents[0].message;
      }
      return "";
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
      }, 300);
    },
    save() {
      this.rooms_collection.add({ ...this.editedItem, is_group: true });
      this.close();
    }
  },
  destroyed() {
    this.unsubscribe();
  }
};
</script>
<style lang="scss" scoped>
.p-rooms {
  height: 0;
  overflow-y: scroll;
}
</style>