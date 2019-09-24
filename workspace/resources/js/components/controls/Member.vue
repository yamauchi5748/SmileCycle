<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">{{ this.$root.member_list.length }}人</h2>
            <router-link
                class="normal-button margin-left-auto"
                :to="{name:'controls-member-create'}"
            >会員を登録する</router-link>
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
                <router-link
                    class="table-body-item"
                    v-for="member in $root.members"
                    :key="member._id"
                    tag="tr"
                    :to="member._id"
                    append
                >
                    <td>
                        <img class="profile-img" src="/img/demo_stamp.png" />
                    </td>
                    <td>{{ member.name }}</td>
                    <td>{{ member.ruby }}</td>
                    <td>{{ member.post }}</td>
                </router-link>
            </tbody>
        </table>
    </section>
</template>
<script>
export default {
    mounted: function() {
        this.$root.loadMembers();
    }
};
</script>
<style lang="scss" scoped>
</style>