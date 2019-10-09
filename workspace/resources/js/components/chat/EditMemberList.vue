<template>
    <ul class="p-list">
        <li class="p-department-list" v-for="(members,name) in departments" :key="name">
            <ul class="p-department-wrapper">
                <li class="p-header-item" :key="name">
                    <div class="p-item-cell">
                        <v-input-checkbox
                            @change="checkAll(name)"
                            v-model="attendDepartments[name]"
                        ></v-input-checkbox>
                    </div>
                    <div class="p-item-cell">{{name}}</div>
                </li>
                <li class="p-body-item" v-for="member in members" :key="member._id">
                    <div class="p-item-cell">
                        <v-input-checkbox v-model="attend[member._id]"></v-input-checkbox>
                    </div>
                    <div class="p-item-cell">{{member.name}}</div>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
import VInputCheckbox from "../VInputCheckbox.vue";
export default {
    props: {
        value: Array
    },
    data: function() {
        return {
            attendDepartments: {},
            attend: {}
        };
    },
    created: function() {
        for (let member_id in this.value) {
            this.attend[member_id] = true;
        }
        this.$root.loadMembers();
    },
    watch: {
        attend: {
            handler: function() {
                let attend_members = [];
                for (let id in this.attend) {
                    if (this.attend[id]) {
                        attend_members.push(id);
                    }
                }
                this.$emit("input", attend_members);
            },
            deep: true
        }
    },
    computed: {
        departments: function() {
            let departments = {};
            let members = this.$root.member_list;
            for (let index in members) {
                let member = members[index];
                if (!departments[member.department_name]) {
                    departments[member.department_name] = [];
                }
                departments[member.department_name].push(member);
            }
            return departments;
        }
    },
    methods: {
        checkAll: function(name) {
            let members = this.departments[name];
            for (let index in members) {
                let member = members[index];
                this.$set(
                    this.attend,
                    member._id,
                    this.attendDepartments[name]
                );
            }
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
    .p-header-item {
        @extend %list-item;
        position: sticky;
        top: 0;
        z-index: 2;
        div {
            font-size: 18px;
            font-weight: 700;
            color: $black;
        }
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
    .p-department-list:last-child {
        %list-item:last-child {
            border-bottom: unset;
        }
    }
}
</style>