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

.normal-button {
    display: flex;
    height: 36px;
    min-width: 80px;
    padding: 0 12px;
    border-radius: 4px;

    font-size: 15px;
    font-weight: 700;

    color: $base-color;
    background-color: $accent-color;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.24);

    justify-content: center;
    align-items: center;
    user-select: none;
    transition: all 80ms linear;
    cursor: pointer;
    &:active {
        box-shadow: 0 8px 8px rgba(0, 0, 0, 0.24);
    }
}
.flat-button {
    display: flex;

    height: 36px;
    min-width: 80px;
    padding: 0 12px;
    border: solid $gray 1px;
    border-radius: 4px;

    font-size: 15px;
    font-weight: 700;

    background-color: $base-sub-color;

    justify-content: center;
    align-items: center;
    user-select: none;
    transition: all 80ms linear;
    cursor: pointer;
}
.input-wrapper{

}
.input {
    display: block;
    width: 100%;
    border: none;
    border-bottom: solid $accent-color 2px;
    font-size: 16px;
    &.multi-line {
        height: 120px;
        resize: none;
    }
}
.counter {
    display: flex;
    font-size:14px;
    justify-content:flex-end;
}
</style>