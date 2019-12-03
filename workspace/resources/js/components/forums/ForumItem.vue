<template>
    <v-card :max-width="$vuetify.breakpoint.thresholds.md">
        <v-list-item>
            <v-list-item-avatar color="grey">
                <img :src="'https://picsum.photos/400?random='+Math.random()">
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
            v-if="!is_comment_displyed && forum.comments.length > 0"
            @click="is_comment_displyed = true"
            depressed
            text
        >コメント{{forum.comments.length}}件全てを表示する</v-btn>
        <v-list v-show="is_comment_displyed" dence>
            <v-list-item class="d-block" v-for="(comment,idx) in forum.comments" :key="idx">
                <div class="mb-1">
                    <v-avatar size="30" color="grey">
                        <img :src="'https://picsum.photos/400?random='+Math.random()">
                    </v-avatar>
                    <span class="ml-2 caption">{{comment.name}}</span>
                </div>
                <p class="body-2 font-weight-light">{{comment.text}}</p>
            </v-list-item>
        </v-list>
        <div class="mx-4 text-right caption grey--text">{{forum.created_at}}</div>
        <v-divider></v-divider>
        <v-card-actions>
            <v-text-field v-model="comment" placeholder="コメント追加..."></v-text-field>
            <v-btn :disabled="comment.length == 0" text color="accent-4" @click="sendComment">投稿する</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        forum: {
            type: Object,
            require:true
        }
    },
    data: () => ({
        is_comment_displyed: false,
        comment: ""
    }),
    methods: {
        sendComment() {
            this.forum.comments.push({ name: "ユーザー", text: this.comment });
            this.comment = "";
        }
    }
};
</script>

<style>
</style>