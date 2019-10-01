<template>
    <secondary-view>
        <template #title>みんなの掲示板詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="title" counter :max="25">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-multiple-images v-model="images">画像</v-input-multiple-images>
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
import VInput from "../VInput.vue";
import VInputMultipleImages from "../VInputMultipleImages.vue";
import VSelectMembers from "../VSelectMembers.vue";
export default {
    components: {
        SecondaryView,
        VInput,
        VInputMultipleImages,
        VSelectMembers
    },
    data: function() {
        return {
            title: "第59回会のお知らせ",
            text:
                "本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、",
            images: [
                "invitations.l66ec26-3768-48aa-9ca9-a7d604815507.l66ec26-3768-48aa-9ca9-a7d604815233.png",
                "invitations.l66ec26-3768-48aa-9ca9-a7d604815507.324ec26-3768-48aa-9ca9-a7d604815233.png"
            ]
        };
    }
};
</script>

<style lang="scss" scoped>
</style>