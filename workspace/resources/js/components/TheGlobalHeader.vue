<template>
    <header class="header">
        <nav class="header-container">
            <ol class="breadcrumbs-list">
                <li v-for="(path,index) in route" :key="index">
                    <router-link :to="'/'+route.slice(0,index+1).join('/')">
                        {{ bread_table[path] }}
                    </router-link>
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
    data: function(){
        return {
            bread_table:{
                controls:'管理',
                invitation:'会のご案内',
                member:'会員',
                company:'会社',
                stamp:'スタンプ'
            },
        }
    },
    computed: {
        route: function(){
            const list = this.bread_table
            return this.$route.path.split('/').filter( function(value){
                return list[value] != undefined
            })
        },
    }

}
</script>
<style lang="scss" scoped>
.header {
    display: flex;
    width: 100%;
    background-color: $sub-color;
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.4);
    align-items: center;
}
.header-container {
    display: flex;
    width: 100%;
    padding: 0 60px;
    align-items: center;
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