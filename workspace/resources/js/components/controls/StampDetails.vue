<template>
    <div class="view">
        <div class="p-header">
            <button @click="goBack" class="p-back-button">←</button>
            <h2 class="p-title">スタンプ詳細</h2>
        </div>
        <div class="p-body">
            <div class="p-content-header margin-bottom-big">
                <div class="debug-stamp-tab">スタンプタブ画像</div>
                <div class="p-input-wrapper margin-left-normal">
                    <div class="drag-and-drop-area p-input-stamp">ここにドラッグアンドドロップしてください</div>
                    <button class="normal-button --disabled margin-left-auto margin-top-small">追加する</button>
                </div>
            </div>
            <ul class="p-stamp-list layout-flex --flex-direction-column">
                <li
                    class="p-stamp-line layout-flex --align-items-center"
                    v-for="(stamp,index) in stamp_list"
                    :key="index"
                >
                    <label class="p-stamp-item debug-stamp p-stamp"></label>
                    <button class="margin-left-auto margin-right-normal p-delete-button">✖</button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            stamp_list: [{}, {}, {}, {}, {}, {}]
        };
    },
    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        }
    }
};
</script>

<style lang="scss" scoped>
.p-header {
    display: flex;
    padding: 16px 0 12px;
    border-bottom: solid 1px $gray;
    font-size: 18px;
    font-weight: bold;
    .p-back-button {
        display: inline-flex;
        margin-left: 12px;
        font-weight: 900;
        cursor: pointer;
    }
    .p-title {
        display: inline-flex;
        margin-left: 48px;
    }
}
.p-body {
    padding: 28px 32px;
}
.p-content-header{
    display: flex;
    height: 160px;
    align-items:center;
}
.p-input-wrapper{
    display: flex;
    height: 100%;

    justify-content: space-between;
    flex-direction: column;
    flex-grow: 1;
}
.p-input-stamp {
    height: 100%;
}
.p-stamp-list {
    border-top: solid 1px $gray;
    .p-stamp {
        &:hover {
            width: 70px;
            height: 70px;
        }
    }
    .p-stamp-line {
        padding: 12px 0;
        border-bottom: solid 1px $gray;
    }
    .p-stamp-item {
        margin-left: 16px;
    }
    .p-delete-button {
        display: inline-flex;
        font-size: 16px;
        justify-content: center;
        align-content: center;
    }
}
</style>