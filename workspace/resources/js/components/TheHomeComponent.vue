<template>
    <div class="page">
        <the-global-header></the-global-header>
        <main class="content">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import TheGlobalHeader from "./TheGlobalHeader";
export default {
    props: {
        member: String,
        api_token: String
    },
    mounted() {
        console.log("Component mounted.");
    },
    components: {
        TheGlobalHeader
    }
};
</script>

<style lang="scss">
.content {
    width: 100%;
    height: 100%;
}
</style>