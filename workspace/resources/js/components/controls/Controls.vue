<template>
    <div class="controls">
        <h1 class="controls-header">管理</h1>
        <p>管理者用のページです。</p>
        <div class="controls-tab">
            <router-link :to="{name:'controls-invitation'}" class="tab-link">会のご案内</router-link>
            <router-link :to="{name:'controls-member'}" class="tab-link active">会員</router-link>
            <router-link :to="{name:'controls-company'}" class="tab-link">会社</router-link>
            <router-link :to="{name:'controls-stamp'}" class="tab-link">スタンプ</router-link>
        </div>
        <section class="tab-pane">
            <router-view></router-view>
        </section>
    </div>
</template>
<script>
export default {};

</script>
<style lang="scss">
.controls {
    margin: 0 60px;
    .controls-header {
        margin-top: 20px;
        font-size: 24px;
    }
    p {
        margin: 18px 0 18px;
    }
}

.m-l-auto {
    margin-left: auto;
}

.controls-tab {
    display: flex;
    .tab-link {
        display: flex;
        height: 48px;
        padding: 0 16px;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        color: $accent-color;

        &.active {
            box-shadow: 1px 0 0 rgba(0, 0, 0, 0.2);
            color: $black;
            background-color: $base-color;
        }
    }
}
.tab-pane {
    margin-bottom: 48px;
    padding: 28px 56px;
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    background-color: $base-color;
    .tab-head-wrapper {
        display: flex;
        align-items: center;
    }
    .item-count {
        font-size: 1.25rem;
        font-weight: 900;
    }
}

</style>