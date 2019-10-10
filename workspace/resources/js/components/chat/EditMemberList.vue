<template>
  <ul class="p-list">
    <li class="p-body-item" v-for="member in member_list" :key="member._id">
      <div class="p-item-cell">
        <v-input-checkbox v-model="members[member._id]"></v-input-checkbox>
      </div>
      <div class="p-item-cell">{{member.name}}</div>
    </li>
  </ul>
</template>

<script>
import VInputCheckbox from "../VInputCheckbox.vue";
export default {
  props: {
    value: Object,
    search_text: String
  },
  data: function() {
    return {
      members: {}
    };
  },
  created: function() {
    for (let member_id in this.value) {
      this.$set(this.members, member_id, true);
    }
    this.$root.loadMembers();
  },
  watch: {
    members: {
      handler: function() {
        this.$emit("input", this.members);
      }
    }
  },
  computed: {
    member_list: function() {
      return this.$root.member_list.filter(member => {
        for (const member_id in this.members) {
          if (member._id != member_id) continue;
          if (member._id == this.$root.author._id) continue;
          return member.name.indexOf(this.search_text) != -1;
        }
      });
    }
  },
  components: {
    VInputCheckbox
  }
};
</script>

<style lang="scss" scoped>
.p-list {
  position: relative;
  width: 100%;
  height: 700px;
  overflow-y: scroll;
  border-collapse: collapse;
  border: solid 1px $gray;
  border-radius: 8px;
  %list-item {
    display: flex;
    height: 64px;
    border-bottom: solid 1px $gray;
    background-color: $base-color;
    justify-content: flex-start;
    align-items: center;
  }
  .p-body-item {
    @extend %list-item;
    &:hover {
      background-color: $gray;
    }
  }

  .p-item-cell {
    display: inline-block;
    margin-left: 24px;
  }
  &:last-child {
    %list-item:last-child {
      border-bottom: unset;
    }
  }
}
</style>