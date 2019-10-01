<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">{{ this.$root.stamp_group_list.length }}種</h2>
            <router-link
                class="normal-button margin-left-auto"
                :to="{name:'controls-stamp-create'}"
            >スタンプを登録する</router-link>
        </div>
        <ul
            class="p-stamp-tab-list"
        >
            <li v-for="(stamp_group,index) in this.$root.stamp_group_list" :key="index">
                <router-link :to="stamp_group._id" append>
                    <img class="p-stamp" :src="'/stamp-images/' + stamp_group.tab_image_id" />
                </router-link>
            </li>
        </ul>
    </section>
</template>
<script>
export default {
    created: function() {
        this.$root.loadAdminStampGroups();
    },
};
</script>
<style lang="scss" scoped>
.p-stamp {
    display: block;
    width: 120px;
    height: 120px;
}
.p-stamp-tab-list {
    display: grid;
    margin-top: 32px;
    justify-content: space-between;
    grid-template-columns: repeat(auto-fill, 120px);
    grid-gap: 24px;
}
</style>
