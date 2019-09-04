<template>
    <section class="pane">
        <div class="pane-body">
            <input class="input" placeholder="タイトル" />
            <textarea class="input multi-line" placeholder="本文" />
            <div class="drag-and-drop">画像をドラッグアンドドロップしてください</div>
        </div>
        <div class="pane-footer">
            <button class="normal-btn">投稿する</button>
        </div>
        <input @dragover="handleDragOver" @drop="handleDrop" type="file" accept="image/*" multiple />
    </section>
</template>
<script>
export default {
    methods: {
        handleDragOver(evt) {
            evt.stopPropagation();
            evt.preventDefault();
            console.log(evt);
            evt.dataTransfer.dropEffect = "copy";
        },
        handleDrop(evt) {
            evt.stopPropagation();
            evt.preventDefault();
            console.log("drop",evt);
            evt.target.files = evt.dataTransfer.files;
        }
    }
};
</script>
<style lang="scss" scoped>
</style>
