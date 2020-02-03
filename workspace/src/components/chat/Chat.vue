<template>
    <div class="fill-height">
        <v-navigation-drawer app clipped :mobile-break-point="0" :width="sidebarWidth">
            <div class="fill-height d-flex flex-column">
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="検索..."
                    clearable
                    single-line
                    hide-details
                    dense
                    outlined
                    class="mx-2 py-2 flex-grow-0 flex-shrink-0"
                ></v-text-field>
                <v-list nav class="p-rooms flex-grow-1 flex-shrink-1">
                    <v-list-item
                        v-for="room in displayRooms"
                        :key="room.id"
                        link
                        :to="{ name: 'chat-room', params: { id: room.id }}"
                    >
                        <v-list-item-avatar>
                            <img :src="'/api/images/'+ (room.image || 'roomtop')" />
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>{{room.name}}</v-list-item-title>
                            <v-list-item-subtitle>{{room.latestContent}}</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-icon
                            v-show="room.unreadCountTable && room.unreadCountTable[user._id]"
                        >
                            <v-avatar color="accent" size="24">
                                <span
                                    class="white--text subtitle-2"
                                >{{room.unreadCountTable && room.unreadCountTable[user._id]}}</span>
                            </v-avatar>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list>
                <v-btn
                    @click="controlEditor('createItem')"
                    fab
                    fixed
                    bottom
                    right
                    color="accent"
                    class="mr-3"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
                <MRoomEditor ref="editor"></MRoomEditor>
            </div>
        </v-navigation-drawer>
        <Room v-if="selectedRoom" :key="selectedRoom.id" :room="selectedRoom"></Room>
        <NotFound v-else></NotFound>
    </div>
</template>

<script>
import { auth, watch } from "@/store";
import Room from "@/components/chat/Room";
import NotFound from "@/components/chat/NotFound";
import MRoomEditor from "@/components/MRoomEditor";
export default {
    components: {
        Room,
        NotFound,
        MRoomEditor
    },
    data: () => ({
        search: null,
        user: auth.user,
        rooms: []
    }),
    created() {
        watch("rooms", this.rooms, {
            insert(array, change) {
                const { documentId, document } = change;
                if (
                    document.members.find(val => val == auth.user._id) ==
                    undefined
                ) {
                    return;
                }
                Object.defineProperty(document, "id", {
                    value: documentId,
                    writable: false
                });
                array.splice(0, 0, document);
            }
        });
    },
    computed: {
        selectedRoom() {
            const id = this.$route.params.id;
            return this.rooms.find(room => room.id == id);
        },
        // 表示用にフィルターをかける
        displayRooms() {
            return this.rooms.filter(room => {
                return room.name.indexOf(this.search ? this.search : "") !== -1;
            });
        },
        // レスポンシブ対応
        sidebarWidth() {
            if (this.$vuetify.breakpoint.lgAndUp) {
                return "300";
            } else if (this.selectedRoom) {
                return "0";
            } else {
                return "100%";
            }
        }
    },
    methods: {
        controlEditor(action, ...value) {
            this.$refs.editor[action](...value);
        }
    }
};
</script>
<style scoped>
.p-rooms {
    height: 0;
    overflow-y: scroll;
}
</style>