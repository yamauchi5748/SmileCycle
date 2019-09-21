<template>
    <div class="view controls-secondary-view">
        <div class="controls-secondary-header">
            <button @click="goBack" class="go-back-button">←</button>
            <h2 class="title">スタンプ登録</h2>
        </div>
        <div class="controls-secondary-body">
            <div class="input-area">
                <div class="input-wrapper">
                    <span class="input-title">タブ画像</span>
                    <div class="drag-and-drop --size-stamp">
                        <div class="stamp"></div>
                    </div>
                </div>
                <div class="input-wrapper">
                    <span class="input-title">スタンプ</span>
                    <v-input-image v-model="stamp_images"></v-input-image>
                </div>
                <div class="input-wrapper">
                    <span class="input-title">公開範囲</span>
                    <input class="input" type="checkbox" v-model="is_all" />
                </div>
                <div class="input-wrapper">
                    <span class="input-title">特定会員選択</span>
                    <ul>
                        <li v-for="member in $root.members" :key="member.id">
                            <label>
                                <span>{{member.name}}</span>
                                <input type="checkbox" :value="member._id" v-model="post_members" />
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="controls-secondary-footer">
            <button class="flat-button">取り消し</button>
            <button class="normal-button">登録する</button>
        </div>
    </div>
</template>

<script>
import VInputImage from "../VInputImage";
export default {
    data: function() {
        return {
            tab_image: null,
            is_all: false,
            stamp_images: [],
            post_members: []
        };
    },
    mounted: function() {
        this.$root.loadMembers();
    },
    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        }
    },
    components: {
        VInputImage
    }
};
</script>

<style lang="scss" scoped>
</style>