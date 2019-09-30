<template>
    <secondary-view>
        <template #title>スタンプ詳細</template>
        <template #body>
            <div class="p-tab-stamp-wrapper">
                <img class="p-tab-stamp" :src="'/storage/images/stamps/' + stamp_group.tab_image_id + '.png'" alt="タブ画像" />
            </div>
            <ul class="p-stamp-list">
                <li v-for="(stamp,index) in stamp_list" :key="index">
                    <span></span>
                    <img class="p-stamp" :src="'/stamp-images/' + stamp" />
                </li>
            </ul>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInputImage from "../VInputImage";
export default {
    components: {
        VInputImage,
        SecondaryView
    },
    data: function() {
        return {
            stamp_group: {},
            stamp_list: [],
        };
    },
    created: function() {
        /* スタンプグループ情報がなければ取得 */
        if(this.$root.stamp_group_list.length > 0) {
            this.setData();
        }else {
            // 対象のスタンプグループ情報を取得
            this.$root.loadAdminStampGroups()
            .then(res => {
                this.setData();
            });
        }
    },
    methods: {
        // 1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        },
        // データをセット
        setData: function() {
            this.stamp_group = this.$root.stamp_group_list.find(stamp_group => {
                return stamp_group._id == this.$route.params.id;
            });
            this.stamp_list = this.stamp_group.stamps;
        },
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