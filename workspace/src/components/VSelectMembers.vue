<template>
    <v-card class="elevation-1">
        <v-card-title>
            {{label || "会員選択"}}
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="検索..."
                single-line
                hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="members"
            :search="search"
            item-key="id"
            show-select
            group-by="department"
            sort-by="department"
        >
            <template v-slot:group.header="props">
                <td>
                    <v-simple-checkbox
                        @input="toggleAll(props.group)"
                        :indeterminate="checkboxType[props.group] == 'indeterminate'"
                        :value="checkboxType[props.group] == 'all'"
                    ></v-simple-checkbox>
                </td>
                <td>{{props.group}}</td>
                <td></td>
            </template>
            <template v-slot:item.avatar="{item}">
                <v-avatar color="grey" size="40">
                    <img :src="'/api/images/'+(item.avatar || 'iamtheavatar')" />
                </v-avatar>
            </template>
            <template v-slot:header.data-table-select></template>
            <template v-slot:item.data-table-select="{item}">
                <v-simple-checkbox @input="toggle(item.id)" :value="test.has(item.id)"></v-simple-checkbox>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import { watch } from "@/store";
export default {
    props: {
        label: String,
        value: {
            tyep: Array,
            default: []
        },
        rules: Array
    },
    data: () => ({
        search: "",
        headers: [
            {
                text: "プロフ画像",
                align: "center",
                sortable: false,
                value: "avatar"
            },
            {
                text: "名前",
                value: "name"
            }
        ],
        test: null,
        checkboxType: {
            愛媛笑門会: "off",
            東京笑門会: "off",
            鎌倉笑門会: "off",
            大阪笑門会: "off"
        },
        members: []
    }),
    watch: {
        value: {
            handler() {
                this.test = new Set(this.value);
                this.updateAllSelected();
            },
            immediate: true
        }
    },
    created() {
        watch("members", this.members);
    },
    computed: {
        departmentTable() {
            return {
                愛媛笑門会: this.members
                    .filter(member => member.department == "愛媛笑門会")
                    .map(member => member.id),
                東京笑門会: this.members
                    .filter(member => member.department == "東京笑門会")
                    .map(member => member.id),
                鎌倉笑門会: this.members
                    .filter(member => member.department == "鎌倉笑門会")
                    .map(member => member.id),
                大阪笑門会: this.members
                    .filter(member => member.department == "大阪笑門会")
                    .map(member => member.id)
            };
        }
    },
    methods: {
        toggle(id) {
            if (this.test.has(id)) {
                this.test.delete(id);
            } else {
                this.test.add(id);
            }
            this.$emit("input", [...this.test]);
        },
        toggleAll(department) {
            if (this.checkboxType[department] != "all") {
                this.$emit("input", [
                    ...new Set([
                        ...this.value,
                        ...this.departmentTable[department]
                    ])
                ]);
            } else {
                this.departmentTable[department].forEach(id =>
                    this.test.delete(id)
                );
                this.$emit("input", [...this.test]);
            }
        },
        // 部門の一括選択のチェックボックスの表示を更新する
        updateAllSelected() {
            const S = this.value;
            for (const department in this.checkboxType) {
                const A = this.departmentTable[department];
                const SorA = new Set([
                    ...this.value,
                    ...this.departmentTable[department]
                ]).size;
                const SandA_ = SorA - A.length;
                const SandA = -(SandA_ - S.length);
                this.checkboxType[department] =
                    SandA == 0
                        ? "off"
                        : SandA < A.length
                        ? "indeterminate"
                        : "all";
            }
        }
    }
};
</script>

<style>
</style>