<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center margin-bottom-big">
        </div>
		<router-link
			class="create-button" v-on:click="ForumCreate"
			:to="{name:'forum-create'}"
		><img src="/img/add-button.png" alt="button"></router-link>
        <v-article
            class="p-post"
            v-for="(forum,index) in forums"
            :key="index"
            :post="forum"
            :to="{name:'forum-details',params:{id:forum.id}}"
        ></v-article>
    </section>
</template>
<script>
import VArticle from "../VArticle.vue";
export default {
    data() {
        return {
            forums: [
                {
                    id: "l43as26-3768-48aa-9ca9-a7d604815507",
                    title: "旅行",
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
                    title: "旅行",
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
                    title: "旅行",
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
.create-button {
	position: fixed;
	right: 0px;
	bottom: 23px;
	margin-left: 10px;
	margin-right: 50px;
}
</style>