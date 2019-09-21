<template>
    <section class="view controls-primary-view">
        <div class="layout-flex --align-items-center">
            <h2 class="item-count">12社</h2>
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
                <tr class="table-body-item" v-for="n in 10" :key="n">
                    <td>サンプルカンパニー</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
</style>