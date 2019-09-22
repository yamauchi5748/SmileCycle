<template>
    <div class="view controls-secondary-view">
        <div class="controls-secondary-header">
            <button @click="goBack" class="go-back-button">←</button>
            <h2 class="title">スタンプ詳細</h2>
        </div>
        <div class="controls-secondary-body">
            <div class="p-wrapper">
                <img class="p-tab-stamp" :src="'/stamp-images/' + stamp_group.tab_image_id" alt="ロード中" />
                <ul class="drag-and-drop">

                </ul>
            </div>
            <ul class="p-stamp-list">
                <li v-for="(stamp_id,index) in stamp_list" :key="index">
                    <img class="p-stamp" :src="'/stamp-images/' + stamp_id" alt="ロード中" />
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            stamp_group: {},
            stamp_list: [],
        };
    },
    mounted: function() {
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
            const index = this.$route.params['id'];
            this.stamp_group = this.$root.stamp_group_list[index];
            this.stamp_list = this.stamp_group.stamps;
        },
    }
};
</script>

<style lang="scss" scoped>
.p-wrapper {
    display: flex;
    .p-tab-stamp {
        border: solid 1px;
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