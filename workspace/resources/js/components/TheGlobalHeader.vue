<template>
  <header class="header">
    <nav class="header-container">
      <ol class="breadcrumbs-list">
        <li v-for="(path,index) in route" :key="index">
          <router-link :to="'/'+route.slice(0,index+1).join('/')">{{ bread_table[path] }}</router-link>
        </li>
      </ol>
      <button class="nav-menu" @click="naviOpen">
        <img src="/img/menu.png" />
      </button>
      <div class="nav-close" v-show="navi_active" @click="naviOpen"></div>
      <div class="nav-content" :class="{active:navi_active}">
        <ol class="navi_wrap">
          <li>
            <a href="#">AAA</a>
          </li>
          <li>
            <a href="#">BBB</a>
          </li>
          <li>
            <a href="#">CCC</a>
          </li>
          <li>
            <a href="#">DDD</a>
          </li>
          <li>
            <a href="#">EEE</a>
          </li>
        </ol>
      </div>
    </nav>
  </header>
</template>
<script>
export default {
  data: function() {
    return {
      bread_table: {
        controls: "管理",
        invitation: "会のご案内",
        member: "会員",
        company: "会社",
        stamp: "スタンプ",
        chats: "チャット"
      },
      navi_active: false
    };
  },
  methods: {
    naviOpen: function() {
      this.navi_active = !this.navi_active;
    }
  },
  computed: {
    route: function() {
      const list = this.bread_table;
      return this.$route.path.split("/").filter(function(value) {
        return list[value] != undefined;
      });
    }
  }
};
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
  position: relative;
  margin-left: auto;
  display: inline-block;
  width: 24px;
  height: 24px;
  vertical-align: middle;
}


.nav-close {
  position: fixed;
  z-index: 99;
  top: 0; 
  left: 0;
  width: 100%;
  height: 100%;
  background: black;
  opacity: 0;
  transition: 0.3s ease-in-out;
  opacity: 0.5;
}


.nav-content {
  position: fixed;
  top: 0;
  right: 0;
  z-index: 9999;
  width: 330px;
  height: 100%;
  background: #fff; /*背景色*/
  transition: 0.3s ease-in-out;
  -webkit-transform: translateX(105%);
  transform: translateX(105%); 
  &.active {
    -webkit-transform: translateX(0%);
    transform: translateX(0%);
  }
}
.nav-content-close {
  display: none;
  animation-name: nav-content-anime-end;
  animation-duration: 0.5s;
}
</style>
