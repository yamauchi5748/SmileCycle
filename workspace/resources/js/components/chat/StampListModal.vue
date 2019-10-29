<template>
  <div class="p-modal">
    <div class="p-overlay" @click="closeModal"></div>
    <div class="p-stamp-box">
      <!-- 横スクロールバー -->
      <div class="p-stamp-box__tab-list-wrapper">
        <ul class="p-stamp-box__tab-list layout-flex">
          <li
            class="p-stamp-box__tab-list-item layout-flex --align-items-center margin-right-normal"
            :class="{active:isActive(index)}"
            v-for="index in 16"
            :key="index"
            @click="loadActiveIndex(index)"
          >
            <img
              class="p-stamp-box__tab-stamp layout-flex-item"
              src="/img/search-icon.png"
              alt="検索アイコン"
            />
          </li>
        </ul>
      </div>
      <v-scrollbar class="p-stamp-box__body-list-wrapper">
        <ul class="p-stamp-box__body-list margin-left-small">
          <li
            class="p-stamp-box__body-list-item layout-flex --justify-content-center --align-items-center"
            v-for="index in 30"
            :key="index"
          >
            <img class="p-stamp-box__body-stamp" src="/img/search-icon.png" alt="検索アイコン" />
          </li>
        </ul>
      </v-scrollbar>
    </div>
  </div>
</template>
<script>
import VScrollbar from "../VScrollbar";
export default {
  components: {
    VScrollbar
  },
  props: {
    close: Event,
    openModal: Event
  },

  data() {
    return {
      active_index: 1
    };
  },

  methods: {
    closeModal: function() {
      this.$emit("close");
    },

    isActive: function(index) {
      return index === this.active_index;
    },

    loadActiveIndex: function(index) {
      this.active_index = index;
    }
  }
};
</script>
<style lang="scss" scoped>
.p-modal {
  margin: 0;
  position: absolute;
  bottom: 85px;
  right: 20px;
  z-index: 4;
}

.p-overlay {
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  right: 0;
  opacity: 0.5;
  background: red;
  z-index: 2;
}

.p-stamp-box {
  width: 100%;
  height: 350px;
  display: grid;
  grid-template-rows: 47px 1fr;
  cursor: pointer;
  z-index: 4;

  &__tab-list-wrapper {
    width: 328px;
    height: 100%;
    padding: 0 16px;
    border-top: 1px solid #707070;
    border-left: 1px solid #707070;
    border-right: 1px solid #707070;
    border-radius: 10px 10px 0 0;
    background: $base-color;
  }

  &__tab-list {
    height: 150%;
    overflow: auto;
  }

  &__tab-list-item {
    width: 32px;
    height: 41px;
    padding-bottom: 5px;
  }

  .active {
    padding-bottom: 0;
    border-bottom: 5px solid $accent-color;
  }

  &__tab-stamp {
    width: 32px;
    height: 32px;
  }

  &__body-list-wrapper {
    border-bottom: 1px solid #707070;
    border-left: 1px solid #707070;
    border-right: 1px solid #707070;
    border-radius: 0 0 10px 10px;
  }

  &__body-list {
    height: 100%;
    display: grid;
    grid-template-columns: repeat(5, 64.5px);
    grid-template-rows: repeat(5, 60.5px);
    background: $base-sub-color;
    overflow-x: hidden;
  }

  &__body-list-item {
    width: 64.5px;
    height: 60.5px;
    border-radius: 10px;

    &:hover {
      background-color: $sub-color;
    }
  }

  &__body-stamp {
    width: 30px;
    height: 30px;
  }
}
</style>
