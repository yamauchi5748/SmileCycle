<template>
    <table class="p-table">
        <template v-for="department in department_list">
            <tr class="p-table-head-item" :key="department.name">
                <th class="p-checkbox-cell">
                    <v-input-checkbox></v-input-checkbox>
                </th>
                <th>{{department.name}}</th>
            </tr>
            <tr class="p-table-body-item" v-for="member in department.members" :key="member._id">
                <td class="p-checkbox-cell">
                    <v-input-checkbox v-model="member.attend"></v-input-checkbox>
                </td>
                <td>{{member.name}}</td>
            </tr>
        </template>
    </table>
</template>

<script>
import VInputCheckbox from "./VInputCheckbox.vue";
export default {
    data: function() {
        return {
            department_list: [
                { name: "東京", members: [] },
                { name: "愛媛", members: [] },
                { name: "鎌倉", members: [] },
                { name: "大阪", members: [] }
            ]
        };
    },
    mounted: function() {
        for (let i = 0; i < 20; i++) {
            this.department_list[i % this.department_list.length].members.push({
                _id: i,
                name: "member_" + i
            });
        }
    },
    components: {
        VInputCheckbox
    }
};
</script>

<style lang="scss" scoped>
.p-table {
    position: relative;
    width: 100%;
    border-collapse: collapse;
    border: solid 1px $gray;
    %table-row {
        text-align: left;
        border-bottom: solid 1px $gray;
    }
    %table-data {
        height: 64px;
        padding: 1px 16px;
        color: $black;
        vertical-align: middle;
    }
    .p-table-head-item {
        @extend %table-row;
        th {
            @extend %table-data;
            font-weight: 700;
        }
    }
    .p-table-body-item {
        @extend %table-row;
        td {
            @extend %table-data;
        }
        &:hover {
            background-color: $gray;
        }
    }
    .p-checkbox-cell {
        width: 50px;
    }
}
</style>