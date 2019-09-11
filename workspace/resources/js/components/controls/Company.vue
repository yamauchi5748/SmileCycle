<template>
    <section class="view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">12社</h2>
            <button @click="openDialog" class="normal-button margin-left-auto">会社を登録する</button>
            <div class="mask" :class="{open:isDialogOpen}">
                <div class="dialog">
                    <div class="dialog-header">
                        <h2 class="dialog-title">会社登録</h2>
                        <button @click="closeDialog" class="dialog-hide-button"></button>
                    </div>
                    <div class="dialog-body">
                        <input class="input" placeholder="会社名" />
                        <input class="input" placeholder="住所" />
                        <input class="input" placeholder="電話番号" />
                        <input class="input" placeholder="FAX" />
                    </div>
                    <div class="dialog-footer">
                        <button @click="closeDialog" class="flat-button">取り消し</button>
                        <button class="normal-button">登録する</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
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
</style>