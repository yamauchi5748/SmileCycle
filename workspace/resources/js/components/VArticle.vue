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
        <div class="p-slider" v-if="existImages">
            <button class="p-scroll-button previous" @click="scrollPrevious"></button>
            <ul class="p-post-images" ref="images" :style="sliderStyle">
                <li class="p-post-image-wrapper" v-for="(image,index) in post.images" :key="index">
                    <figure class="p-post-image-inner">
                        <img class="p-post-image" :src="'/img/profile_image.jpg'" />
                    </figure>
                </li>
            </ul>
            <button class="p-scroll-button next" @click="scrollNext"></button>
        </div>
        <p ref="text" class="p-text" :class="{'text-over':isTextOver}">{{post.text}}</p>
    </article>
</template>

<script>
export default {
    props: {
        post: Object,
        to: [String,Object]
    },
    data: function() {
        return {
            image_width: 600,
            slider_point: 0,
            isTextOver: false
        };
    },
    mounted: function() {
        //DOMがレンダリングし終わった後に処理する
        this.updateTextOver();
    },
    computed: {
        //左に画像の幅分ずらすstyle
        sliderStyle: function() {
            return {
                transform:
                    "translateX(-" +
                    this.slider_point * this.image_width +
                    "px)"
            };
        },
        //画像が1枚以上存在するとtrueを返す
        existImages: function() {
            return this.post.images && this.post.images.length > 0;
        }
    },
    methods: {
        goTo(){
            if(!this.to){
                return
            }
            this.$router.push(this.to);
        },
        //ポインターを１つ後に進める
        scrollNext: function() {
            if (!this.existImages) {
                return;
            }
            if (this.post.images.length - 1 <= this.slider_point) {
                return;
            }
            this.slider_point += 1;
        },
        //ポインターを1つ前に進める
        scrollPrevious: function() {
            if (!this.existImages) {
                return;
            }
            if (0 >= this.slider_point) {
                return;
            }
            this.slider_point -= 1;
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
.p-slider {
    position: relative;
    overflow: hidden;
    .p-scroll-button {
        position: absolute;
        top: 0;
        bottom: 0;
        display: flex;
        width: 160px;
        cursor: pointer;
        z-index: 1;
        &.previous {
            left: 0;
        }
        &.next {
            right: 0;
        }
    }
}
.p-post-images {
    display: flex;
    height: 400px;
    transition-duration: 0.5ss;
    .p-post-image-wrapper {
        display: flex;
        flex-shrink: 0;
        height: 100%;
        width: 600px;
    }
    .p-post-image-inner {
        display: block;
        flex-shrink: 0;
        height: 100%;
        width: 100%;
        background-color: $gray;
        .p-post-image {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            max-height: 100%;
        }
    }
}
.p-text {
    position: relative;
    margin: 16px 24px;
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
            font-weight: 600;
            content: "続きを読む";
            justify-content: center;
            align-items: flex-end;
            background: linear-gradient(transparent 6rem, white);
        }
    }
}
</style>