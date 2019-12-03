<template>
    <div class="p-view">
        <div class="p-header">
            <button @click="goBack" class="p-go-back-button">←</button>
            <h2 class="p-title">
                <slot name="title"></slot>
            </h2>
        </div>
        <v-scrollbar>
            <div class="p-body-wrapper">
                <div class="p-body">
                    <slot name="body"></slot>
                </div>
            </div>
        </v-scrollbar>
    </div>
</template>

<script>
import VInputImage from "../VInputImage";
import VScrollbar from "../VScrollbar";
export default {
    components: {
        VScrollbar
    },

    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.push({
                path: this.$route.path
                    .split("/")
                    .slice(0, -1)
                    .join("/")
            });
        }
    }
};
</script>

<style lang="scss" scoped>
.p-view {
    height: 100%;
    display: grid;
    grid-template-rows: 56px 1fr;
    
    .p-header {
        display: flex;
        padding: 16px 0 12px;
        border-bottom: solid 1px rgba(0, 0, 0, 0.2);
        .p-title {
            margin-left: 12px;
        }
        .p-go-back-button {
            margin-left: 16px;
        }
    }
    .p-body-wrapper {
        display: flex;
        width: 100%;
        justify-content: center;
    }
    .p-body {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 650px;
        min-width: 320px;
        padding: 32px;
    }
    .p-title {
        display: inline-flex;
        justify-content: flex-end;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
    }
    .p-go-back-button {
        display: inline-flex;
        font-size: 18px;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
}
</style>