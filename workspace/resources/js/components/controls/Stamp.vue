<template>
    <section class="view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">12種</h2>
            <button @click="openDialog" class="normal-button margin-left-auto">スタンプを登録する</button>
            <div class="mask" :class="{open:isDialogOpen}">
                <div class="dialog">
                    <div class="dialog-header">
                        <h2 class="dialog-title">スタンプ登録</h2>
                        <button @click="closeDialog" class="dialog-hide-button"></button>
                    </div>
                    <div class="dialog-body">
                        <input class="input" placeholder="会員名" />
                        <input class="input" placeholder="ふりがな" />
                        <input class="input" placeholder="電話番号" />
                        <input class="input" placeholder="メールアドレス" />
                        <input class="input" placeholder="部門" />
                        <input class="input" placeholder="会社" />
                        <input class="input" placeholder="役職名" />
                        <input class="input" placeholder="パスワード" />
                    </div>
                    <div class="dialog-footer">
                        <button @click="closeDialog" class="flat-button">取り消し</button>
                        <button class="normal-button">登録する</button>
                    </div>
                </div>
            </div>
        </div>
        <ul
            class="debug p-layout-stamp-tab-list layout-grid --justify-content-space-between margin-top-big"
        >
            <li v-for="n in 10" :key="n">
                <router-link :to="'test'" append>
                    <img class="debug" height="120" width="120" />
                </router-link>
            </li>
        </ul>
    </section>
</template>
<script>
export default {
    data() {
        return {
            isDialogOpen: false,
            title: "",
            text: "",
            files: []
        };
    },
    methods: {
        closeDialog() {
            this.isDialogOpen = false;
        },
        openDialog() {
            this.isDialogOpen = true;
        },
        handleDragOver(event) {
            event.stopPropagation();
            event.preventDefault();
            event.dataTransfer.dropEffect = "copy";
        },
        handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();
            for (let file of event.dataTransfer.files) {
                this.files.push(file);
            }
        }
    }
};
</script>
<style lang="scss" scoped>
.p-layout-stamp-tab-list {
    grid-template-columns: repeat(3, 120px);
    grid-row-gap: 16px;
}
</style>
