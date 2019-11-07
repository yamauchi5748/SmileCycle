<template>
    <div class="p-sidebar">
        <ul class="p-sidebar-content">
            <li class="p-sidebar-item p-sidebar-item-header">管理</li>
            <router-link
                :to="{name:'controls-invitation'}"
                class="p-sidebar-item p-tab-link"
                active-class="active"
                tag="li"
            >会のご案内</router-link>
            <router-link
                :to="{name:'controls-forum'}"
                class="p-sidebar-item p-tab-link"
                active-class="active"
                tag="li"
            >みんなの掲示板</router-link>
            <router-link
                :to="{name:'controls-member'}"
                class="p-sidebar-item p-tab-link"
                active-class="active"
                tag="li"
            >会員</router-link>
            <router-link
                :to="{name:'controls-company'}"
                class="p-sidebar-item p-tab-link"
                active-class="active"
                tag="li"
            >会社</router-link>
            <router-link
                :to="{name:'controls-stamp'}"
                class="p-sidebar-item p-tab-link"
                active-class="active"
                tag="li"
            >スタンプ</router-link>
        </ul>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
@media screen and (max-width: $inner-width) {
}
.p-sidebar {
    height: 100%;
    border-right: solid 1px $gray;
}
.p-sidebar-content {
    width: 100%;
}
.p-sidebar-item-header {
    font-weight: bold;
}
.p-sidebar-item {
    display: flex;
    padding: 16px 0;
    box-sizing: border-box;
    text-decoration: none;
    font-size: 16px;
    justify-content: center;
    align-items: center;
}
.p-tab-link {
    color: $black;
    cursor: pointer;
    &.active {
        border-left: solid 4px $accent-color;
        color: $accent-color;
    }
}
</style>