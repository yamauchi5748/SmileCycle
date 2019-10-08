<template>
    <div class="p-snackbar">
        <span class="p-text">テスト</span>
        <button class="p-close-button"></button>
    </div>
</template>

<script>
export default {
    watch: {
        "$root.snackbar_text_list": {
            handler: function() {
                console.log(this.$root.snackbar_text_list, "test");
            },
            deep: true
        }
    }
};
</script>

<style lang="scss" scoped>
.p-snackbar {
    position: fixed;
    right: 20px;
    bottom: 20px;
    display: inline-flex;
    height: 48px;
    border-radius: 4px;
    color: rgba(255, 255, 255, 0.87);
    background-color: rgba(51, 51, 51, 1);
    align-items: center;
    animation-name: show;
    animation-duration: 1s;
}
@keyframes show {
    0% {
        width: 0;
        height: 0;
    }
}
.p-text {
    display: inline-block;
    margin: 0 8px;
    font-size: 14px;
}
.p-close-button {
    display: inline-block;
    height: 24px;
    width: 24px;
    margin: 0 8px;
    border-radius: 50%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-image: url(/img/close.svg);
    cursor: pointer;
    &:hover {
        background-color: rgba(80, 80, 80, 0.87);
    }
}
</style>
