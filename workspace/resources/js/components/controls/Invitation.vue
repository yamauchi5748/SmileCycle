<template>
    <section class="view layout-flex --flex-direction-column">
        <label class="input-wrapper">
            <input class="input" placeholder="タイトル" v-model="title" />
            <span class="counter">{{title.length}}/50</span>
        </label>
        <label class="input-wrapper">
            <textarea class="input multi-line" placeholder="本文" v-model="text" />
            <span class="counter">{{text.length}}/500</span>
        </label>
        <div
            class="drag-and-drop-area p-input-image"
            @dragover="handleDragOver"
            @drop="handleDrop"
        >画像をドラッグアンドドロップしてください</div>
        <ul class="files">
            <li class="file" v-for="(file, index) in files" :key="index">{{file.name}}</li>
        </ul>
        <button class="normal-button margin-left-auto">投稿する</button>
    </section>
</template>
<script>
export default {
    data() {
        return {
            title: "",
            text: "",
            files: []
        };
    },
    methods: {
        handleDragOver(event) {
            event.stopPropagation();
            event.preventDefault();
            event.dataTransfer.dropEffect = "copy";
        },
        handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();
            for (let file of event.dataTransfer.files) {
                this.files.push(file);
            }
        }
    }
};
</script>
<style lang="scss" scoped>
.p-input-image{
    height: 300px;
}

</style>