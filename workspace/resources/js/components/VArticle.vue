<template>
    <article class="p-post">
        <div class="p-post-informations">
            <h2 class="p-post-title" @click="goTo">{{post.title}}</h2>
            <time class="p-created">{{post.created_at}}</time>
            <span class="p-profile" v-if="post.sender_id">
                <figure class="p-profile-image-wrapper">
                    <img class="p-profile-image" :src="'/img/profile_image.jpg'" />
                </figure>
                <span class="p-name">{{post.sender_name}}</span>
            </span>
        </div>
        <ul v-if="existImages" class="p-post-images" ref="images">
            <li
                class="p-post-image-wrapper"
                v-for="(image,index) in post.images"
                :class="{active: slider_point == index}"
                @click="previewImage(index)"
                :key="index"
            >
                <figure class="p-post-image-inner">
                    <img class="p-post-image" :src="image" />
                </figure>
            </li>
        </ul>
        <div class="p-text-wrapper">
            <p
                ref="text"
                class="p-text"
                :class="{'text-over':isTextOver,'p-text-all':isReadMore}"
            >{{post.text}}</p>
            <button class="p-read-more" :class="{active:isTextOver}" @click="openText">続きを読む</button>
        </div>
    </article>
</template>

<script>
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
            image_width: 600,
            slider_point: 0,
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
        //index番目の画像が大きく表示される
        previewImage: function(index) {
            this.slider_point = index;
        },
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
        }
    }
};
</script>

<style lang="scss" scoped>
$border-value: solid 1px $gray;
.p-post {
    width: 600px;
    border-radius: 8px;
    border: $border-value;
    box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.2),
        0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 1px 3px 0 rgba(0, 0, 0, 0.12);
}
.p-post-informations {
    display: flex;
    flex-direction: column;
    .p-post-title {
        padding: 0 16px;
        padding-top: 16px;
        font-size: 21px;
        font-weight: 600;
        cursor: pointer;
    }

    .p-created {
        font-size: 14px;
        color: gray;
        margin-right: 16px;
        margin-bottom: 8px;
        margin-left: auto;
    }
    .p-profile {
        display: inline-flex;
        padding: 8px 16px;
        font-size: 16px;
        align-items: center;
        border-top: $border-value;
        border-bottom: $border-value;
        .p-profile-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
        .p-name {
            margin-left: 16px;
        }
    }
}
.p-post-images {
    display: flex;
    width: 600px;
    height: 400px;
    flex-wrap: wrap;
    justify-content: center;
    transition-duration: 0.5s;
    .p-post-image-wrapper {
        display: flex;
        flex-shrink: 0;
        flex-grow: 0;
        width: 40px;
        height: 40px;
        margin-bottom: -80px;
        & + .p-post-image-wrapper:not(.active) {
            margin-left: 16px;
            cursor: pointer;
        }
        //拡大表示されているときのクラス
        &.active {
            width: 100%;
            height: 400px;
            order: -1;
            z-index: -1;
        }
    }
    .p-post-image-inner {
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-content: center;
        flex-shrink: 0;
        background-color: $gray;
        .p-post-image {
            display: block;
            max-width: 100%;
            max-height: 100%;
        }
    }
}
.p-text-wrapper {
    position: relative;
    margin: 16px 24px;
    .p-text {
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
        font-weight: 500;
        border-radius: 20px;
        box-shadow: 0 0 5px rgba(28, 28, 29, 0.65);
        background-color: $base-color;
        cursor: pointer;
        &.active {
            display: inline-block;
        }
    }
}
</style>