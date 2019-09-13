<template>
    <section class="view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">{{ this.$root.members.length }}人</h2>
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
                <tr class="table-body-item" v-for="member in this.$root.members" :key="member._id">
                    <td>
                        <img />
                    </td>
                    <td>{{ member.name }}</td>
                    <td>{{ member.ruby }}</td>
                    <td>{{ member.post }}</td>
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
    mounted: function(){
        this.$root.loadMembers();
    }
};
</script>
<style lang="scss" scoped>
</style>