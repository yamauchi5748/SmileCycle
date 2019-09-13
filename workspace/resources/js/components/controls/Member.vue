<template>
    <section class="view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">208人</h2>
            <router-link class="normal-button margin-left-auto" :to="{name:'controls-member-create'}">会員を登録する</router-link>
        </div>
        <table class="table">
            <thead class="table-head">
                <tr class="table-head-item">
                    <th>プロフィール画像</th>
                    <th>会員名</th>
                    <th>ふりがな</th>
                    <th>役職名</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr class="table-body-item" v-for="n in 10" :key="n">
                    <td>
                        <img />
                    </td>
                    <td>滝藤松之助</td>
                    <td>たきとうまつのすけ</td>
                    <td>営業部理事長</td>
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