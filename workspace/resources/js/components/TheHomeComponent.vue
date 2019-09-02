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
* {
    font-family: "Roboto", sans-serif;
}
html {
    background-color: $base-sub-color;
}
.content {
    width: 100%;
    height: 100%;
}

.normal-btn {

    display: inline-flex;
    justify-content: center;
    align-items: center;

    height: 36px;
    min-width: 80px;

    font-size: 15px;
    font-weight: 700;
    padding: 0 12px;

    user-select: none;
    transition: all 80ms linear;
    cursor: pointer;

    border-radius: 4px;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.24);
    color: $base-color;
    background-color: $accent-color;

    &:active {
        box-shadow: 0 8px 8px rgba(0, 0, 0, 0.24);
    }
}
.flat-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;

    height: 36px;
    min-width: 80px;

    font-size: 15px;
    font-weight: 700;
    padding: 0 12px;

    user-select: none;
    transition: all 80ms linear;
    cursor: pointer;

    border-radius: 4px;
    background-color: $base-sub-color;
    border: solid $gray 1px;
}
</style>