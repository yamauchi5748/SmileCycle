<template>
    <secondary-view>
        <template #title>スタンプ詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input-image class="p-stamp-upload" v-model="property.tab_image_id" :prefix="'/stamp-images/'">タブ画像</v-input-image>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="edit_stamps" :prefix="'/stamp-images/'">スタンプ</v-input-multiple-images>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <label class="input-label">
                    <v-input-checkbox v-model="property.is_all"></v-input-checkbox>全ての会員が利用する
                </label>
            </div>
            <div class="input-wrapper">
                <span class="input-title">公開範囲</span>
                <v-select-members v-model="edit_members"></v-select-members>
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
            edit_stamps: [],
            edit_members: [],
            property: {
                tab_image: null,
                stamps: [],
                is_all: true,
                members: [],
                add_members: [],
                remove_members: []
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
            const self = this;
            this.property.add_stamps = this.edit_stamps.filter(function(stamp) {
                return typeof stamp == "object";
            });
            this.property.remove_stamps = this.property.stamps.filter(function(
                edit_stamp
            ) {
                return (
                    -1 ==
                    self.edit_stamps.findIndex(function(stamp) {
                        return edit_stamp == stamp;
                    })
                );
            });
            this.property.add_members = this.edit_members.filter(function(
                edit_member
            ) {
                return (
                    -1 ==
                    self.property.members.findIndex(function(member) {
                        return edit_member == member;
                    })
                );
            });
            this.property.remove_members = this.property.members.filter(
                function(member) {
                    return (
                        -1 ==
                        self.edit_members.findIndex(function(edit_member) {
                            return member == edit_member;
                        })
                    );
                }
            );

            this.$root
                .editStampGroup(this.property)
                .then(function(response) {
                    self.$router.push({ name: "controls-stamp" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        handleDeleteButtonClick: function() {
            const self = this;
            this.$root
                .deleteStampGroup(this.property._id)
                .then(function(response) {
                    self.$router.push({ name: "controls-stamp" });
                })
                .catch(function(error) {
                    console.error(error);
                });
        },
        // データをセット
        setData: function() {
            this.property = Object.assign(
                {},
                this.property,
                this.$root.stamp_group_list.find(stamp_group => {
                    return stamp_group._id == this.$route.params.id;
                })
            );
            this.edit_members = this.property.members.slice();
            this.edit_stamps = this.property.stamps.slice();
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