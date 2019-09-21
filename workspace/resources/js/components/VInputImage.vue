<template>
    <ul
        class="p-drag-and-drop --size-area upload-files"
        @dragover="handleDragOver"
        @drop="handleDrop"
    >
        <li class="upload-wrapper" v-for="(dataURL, index) in dataURL_list" :key="index">
            <img class="upload-image" :src="dataURL" alt="スタンプ" />
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        value: { type: Array, required: true }
    },
    data: function() {
        return {
            dataURL_list: []
        };
    },
    methods: {
        handleDragOver(event) {
            event.dataTransfer.dropEffect = "copy";
            event.stopPropagation();
            event.preventDefault();
        },
        handleDrop(event) {
            let new_files = event.dataTransfer.files;
            for (let file of new_files) {
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => {
                    //thisの参照先が変わるから
                    this.dataURL_list.push(reader.result);
                };
            }
            this.$emit("input", [...new_files, ...this.value]);
            event.stopPropagation();
            event.preventDefault();
            console.log(this.value);
        }
    }
};
</script>

<style lang="scss" scoped>
//ドラッグアンドドッロプ用のスタイル
.p-drag-and-drop {
    border: dashed 1px;
    background-size: 40%;
    background-repeat: no-repeat;
    background-position: center;
    background-color: rgba(225, 225, 255, 0.8);
    background-image: url(/img/image.svg);
    &.--size-area {
        height: 270px;
    }
    &.--size-stamp {
        height: 120px;
        width: 120px;
    }
    &.upload-files {
        padding: 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        align-content: flex-start;
        overflow-y: scroll;
        .upload-wrapper {
            display: inline-block;
            position: relative;
            background-image: url(/img/bg_input_image.png);
            &:before {
                content: "";
                display: block;
                width: 20px;
                height: 20px;
                position: absolute;
                right: -10px;
                top: -10px;
                background: url(/img/close_stamp.svg) no-repeat;
            }
        }
        .upload-image {
            height: 90px;
            width: 90px;
        }
    }
}
</style>