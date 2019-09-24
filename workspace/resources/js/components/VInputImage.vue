<template>
    <div>
        <span class="p-title" v-if="$slots.default">
            <slot></slot>
        </span>
        <ul v-if="!only" class="p-multi-image" @dragover="handleDragOver" @drop="handleDrop">
            <li class="p-wrapper" v-for="(dataURL, index) in dataURL_list" :key="index">
                <img class="upload-image" :src="dataURL" alt="スタンプ" />
            </li>
        </ul>
        <div v-else class="p-only-image" @dragover="handleDragOver" @drop="handleDrop">
            <img class="upload-image" :src="dataURL_list[0]" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: { type: Array, required: true },
        only: { type: Boolean, default: false },
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

            event.stopPropagation();
            event.preventDefault();
            if (this.only) {
                let reader = new FileReader();
                reader.readAsDataURL(new_files[0]);
                reader.onload = () => {
                    this.dataURL_list.splice(0, 1, reader.result);
                };
                this.$emit("input", [new_files[0]]);
            } else {
                for (let file of new_files) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.dataURL_list.push(reader.result);
                    };
                }
                this.$emit("input", [...new_files, ...this.value]);
            }
        }
    }
};
</script>

<style lang="scss" scoped>
//ドラッグアンドドッロプ用のスタイル
%drag-and-drop {
    border: dashed 1px;
    background-size: 40%;
    background-repeat: no-repeat;
    background-position: center;
    background-color: rgba(225, 225, 255, 0.8);
    background-image: url(/img/image.svg);
}
.p-multi-image {
    @extend %drag-and-drop;
    display: grid;
    height: 270px;
    padding: 16px;
    grid-template-columns: repeat(auto-fill, 90px);
    grid-row-gap: 20px;
    justify-content: space-between;
    align-items: flex-start;
    overflow-y: scroll;
    .p-wrapper {
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
        display: inline-block;
        height: 90px;
        width: 90px;
    }
}
.p-only-image {
    @extend %drag-and-drop;
    display: block;
    height: 150px;
    width: 150px;
    .upload-image {
        height: 100%;
        width: 100%;
    }
}
.p-title {
    display: inline-flex;
    margin-bottom: 12px;
    font-size: 14px;
    font-weight: bold;
}
</style>