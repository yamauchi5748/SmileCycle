<template>
    <section class="view controls-primary-view" v-loaded="is_loaded">
        <div class="layout-flex --align-items-center margin-bottom-big">
            <h2 class="item-count">{{$root.forum_list.length}}記事</h2>
        </div>
        <v-article
            class="p-post"
            v-for="(forum,index) in $root.forum_list"
            :key="index"
            :post="forum"
            :to="{name:'controls-forum-details', params:{id:forum._id}}"
        ></v-article>
    </section>
</template>
<script>
import VArticle from "../VArticle.vue";
export default {
    data:function(){
        return {
            is_loaded:false
        }
    },
    created: function() {
        const self = this;
        this.$root.loadForums().then(function(){
            self.is_loaded = true;
        })
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