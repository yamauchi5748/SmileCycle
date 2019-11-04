<template>
  <div class="p-modal">
    <div class="p-overlay" @click="closeModal"></div>
    <div class="p-stamp-preview" v-show="active_stamp_id">
      <figure class="p-stamp-preview__img-box">
        <img class="p-stamp-preview__img" :src="'/stamp-images/' + active_stamp_id" />
      </figure>
    </div>
    <div class="p-stamp-box">
      <!-- 横スクロールバー -->
      <div class="p-stamp-box__tab-list-wrapper">
        <ul class="p-stamp-box__tab-list layout-flex">
          <li
            class="p-stamp-box__tab-list-item layout-flex --align-items-center margin-right-normal"
            :class="{active:isActive(index)}"
            v-for="(stamp_group, index) in stamp_group_list"
            :key="index"
            @click="loadActiveIndex(index)"
          >
            <img
              class="p-stamp-box__tab-stamp layout-flex-item"
              :src="'/stamp-images/' + stamp_group.tab_image_id"
              alt="スタンプ"
            />
          </li>
        </ul>
      </div>
      <v-scrollbar class="p-stamp-box__body-list-wrapper">
        <ul class="p-stamp-box__body-list margin-left-small">
          <li
            class="p-stamp-box__body-list-item layout-flex --justify-content-center --align-items-center"
            :class="{'stamp-active':isStampActive(stamp_id)}"
            v-for="(stamp_id, index) in stamp_list"
            :key="index"
            @click="handleClick(stamp_id)"
          >
            <img class="p-stamp-box__body-stamp" :src="'/stamp-images/' + stamp_id" alt="スタンプ" />
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
    send: Event,
    openModal: Event
  },

  data() {
    return {
      active_index: 0,
      active_stamp_id: null
    };
  },

  computed: {
    stamp_group_list: function() {
      return this.$root.member_stamp_group_list;
    },

    stamp_list: function() {
      return this.$root.member_stamp_group_list[this.active_index].stamps;
    }
  },

  methods: {
    closeModal: function() {
      this.$emit("close");
      this.active_index = 0;
      this.active_stamp_id = null;
    },

    isActive: function(index) {
      return index === this.active_index;
    },

    isStampActive: function(stamp_id) {
      return stamp_id === this.active_stamp_id;
    },

    handleClick: function(stamp_id) {
      if (this.active_stamp_id == stamp_id) {
        this.submit(stamp_id);
      } else {
        this.loadStampActive(stamp_id);
      }
    },

    loadActiveIndex: function(index) {
      this.active_index = index;
    },

    loadStampActive: function(stamp_id) {
      this.active_stamp_id = stamp_id;
    },

    submit: function(stamp_id) {
      this.$emit("send", stamp_id);
      this.active_stamp_id = null;
    }
  }
};
</script>
<style lang="scss" scoped>
.p-modal {
  margin: 0;
  position: absolute;
  bottom: 66px;
  right: 20px;
  z-index: 4;
}

.p-overlay {
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  right: 0;
  opacity: 0;
  z-index: -1;
}

.p-stamp-preview {
  width: 100%;
  height: 120px;
  background: rgba(0, 0, 0, 0.5);
  border-radius: 10px;

  &__img-box {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  &__img {
    width: 78px;
    height: 78px;
  }
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

    &:hover {
      opacity: 0.7;
    }
  }

  &__body-list-wrapper {
    border-bottom: 1px solid #707070;
    border-left: 1px solid #707070;
    border-right: 1px solid #707070;
    border-radius: 0 0 10px 10px;
    background-color: #f2f2f2;
  }

  &__body-list {
    height: 100%;
    display: grid;
    grid-template-columns: repeat(5, 64.5px);
    grid-template-rows: repeat(5, 60.5px);
    background-color: #f2f2f2;
    overflow-x: hidden;
  }

  &__body-list-item {
    width: 64.5px;
    height: 60.5px;
    border-radius: 10px;

    &:hover {
      background-color: rgba(#ff9900, 0.2);
    }
  }

  .stamp-active {
    background-color: $sub-color;
  }

  &__body-stamp {
    width: 40px;
    height: 40px;
  }
}
</style>
