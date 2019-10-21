<template>
    <secondary-view>
        <template #title>スタンプ詳細</template>
        <template #body>
            {{property}}
            <div class="input-wrapper">
                <v-input-image class="p-stamp-upload" v-model="property.tab_image_id">タブ画像</v-input-image>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="property.stamps">スタンプ</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <label class="input-label">
                    <v-input-checkbox v-model="property.is_all"></v-input-checkbox>全ての会員が利用する
                </label>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <v-select-members v-model="property.members"></v-select-members>
            </div>
            <div class="buttons-wrapper --space-between">
                <button class="flat-button" @click="handleDeleteButtonClick">削除する</button>
                <button class="normal-button" @click="handleSubmitButtonClick">保存する</button>
            </div>
        </template>
    </secondary-view>
</template>

<script>
import SecondaryView from "./SecondaryView.vue";
import VInputImage from "../VInputImage";
import VInputMultipleImages from "../VInputMultipleImages";
import VInputCheckbox from "../VInputCheckbox";
import VSelectMembers from "../VSelectMembers";
export default {
    data: function() {
        return {
            property: {
                tab_image: null,
                stamps: [],
                is_all: true,
                members: []
            }
        };
    },
    created: function() {
        /* スタンプグループ情報がなければ取得 */
        if (this.$root.stamp_group_list.length > 0) {
            this.setData();
        } else {
            // 対象のスタンプグループ情報を取得
            this.$root.loadAdminStampGroups().then(res => {
                this.setData();
            });
        }
    },
    methods: {
        handleSubmitButtonClick: function() {
            this.$root.editStampGroup(this.property);
        },
        handleDeleteButtonClick: function() {
            this.$root
                .deleteStampGroup(this.property._id)
                .then(function(res) {
                    console.log("スタンプ削除しました");
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        // データをセット
        setData: function() {
            this.property = this.$root.stamp_group_list.find(stamp_group => {
                return stamp_group._id == this.$route.params.id;
            });
        }
    },
    components: {
        VInputImage,
        VInputMultipleImages,
        VSelectMembers,
        VInputCheckbox,
        SecondaryView
    }
};
</script>

<style lang="scss" scoped>
.p-header-wrapper {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    .p-stamp-upload {
        flex-grow: 1;
        align-self: stretch;
    }
    .p-tab-stamp {
        width: 150px;
        height: 150px;
    }
}
.p-stamp-wrapper {
    position: relative;
    display: block;
    width: 120px;
    height: 120px;
}
.p-stamp {
    display: block;
    width: 100%;
    height: 100%;
}
.p-stamp-delete-button {
    display: block;
    width: 20px;
    height: 20px;
    position: absolute;
    right: 0px;
    top: 0px;
    cursor: pointer;
    background: url(/img/close_stamp.svg) no-repeat;
}
.p-stamp-list {
    display: grid;
    margin-top: 32px;
    justify-content: space-between;
    grid-template-columns: repeat(auto-fill, 120px);
    grid-gap: 24px;
}
</style>