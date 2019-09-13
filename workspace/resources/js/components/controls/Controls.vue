<template>
    <div class="layout-flex">
        <div class="p-controls-sidebar layout-flex --flex-direction-column">
            <div class="p-sidebar-header">管理</div>
            <ul class="p-sidebar-content">
                <router-link
                    :to="{name:'controls-invitation'}"
                    class="p-tab-link"
                    active-class="active"
                    tag="li"
                >会のご案内</router-link>
                <router-link
                    :to="{name:'controls-member'}"
                    class="p-tab-link"
                    active-class="active"
                    tag="li"
                >会員</router-link>
                <router-link
                    :to="{name:'controls-company'}"
                    class="p-tab-link"
                    active-class="active"
                    tag="li"
                >会社</router-link>
                <router-link
                    :to="{name:'controls-stamp'}"
                    class="p-tab-link"
                    active-class="active"
                    tag="li"
                >スタンプ</router-link>
            </ul>
        </div>
        <div class="p-primary-view">
            <router-view></router-view>
        </div>
        <div class="p-secondary-view">
            <router-view name="secondary"></router-view>
        </div>
    </div>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
.p-controls-sidebar {
    width: 180px;
    flex-shrink: 0;
}
.p-sidebar-header{
    display: flex;
    padding: 16px 0;
    box-sizing: border-box;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    justify-content: center;
    align-items: center;
}
.p-tab-link {
    display: flex;
    padding: 16px 0;
    box-sizing: border-box;
    text-decoration: none;
    font-size: 16px;
    color: $gray;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    &.active {
        border-left: solid 4px $accent-color;
        color: $accent-color;
    }
}
.p-primary-view {
    width: 600px;
    padding: 28px 48px;
    border-left: solid 1px rgba(0, 0, 0, 0.2);
    border-right: solid 1px rgba(0, 0, 0, 0.2);
    .pane-header {
        display: flex;
        align-items: center;
    }
    .item-count {
        margin-right: auto;
        font-size: 1.25rem;
        font-weight: 900;
    }
}

.p-secondary-view {
    width: 500px;
    padding: 28px 48px;
    .pane-header {
        display: flex;
        align-items: center;
    }
    .item-count {
        margin-right: auto;
        font-size: 1.25rem;
        font-weight: 900;
    }
}
</style>