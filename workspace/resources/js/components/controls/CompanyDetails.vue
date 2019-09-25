<template>
  <secondary-view>
    <template #title>会社詳細</template>
    <template #body>
      <div class="input-wrapper">
        <v-input v-model="name" counter :max="140">会社名</v-input>
      </div>
      <div class="input-wrapper">
        <v-input v-model="address">住所</v-input>
      </div>
      <div class="input-wrapper">
        <v-input v-model="telephone_number">電話番号</v-input>
      </div>
      <div class="buttons-wrapper --space-between">
        <button class="flat-button">削除する</button>
        <button class="normal-button">保存する</button>
      </div>
    </template>
  </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInput from "../VInput";
export default {
  data: function() {
    return {
      name: "",
      address: "",
      telephone_number: ""
    };
  },
  components: {
    VInput,
    SecondaryView
  },
  created: function() {
    // 対象の会社情報を取得
    this.$root
      .getCompany(this.$route.params.id)
      .then(res => {
        this.setData(res.data.company);
      })
      .catch(error => {
        console.log(error);
      });
  },
  methods: {
    // データをセット
    setData: function(company) {
      this.name = company.name;
      this.address = company.address;
      this.telephone_number = company.telephone_number;
    }
  }
};
</script>