<template>
    <secondary-view>
        <template #title>スタンプ詳細</template>
        <template #body>
            <div class="p-tab-stamp-wrapper">
                <img class="p-tab-stamp" src="/img/demo_stamp.png" alt="タブ画像" />
            </div>
            <ul class="p-stamp-list">
                <li v-for="(stamp,index) in stamp_list" :key="index">
                    <span></span>
                    <img class="p-stamp" src="/img/demo_stamp.png" />
                </li>
            </ul>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInputImage from "../VInputImage";
export default {
    data: function() {
        return {
            stamp_list: new Array(20),
            add_stamp_list: []
        };
    },
    components: {
        VInputImage,
        SecondaryView
    }
};
</script>

<style lang="scss" scoped>
.p-tab-stamp-wrapper {
    display: flex;
    .p-tab-stamp {
        width: 150px;
        height: 150px;
    }
}
.p-stamp {
    display: block;
    width: 120px;
    height: 120px;
}
.p-stamp-list {
    display: grid;
    margin-top: 32px;
    justify-content: space-between;
    grid-template-columns: repeat(auto-fill, 120px);
    grid-gap: 24px;
}
</style>