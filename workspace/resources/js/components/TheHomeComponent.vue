<template>
  <div class="p-page" ref="page">
    <the-global-header class="p-header"></the-global-header>
    <main class="p-content">
      <router-view></router-view>
      <!-- テストログイン要素 -->
    </main>
  </div>
</template>

<script>
import TheGlobalHeader from "./TheGlobalHeader";
export default {
  props: {
    author: Object
  },
  mounted() {
    console.log("Component mounted.");
    this.$root.author = this.author;
    this.$root.connectPrivate("member." + this.author._id);
    //this.$router.push({ path: "/chat-rooms" });

    // 最初に、ビューポートの高さを取得し、0.01を掛けて1%の値を算出して、vh単位の値を取得
    let vh = window.innerHeight * 0.01;
    // カスタム変数--vhの値をドキュメントのルートに設定
    this.$refs.page.style.setProperty("--vh", `${vh}px`);
  },
  /* テスト用ログインメソッド */
  components: {
    TheGlobalHeader
  }
};
</script>

<style lang="scss" scoped>
.p-page {
  height: 100vh;
  display: grid;
  grid-template-rows: 60px 1fr;
  grid-template-columns: 1fr;
  //overflow-y: hidden;

  @media screen and(max-width: 414px) {
    & {
      height: 100vh; /* 変数をサポートしていないブラウザのフォールバック */
      height: calc(var(--vh, 1vh) * 100);
    }
  }
}
.p-content {
  height: 100%;
}
.p-header {
  height: 60px;
}
</style>
