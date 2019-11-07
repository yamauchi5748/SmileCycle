<template>
    <section class="view controls-primary-view" v-loaded="is_loaded">
        <div class="layout-flex --align-items-center margin-bottom-big">
            <h2 class="item-count">{{$root.admin_invitation_list.length}}記事</h2>
    	    <router-link
                class="normal-button margin-left-auto"
                :to="{name:'controls-invitation-create'}"
            >会のご案内を投稿する</router-link>
        </div>
        <v-article
            class="p-post"
            v-for="(invitation,index) in this.$root.admin_invitation_list"
            :key="index"
            :post="invitation"
            :to="{name:'controls-invitation-details',params:{id:invitation._id}}"
        ></v-article>
    </section>
</template>
<script>
import VArticle from "../VArticle.vue";
export default {
    data() {
        return {
            is_loaded:false
        };
    },
    created: function() {
        const self = this;
        this.$root.loadAdminInvitations().then(function(){
            self.is_loaded = true;
        });
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
