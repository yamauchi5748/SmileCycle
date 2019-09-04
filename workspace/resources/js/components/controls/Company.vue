<template>
    <section class="pane">
        <div class="pane-header">
            <h2 class="item-count">12社</h2>
            <button @click="openDialog" class="normal-btn m-l-auto">会社を登録する</button>
            <div class="mask" :class="{open:isDialogOpen}">
                <div class="dialog">
                    <div class="dialog-header">
                        <h2 class="dialog-title">会社登録</h2>
                        <button @click="closeDialog" class="dialog-hide-btn">
                            <img src="/img/close.png" />
                        </button>
                    </div>
                    <div class="dialog-body">
                        <input class="input" placeholder="会社名" />
                        <input class="input" placeholder="住所" />
                        <input class="input" placeholder="電話番号" />
                        <input class="input" placeholder="FAX" />
                    </div>
                    <div class="dialog-footer">
                        <button @click="closeDialog" class="flat-btn">取り消し</button>
                        <button class="normal-btn">登録する</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="pane-body controls-table">
            <thead class="table-head">
                <tr class="table-head-item">
                    <th>会社名</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr class="table-body-item" v-for="n in 10" :key="n">
                    <td>サンプルカンパニー</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>
<script>
export default {
    data() {
        return {
            isDialogOpen: false
        };
    },
    methods: {
        closeDialog() {
            this.isDialogOpen = false;
        },
        openDialog() {
            this.isDialogOpen = true;
        }
    }
};
</script>
<style lang="scss" scoped>
.controls-table {
    width: 100%;
    .table-head-item {
        text-align: left;
        border-bottom: solid 1px $gray;
        th {
            color: $gray;
            font-size: 13px;
            padding: 20px 0 8px 16px;
        }
    }
    .table-body {
        overflow: scroll;
    }
    .table-body-item {
        text-align: left;
        border-bottom: solid 1px $gray;
        td {
            height: 64px;
            vertical-align: middle;
            color: $gray;
            padding-left: 16px;
        }
    }
}
.mask {
    visibility: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    &.open {
        visibility: visible;
    }
}
.dialog {
    width: 640px;
    border-radius: 8px;
    background-color: $base-color;
    .dialog-header {
        display: flex;
        padding: 16px 24px;
        align-items: center;
        .dialog-title {
            font-size: 22px;
        }
        .dialog-hide-btn {
            display: flex;
            align-items: center;
            margin:0;
            padding: 0;
            margin-left: auto;
        }
    }
    .dialog-body {
        display: flex;
        flex-direction: column;
        padding: 16px 24px;
        border-top: solid $gray 1px;
        border-bottom: solid $gray 1px;
    }
    .dialog-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 20px 24px;
        :last-child {
            margin-left: 12px;
        }
    }
}
</style>