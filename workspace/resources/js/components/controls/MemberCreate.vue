<template>
    <div class="view">
        <div class="p-header">
            <button @click="goBack" class="p-back-button">←</button>
            <h2 class="p-title">会員作成</h2>
        </div>
        <div class="p-body">
            <p class="p-input-area">
                <label class="input-wrapper">
                    <input class="input" placeholder="会員名" v-model="name" />
                    <span class="counter">{{name.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="ふりがな" v-model="ruby" />
                    <span class="counter">{{ruby.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="電話番号" v-model="phone_number" />
                    <span class="counter">{{phone_number.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="メールアドレス" v-model="mail_address" />
                    <span class="counter">{{mail_address.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="会社" v-model="company" />
                    <span class="counter">{{company.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="役職" v-model="post" />
                    <span class="counter">{{post.length}}/50</span>
                </label>
                <label class="input-wrapper">
                    <input class="input" placeholder="部門" v-model="department" />
                    <span class="counter">{{department.length}}/50</span>
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
            ruby: "",
            phone_number: "",
            mail_address: "",
            company: "",
            post: "",
            department: ""
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
.p-footer{
    display: flex;
    justify-content: flex-end;
    padding: 0 32px;
    :last-child{
        margin-left:16px;
    }
}
.p-input-area{
    .input-wrapper{
        margin-bottom: 32px;
    }
}
</style>