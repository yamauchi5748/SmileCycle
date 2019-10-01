<template>
    <secondary-view>
        <template #title>会のご案内詳細</template>
        <template #body>
            <div class="input-wrapper">
                <v-input v-model="title" counter :max="25">タイトル</v-input>
            </div>
            <div class="input-wrapper">
                <v-input v-model="text" counter :max="500" multiline>本文</v-input>
            </div>
            <div class="input-wrapper">
                <v-input-image v-model="images">画像</v-input-image>
            </div>
            <div class="input-wrapper">
                <div class="input-title">招待者</div>
                <v-select-members v-model="attend_members"></v-select-members>
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
import VInputImage from "../VInputImage.vue";
import VSelectMembers from "../VSelectMembers.vue";
export default {
    components: {
        SecondaryView,
        VInput,
        VInputImage,
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
            ],
            attend_members: [
                {
                    _id: "j89ec26-3768-48dc-9ca9-a7d604815507",
                    name: "花子",
                    ruby: "はなこ",
                    status: 1 //1:出席、2:欠席、3:未選択
                },
                {
                    _id: "j89ec26-3768-48dc-9ca9-a7d604815507",
                    name: "松島",
                    ruby: "まつしま",
                    status: 3 //1:出席、2:欠席、3:未選択
                }
            ],
            deadline_at: "2019-09-09"
        };
    }
};
</script>

<style lang="scss" scoped>
</style>