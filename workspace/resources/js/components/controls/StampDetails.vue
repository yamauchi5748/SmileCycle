<template>
    <div class="view">
        <div class="p-header">
            スタンプ詳細
        </div>
        <div class="p-body">
            <div class="layout-flex margin-bottom-big">
                <div class="debug-stamp-tab">スタンプタブ画像</div>
                <div class="layout-flex --flex-direction-column margin-left-normal">
                    <div class="drag-and-drop-area p-input-stamp">ここにドラッグアンドドロップしてください</div>
                    <button class="margin-left-auto normal-button --disabled">追加する</button>
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
            isSelectMode: false,
            stamp_list: [{}, {}, {}, {}, {}, {}]
        };
    }
};
</script>

<style lang="scss" scoped>
.p-header{
    
}
.p-input-stamp {
    margin: auto;
    height: 120px;
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