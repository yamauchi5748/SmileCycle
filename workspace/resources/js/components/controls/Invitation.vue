<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center margin-bottom-big">
            <h2 class="item-count">30記事</h2>
            <router-link
                class="normal-button margin-left-auto"
                :to="{name:'controls-invitation-create'}"
            >会のご案内を投稿する</router-link>
        </div>
        <v-article
            class="p-post"
            v-for="(invitation,index) in invitations"
            :key="index"
            :post="invitation"
            :to="{name:'controls-invitation-details',params:{id:invitation.id}}"
        ></v-article>
    </section>
</template>
<script>
import VArticle from "../VArticle.vue";
export default {
    data() {
        return {
            invitations: [
                {
                    id: "l43as26-3768-48aa-9ca9-a7d604815507",
                    title: "第59回会のお知らせ",
                    text:
                        "本日はお日柄もよく非常に過ごしやすくなっております。",
                    images: [
                        "l43as26-3768-48aa-9ca9-a7d604815507",
                        "l43as26-3768-48aa-9ca9-a7d604815507"
                    ],
                    created_at: "2019-06-01 16:27:03"
                },
                {
                    id: "l43as26-3768-48aa-9ca9-a7d604815507",
                    title: "第59回会のお知らせ",
                    text:
                        "本日はお日柄もよく非常に過ごしやすくなっております。",
                    images: [
                        "l43as26-3768-48aa-9ca9-a7d604815507",
                        "l43as26-3768-48aa-9ca9-a7d604815507"
                    ],
                    created_at: "2019-06-01 16:27:03"
                }
            ]
        };
    },
    created: function() {
        this.$root.loadMembers();
    },
    components: {
        VArticle
    }
};
</script>
<style lang="scss" scoped>
.p-post {
    margin: 32px auto;
}
</style>