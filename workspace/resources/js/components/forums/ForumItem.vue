<template>
    <v-card>
        <v-list-item>
            <v-list-item-avatar color="grey">
                <img :src="'https://picsum.photos/400?random='+Math.random()" />
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title class="headline">{{forum.title}}</v-list-item-title>
                <v-list-item-subtitle>{{forum.name}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-carousel show-arrows-on-hover v-if="forum.images.length > 0">
            <v-carousel-item v-for="image in forum.images" :key="image" :src="image" contain></v-carousel-item>
        </v-carousel>
        <v-card-text class="font-regular black--text">{{forum.text}}</v-card-text>
        <v-btn
            v-if="!is_comment_displyed && comments.length > 0"
            @click="is_comment_displyed = true"
            depressed
            text
        >コメント{{comments.length}}件全てを表示する</v-btn>
        <v-list v-show="is_comment_displyed" dence>
            <v-list-item class="d-block" v-for="comment in comments" :key="comment._id">
                <div class="mb-1">
                    <v-avatar size="30" color="grey">
                        <img :src="'https://picsum.photos/400?random='+Math.random()" />
                    </v-avatar>
                    <span class="ml-2 caption">{{comment.name}}</span>
                </div>
                <p class="body-2 font-weight-light">{{comment.text}}</p>
            </v-list-item>
        </v-list>
        <div class="mx-4 text-right caption grey--text">{{forum.created_at | date_format}}</div>
        <v-divider></v-divider>
        <v-card-actions>
            <v-text-field v-model="edited_comment" placeholder="コメント追加..."></v-text-field>
            <v-btn
                :disabled="edited_comment.length == 0"
                text
                color="accent-4"
                @click="sendComment"
            >投稿する</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import store from "../../store";
export default {
    props: {
        forum: {
            type: Object,
            require: true
        }
    },
    data() {
        return {
            comments_collection: store
                .collection("forums")
                .doc(this.forum._id)
                .collection("comments"),
            comments: [],
            is_comment_displyed: false,
            edited_comment: ""
        };
    },
    created() {
        this.comments_collection.get().then(snapshot => {
            this.comments = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
            this.loading = false;
        });
        this.unsubscribe = this.comments_collection.onSnapshot(snapshot => {
            this.comments = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        });
    },
    methods: {
        sendComment() {
            this.comments_collection.add({
                name: "コメント送信者",
                text: this.edited_comment
            });
        }
    },
    destroyed() {
        this.unsubscribe();
    }
};
</script>

<style>
</style>