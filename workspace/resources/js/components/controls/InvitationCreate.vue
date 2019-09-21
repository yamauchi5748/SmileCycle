<template>
    <div class="view controls-secondary-view">
        <div class="controls-secondary-header">
            <button @click="goBack" class="go-back-button">←</button>
            <h2 class="title">会のご案内投稿</h2>
        </div>
        <div class="controls-secondary-body">
            <div class="input-area">
                <v-input v-model="title" counter :max="25">タイトル</v-input>
                <v-input v-model="text" counter :max="500" multiline>本文</v-input>
                <div class="input-wrapper">
                    <span class="input-title">画像</span>
                    <ul
                        class="drag-and-drop --size-area upload-files"
                        @dragover="handleDragOver"
                        @drop="handleDrop"
                    >
                        <li
                            class="upload-wrapper"
                            v-for="(dataURL, index) in dataURL_list"
                            :key="index"
                        >
                            <img class="upload-image" :src="dataURL" alt="スタンプ" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="controls-secondary-footer">
            <button class="flat-button">取り消し</button>
            <button class="normal-button">登録する</button>
        </div>
    </div>
</template>
<script>
import VInput from "../VInput";
export default {
    data: function() {
        return {
            title: "",
            text: "",
            images: [],
            dataURL_list: [],
            list: {
                controls: "管理",
                invitation: "会のご案内"
            }
        };
    },
    mounted() {
        this.list["controls"];
    },
    methods: {
        //1つ前のページに戻る
        goBack: function() {
            this.$router.back();
        },
        handleDragOver(event) {
            event.stopPropagation();
            event.preventDefault();
            event.dataTransfer.dropEffect = "copy";
        },
        handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();
            for (let file of event.dataTransfer.files) {
                this.images.push(file);
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => {
                    //thisの参照先が変わるから
                    this.dataURL_list.push(reader.result);
                };
            }
        }
    },
    components: {
        VInput
    }
};
</script>
<style lang="scss" scoped>
</style>