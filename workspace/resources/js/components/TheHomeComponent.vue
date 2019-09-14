<template>
    <div class="p-page">
        <the-global-header class="p-header"></the-global-header>
        <main class="p-content">
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

<style lang="scss" scoped>
.p-page{
    height: 100vh;
    width: 100vw;
}
.p-header{
    height:60px;
}
.p-content{
    height: 100%;
}
</style>