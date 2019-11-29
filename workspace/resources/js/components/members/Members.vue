<template>
  <section class="p-members">
    <div class="p-members-inner">
      <div class="p-members__menu layout-flex --justify-content-space-between">
        <ul
          class="p-members__menu__list layout-flex --justify-content-space-around --align-items-center"
        >
          <li
            class="p-members__menu__item"
            v-for="(department, index) in department_list"
            :key="index"
          >
            <department-button :department="department" v-on:change="onChangeDepartmentStatus" />
          </li>
        </ul>
        <v-input
          class="p-members__menu__search-box"
          v-model="search_text"
          :placeholder="placeholder"
        />
      </div>
      <div class="p-members__body">
        <h1 class="p-members__body__title">
          {{ department_name }}笑門会
          <hr />
        </h1>
        <v-scrollbar class="p-members__body__list-wrapper">
          <ul class="p-members__body__list">
            <router-link
              tag="li"
              class="p-members__body__item"
              :to="{name:'member-details', params:{id:member._id}}"
              v-for="(member, index) in member_list"
              :key="index"
            >
              <member-item :member="member" v-if="isShowItem(member)" />
            </router-link>
          </ul>
        </v-scrollbar>
      </div>
    </div>
  </section>
</template>

<script>
import VInput from "../VInput";
import VScrollbar from "../VScrollbar";
import DepartmentButton from "./DepartmentButton";
import MemberItem from "./MemberItem";
export default {
  components: {
    VInput,
    VScrollbar,
    DepartmentButton,
    MemberItem
  },

  data() {
    return {
      department_status: [true, false, false, false],
      search_text: "",
      placeholder: "会員名または会社名で検索"
    };
  },

  computed: {
    department_list: function() {
      let list = [];
      for (const index in this.$root.department_list) {
        const department = {
          key: index,
          name: this.$root.department_list[index],
          status: this.department_status[index]
        };
        list.push(department);
      }
      return list;
    },

    department_name: function() {
      return this.department_list.filter(department => {
        return department.status;
      })[0].name;
    },

    member_list: function() {
      return this.$root.member_list;
    }
  },

  methods: {
    onChangeDepartmentStatus: function(key) {
      for (const index in this.department_status) {
        this.department_status.splice(index, 1, false);
      }
      this.department_status.splice(key, 1, true);
    },

    isShowItem: function(member) {
      for (const index in this.department_status) {
        if (!this.department_status[index]) continue;
        return (
          this.department_list[index].name + "笑門会" ==
            member.department_name &&
          member.name.indexOf(this.search_text) != -1
        );
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.p-members {
  height: 100%;
  background-color: #f4f4f4;

  &-inner {
    max-width: 1100px;
    min-width: 688px;
    height: 100%;
    display: grid;
    grid-template-rows: 76px 1fr;
    margin: 0 auto;
    padding: 0 40px;
  }

  &__menu {
    margin: 10px 0;
  }

  &__menu__list {
    min-width: 460px;
    flex: 3;
  }

  &__menu__search-box {
    flex: 2;
  }

  &__body {
    display: grid;
    grid-template-rows: 59px 1fr;
    background-color: #fff;
  }

  &__body__title {
    padding: 17px 0 7px;
    font-size: 35px;
    color: $main-color;
    text-align: center;
  }

  &__body__list-wrapper {
    height: calc(100% - 15px);
    margin-top: 15px;
  }

  &__body__item {
    margin: 20px 0 20px 10px;
    cursor: pointer;

    @media screen and(min-width: 769px) {
      &:hover {
        background-color: rgba(#ff9900, 0.2);
      }
    }
  }
}
</style>