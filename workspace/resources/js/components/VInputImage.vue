<template>
    <fieldset class="p-input-image">
        <legend class="p-title" v-if="$slots.default">
            <slot></slot>
        </legend>
        <div class="p-image-list-outer" :class="{'one-image':is_one_image}">
            <button class="slide-left-button" @click="scrollLeft"></button>
            <ul ref="list" class="p-image-list" @dragover="handleDragOver" @drop="handleDrop">
                <li class="p-image-wrapper" v-for="(dataURL, index) in dataURL_list" :key="index">
                    <button class="p-delete-button" @click="deleteImage(index)"></button>
                    <span class="p-image" :style="{'background-image':'url('+dataURL+')'}"></span>
                </li>
            </ul>
            <button class="slide-right-button" @click="scrollRight"></button>
        </div>
        <label class="p-add-image-label">
            <span class="p-add-image">画像を追加する</span>
            <input
                class="p-add-image-input"
                @input="handleFileInput"
                type="file"
                accept="image/png, image/jpeg"
            />
        </label>
    </fieldset>
</template>

<script>
export default {
    props: {
        value: { type: Array, required: true },
        max: { type: Number, default: 10 }
    },
    data: function() {
        return {
            dataURL_list: this.value
        };
    },
    computed: {
        is_one_image: function() {
            return this.dataURL_list.length <= 1;
        }
    },
    methods: {
        scrollLeft() {
            this.$refs.list.scrollLeft = 0;
        },
        scrollRight() {
            this.$refs.list.scrollLeft = this.$refs.list.scrollWidth;
        },
        deleteImage(index) {
            this.dataURL_list.splice(index, 1);
        },
        handleDragOver(event) {
            event.dataTransfer.dropEffect = "copy";
            event.stopPropagation();
            event.preventDefault();
        },
        handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();
            this.handleFileInput(event);
        },
        handleFileInput(event) {
            let new_files = event.target.files;
            for (let file of new_files) {
                if (this.dataURL_list.length < this.max) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.dataURL_list.push(reader.result);
                    };
                }
            }
            this.value.concat(new_files);
            this.$emit("input", this.value);
        }
    }
};
</script>

<style lang="scss" scoped>
.p-input-image {
    display: flex;
    flex-direction: column;
}
.p-title {
    display: inline-block;
    margin-bottom: 12px;
    font-size: 14px;
    font-weight: bold;
}
.p-image-list-outer {
    position: relative;
    display: block;
    width: 420px;
    padding: 12px 12px 0;
    border: solid 1px $gray;
    border-radius: 8px;
    background-repeat: no-repeat;
    background-position: center;
    background-color: rgba(248, 248, 248, 1);
    %slide-button {
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: 1;
        margin: auto 0;
        height: 30px;
        width: 30px;
        border-radius: 50%;
        background-color: $base-color;
        background-position: center;
        box-shadow: 0 0 5px rgba(28, 28, 29, 0.45);
        cursor: pointer;
    }
    .slide-left-button {
        @extend %slide-button;
        left: -12px;
        background-image: url(/img/arrow_back.svg);
    }
    .slide-right-button {
        @extend %slide-button;
        right: -12px;
        background-image: url(/img/arrow_forward.svg);
    }
    //画像が一枚の場合
    &.one-image {
        height: 124px;
        width: 124px;
        padding-bottom: 12px;
        .slide-right-button {
            display: none;
        }
        .slide-left-button {
            display: none;
        }
        .p-image-list {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            .p-image-wrapper {
                width: 100%;
                height: 100%;
            }
        }
    }
}
.p-image-list {
    display: flex;
    width: 100%;
    overflow-x: scroll;
    .p-image-wrapper {
        flex-grow: 0;
        flex-shrink: 0;
        display: inline-flex;
        position: relative;
        height: 62px;
        width: 62px;
        & + .p-image-wrapper {
            margin-left: 12px;
        }
        .p-image {
            display: inline-block;
            height: 100%;
            width: 100%;
            border-radius: 4px;
            box-shadow: inset 0 0 0 1px rgba(28, 28, 29, 0.13);
            background-color: rgba(221, 221, 221, 1);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        .p-delete-button {
            display: none;
            width: 20px;
            height: 20px;
            position: absolute;
            right: 0px;
            top: 0px;
            cursor: pointer;
            background: url(/img/close_stamp.svg) no-repeat;
        }
        &:hover {
            .p-delete-button {
                display: block;
            }
        }
    }
}
.p-add-image-label {
    display: inline-block;
    margin-top: 8px;
    .p-add-image {
        font-size: 14px;
        color: rgba(18, 100, 163, 1);
        cursor: pointer;
    }
    .p-add-image-input {
        display: none;
    }
}
</style>