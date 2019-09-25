<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center margin-bottom-big">
            <h2 class="item-count">{{ $root.company_list.length }}社</h2>
            <router-link
                class="normal-button margin-left-auto"
                :to="{name:'controls-company-create'}"
            >会社を登録する</router-link>
        </div>
        <table class="table">
            <thead class="table-head">
                <tr class="table-head-item">
                    <th>会社名</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <router-link
                    class="table-body-item"
                    v-for="(company,index) in $root.company_list"
                    :key="index"
                    tag="tr"
                    :to="company._id"
                    append
                >
                    <td>{{ company.name }}</td>
                </router-link>
            </tbody>
        </table>
    </section>
</template>
<script>
export default {
    created: function() {
        this.$root.loadCompanies();
    }
};
</script>
<style lang="scss" scoped>
</style>