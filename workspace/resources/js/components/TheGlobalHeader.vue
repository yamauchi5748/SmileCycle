<template>
    <header class="header">
        <nav class="header-container">
            <ol class="breadcrumbs-list">
                <li>
                    <a>管理</a>
                </li>
                <li>
                    <a>会員</a>
                </li>
            </ol>
            <button class="nav-menu">
                <img src="/img/menu.png" />
            </button>
        </nav>
    </header>
</template>
<script>
export default {
    
}
</script>
<style lang="scss" scoped>
.header {
    background-color: $sub-color;
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.4);
}
.header-container {
    display: flex;
    padding: 1rem 60px;
}
.breadcrumbs-list {
    display: flex;
    list-style: none;
    li {
        display: inline-flex;
        color: $base-sub-color;
        align-items: center;
        a {
            margin-right: 1rem;
            color: $base-color;
        }
        &:after {
            display: block;
            margin-right: 1rem; 
            content: ">";
        }
        &:last-child:after {
            content: "";
        }
    }
}
.nav-menu {
    display: inline-block;
    margin-left: auto;
}
</style>