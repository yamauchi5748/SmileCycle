<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center margin-bottom-big">
            <h2 class="item-count">30記事</h2>
            <router-link
                class="normal-button margin-left-auto"
                :to="{name:'controls-invitation-create'}"
            >会のご案内を投稿する</router-link>
        </div>
        <table class="table">
            <thead class="table-head">
                <tr class="table-head-item">
                    <th>タイトル</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr class="table-body-item" v-for="(invitation,key) in invitations" :key="key">
                    <td>{{invitation.title}}</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>
<script>
export default {
    data() {
        return {
            invitations: [
                {
                    title: "テスト"
                },
                {
                    title: "テスト"
                },
                {
                    title: "テスト"
                },
                {
                    title: "テスト"
                },
                {
                    title: "テスト"
                }
            ]
        };
    },
    created: function() {
        this.$root.loadMembers();
    }
};
</script>
<style lang="scss" scoped>
</style>