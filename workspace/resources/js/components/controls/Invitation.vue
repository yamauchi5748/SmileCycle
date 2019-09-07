<template>
    <section class="pane">
        <div class="pane-body">
            <label class="input-wrapper">
                <input class="input" placeholder="タイトル" v-model="title" />
                <span class="counter">{{title.length}}/50</span>
            </label>
            <label class="input-wrapper">
                <textarea class="input multi-line" placeholder="本文" v-model="text" />
                <span class="counter">{{text.length}}/500</span>
            </label>
            <div
                class="drag-and-drop-area"
                @dragover="handleDragOver"
                @drop="handleDrop"
            >画像をドラッグアンドドロップしてください</div>
            <ul class="files">
                <li class="file" v-for="(file, index) in files" :key="index">{{file.name}}</li>
            </ul>
        </div>
        <div class="pane-footer">
            <button class="normal-button layout-submit-button">投稿する</button>
        </div>
    </section>
</template>
<script>
export default {
    data() {
        return {
            title: "",
            text:"",
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
.drag-and-drop-area {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    height: 300px;
}
.pane-body {
    :nth-child(n) {
        margin: 8px 0;
    }
    .layout-submit-button {
        margin-left: auto;
    }
}
.files {
    .file {
        display: flex;
        height: 32px;
        padding: 0 12px;
        align-items: center;

        border-radius: 5px;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
    }
}
</style>
