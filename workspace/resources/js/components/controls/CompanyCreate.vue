<template>
    <div class="view">
        <div class="p-header">
            <button @click="goBack" class="p-back-button">←</button>
            <h2 class="p-title">会社作成</h2>
        </div>
        <div class="p-body">
            <p class="p-input-area">
                <label class="input-wrapper">
                    <input class="input" placeholder="会社名" v-model="name" />
                    <span class="counter">{{name.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="住所" v-model="street_address" />
                    <span class="counter">{{street_address.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="電話番号" v-model="phone_number" />
                    <span class="counter">{{phone_number.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="FAX" v-model="fax" />
                    <span class="counter">{{fax.length}}/50</span>
                </label>
            </p>
        </div>
        <div class="p-footer">
            <button class="flat-button">取り消し</button>
            <button class="normal-button">登録する</button>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            name: "",
            street_address: "",
            phone_number: "",
            fax: ""
        };
    },
    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        }
    }
};
</script>

<style lang="scss" scoped>
.p-header {
    display: flex;
    padding: 16px 0 12px;
    border-bottom: solid 1px $gray;
    font-size: 18px;
    font-weight: bold;
    .p-back-button {
        display: inline-flex;
        margin-left: 12px;
        font-weight: 900;
        cursor: pointer;
    }
    .p-title {
        display: inline-flex;
        margin-left: 48px;
    }
}
.p-body {
    padding: 32px 32px;
}
.p-footer {
    display: flex;
    justify-content: flex-end;
    padding: 0 32px;
    :last-child {
        margin-left: 16px;
    }
}
.p-input-area {
    .input-wrapper {
        margin-bottom: 32px;
    }
}
</style>