<template>
    <v-card>
        <v-list-item>
            <v-list-item-avatar color="grey">
                <img :src="'/api/images/'+timeline.avatar" />
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title class="headline">{{timeline.title}}</v-list-item-title>
                <v-list-item-subtitle>{{timeline.name}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-sheet color="black">
            <v-carousel show-arrows-on-hover v-if="timeline.images.length > 0">
                <v-carousel-item
                    v-for="image in timeline.images"
                    :key="image"
                    :src="'/api/images/'+image"
                    contain
                ></v-carousel-item>
            </v-carousel>
        </v-sheet>
        <v-card-text
            class="font-regular black--text"
            style="white-space: pre-line"
        >{{timeline.text}}</v-card-text>
        <v-btn
            v-if="!is_comment_displyed && timeline.commentsCount > 0"
            @click="showComments"
            depressed
            text
        >コメント{{timeline.commentsCount}}件全てを表示する</v-btn>
        <v-list v-show="is_comment_displyed" dence>
            <v-list-item class="d-block" v-for="(comment,index) in comments" :key="index">
                <div class="mb-1">
                    <v-avatar size="30">
                        <img :src="'/api/images/'+comment.avatar" />
                    </v-avatar>
                    <span class="ml-2 caption">{{comment.name}}</span>
                </div>
                <p
                    class="d-flex flex-column ml-8 body-2 font-weight-light"
                    style="white-space: pre-line"
                >
                    {{comment.text}}
                    <span
                        class="grey--text caption"
                    >{{comment.created_at | fromNow}}</span>
                </p>
            </v-list-item>
        </v-list>
        <div class="mx-4 text-right caption grey--text">{{timeline.created_at | fromNow}}</div>
        <v-divider></v-divider>
        <v-card-actions>
            <v-text-field v-model="editedComment" :placeholder="placeholder"></v-text-field>
            <v-btn
                :disabled="editedComment.length == 0"
                text
                color="accent-4"
                @click="sendComment"
            >投稿する</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import { watch, axios } from "@/store";
export default {
    props: {
        timeline: {
            type: Object,
            require: true
        }
    },
    data: () => ({
        is_comment_displyed: false,
        placeholder: "コメントを入力してください",
        editedComment: "",
        comments: []
    }),
    methods: {
        showComments() {
            this.is_comment_displyed = true;
            this.watchComments();
        },
        watchComments() {
            const timeline = this.timeline;
            watch("comments", this.comments, {
                url: `/timelines/${this.timeline.id}/comment`,
                insert(array, change) {
                    const { documentId, document } = change;
                    if (document.timelineId != timeline.id) return;

                    Object.defineProperty(document, "id", {
                        value: documentId,
                        writable: false
                    });
                    array.splice(array.length, 0, document);
                }
            });
        },
        sendComment() {
            this.placeholder = "送信中...";
            axios
                .post("timelines/" + this.timeline.id + "/comment", {
                    text: this.editedComment
                })
                .then(() => {
                    this.placeholder = "コメントを入力してください";
                });
            this.editedComment = "";
        }
    }
};
</script>

<style>
</style>