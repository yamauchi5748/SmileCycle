<template>
    <secondary-view>
        <template #title>スタンプ作成</template>
        <template #body>
            <div class="input-area">
                <div class="input-wrapper">
                    <v-input-image v-model="tab_image" only>タブ画像</v-input-image>
                </div>
                <div class="input-wrapper">
                    <v-input-image v-model="stamp_images">スタンプ</v-input-image>
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
                <div class="buttons-wrapper">
                    <button class="flat-button">取り消し</button>
                    <button class="normal-button">登録する</button>
                </div>
            </div>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInputImage from "../VInputImage";
export default {
    data: function() {
        return {
            tab_image: [],
            is_all: false,
            stamp_images: [],
            post_members: []
        };
    },
    mounted: function() {
        this.$root.loadMembers();
    },
    components: {
        VInputImage,
        SecondaryView
    }
};
</script>