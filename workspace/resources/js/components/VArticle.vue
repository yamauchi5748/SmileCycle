<template>
    <article class="p-post">
        <div class="p-post-header">
            <v-img v-if="post.sender_id" class="p-profile-image" :src="'/img/profile_image.jpg'" />
            <div class="p-post-header-right">
                <h2 class="p-post-title" @click="goTo">{{post.title}}</h2>
                <span v-if="post.sender_id" class="p-profile-name">{{post.sender_name}}</span>
            </div>
        </div>
        <v-carousel class="p-slider" v-if="existImages" :slides="post.images"></v-carousel>
        <div class="p-text-wrapper">
            <p
                ref="text"
                class="p-text"
                :class="{'text-over':isTextOver,'p-text-all':isReadMore}"
            >{{post.text}}</p>
            <button class="p-read-more" :class="{active:isTextOver}" @click="openText">続きを読む</button>
        </div>
        <time class="p-created-at">{{post.created_at}}</time>
    </article>
</template>

<script>
import VImg from "./VImg";
import VCarousel from "./VCarousel";
export default {
    props: {
        post: Object,
        to: [String, Object],
        readmore: {
            default: false,
            type: [Boolean]
        }
    },
    data: function() {
        return {
            isTextOver: this.readmore,
            isReadMore: this.readmore
        };
    },
    mounted: function() {
        //DOMがレンダリングし終わった後に処理する
        this.updateTextOver();
    },
    computed: {
        //画像が1枚以上存在するとtrueを返す
        existImages: function() {
            return this.post.images && this.post.images.length > 0;
        }
    },
    methods: {
        goTo() {
            if (!this.to) {
                return;
            }
            this.$router.push(this.to);
        },
        openText: function() {
            this.isReadMore = true;
            this.isTextOver = false;
        },
        //本文の高さがオーバーしていた場合にtrueを設定する
        updateTextOver: function() {
            this.isTextOver =
                this.$refs.text.scrollHeight > this.$refs.text.clientHeight;
        },
        //URLを切り替える
        adjustURL(image_id) {
            if (this.post.sender_id) {
                return "/forums/" + this.post._id + "/images/" + image_id;
            }
            return "/invitations/" + this.post._id + "/images/" + image_id;
        }
    },
    components: {
        VImg,
        VCarousel
    }
};
</script>

<style lang="scss" scoped>
$border-value: solid 1px $gray;
.p-post {
    max-width: 100%;
    border: $border-value;
    border-radius: 4px;
}
.p-post-header {
    display: flex;
    height: 72px;
    border-bottom: $border-value;
    &-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-grow: 1;
        &:only-child {
            margin-left: 16px;
        }
    }
}
.p-profile-image {
    display: block;
    margin: 16px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
}
.p-profile-name {
    display: block;
    margin-top: 4px;
    font-size: 14px;
    color: #00000099;
}
.p-post-title {
    display: block;
    font-size: 20px;
    font-weight: 600;
    color: #000000de;
}
.p-slider{
    border-bottom: $border-value;
}
.p-text-wrapper {
    position: relative;
    margin: 0 16px;
    .p-text {
        font-size: 14px;
        color: #00000099;
        max-height: 10rem;
        line-height: 2rem;
        overflow-y: hidden;
        &.text-over {
            &:after {
                display: flex;
                position: absolute;
                width: 100%;
                top: 0;
                bottom: 0;
                content: "";
                justify-content: center;
                align-items: flex-end;
                background: linear-gradient(transparent 6rem, white);
            }
        }
        &.p-text-all {
            max-height: unset;
        }
    }
    .p-read-more {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        display: none;
        margin: 0 auto;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 20px;
        box-shadow: 0 0 5px rgba(28, 28, 29, 0.65);
        background-color: $base-color;
        cursor: pointer;
        &.active {
            display: inline-block;
        }
    }
}
.p-created-at {
    display: flex;
    margin: 0 16px 16px auto;
    font-size: 11px;
    color: #00000099;
    justify-content: flex-end;
}
</style>