<template>
    <fieldset class="p-input-image">
        <legend class="p-title" v-if="$slots.default">
            <slot></slot>
        </legend>
        <div class="p-image-list-outer">
            <button class="slide-left-button" @click="scrollLeft"></button>
            <ul ref="list" class="p-image-list" @dragover="handleDragOver" @drop="handleDrop">
                <li class="p-image-wrapper" v-for="(image, index) in images" :key="index">
                    <button class="p-delete-button" @click="deleteImage(index)"></button>
                    <span class="p-image" :style="{'background-image':'url('+image.url+')'}"></span>
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
        value: {
            type: Array,
            default: function() {
                return [];
            }
        },
        prefix:{
            type:String
        },
        max: { type: Number, default: 10 }
    },
    data: function() {
        return {
            images: []
        };
    },
    watch: {
        value: function() {
            if (this.images.length != 0) return;
            for (let index in this.value) {
                const src = this.value[index];
                this.images.push({ src: src, url: this.prefix + src });
            }
        }
    },
    methods: {
        scrollLeft: function() {
            this.$refs.list.scrollLeft = 0;
        },
        scrollRight: function() {
            this.$refs.list.scrollLeft = this.$refs.list.scrollWidth;
        },
        deleteImage: function(index) {
            this.images.splice(index, 1);
            this.$emit(
                "input",
                this.images.map(function(image) {
                    return image.src;
                })
            );
        },
        handleDragOver: function(event) {
            event.dataTransfer.dropEffect = "copy";
            event.stopPropagation();
            event.preventDefault();
        },
        handleDrop: function(event) {
            event.stopPropagation();
            event.preventDefault();
            this.loadImagesFromFiles(event.dataTransfer.files);
        },
        handleFileInput: function(event) {
            this.loadImagesFromFiles(event.target.files);
        },
        loadImagesFromFiles: function(files) {
            const self = this;
            for (let file of files) {
                if (this.images.length < this.max) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function() {
                        self.images.push({ src: file, url: reader.result });
                        self.$emit(
                            "input",
                            self.images.map(function(image) {
                                return image.src;
                            })
                        );
                    };
                }
            }
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
    box-sizing: border-box;
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
}
.p-image-list {
    display: flex;
    width: 100%;
    height: 89px;
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
            width: 100%;
            height: 100%;
            border-radius: 4px;
            box-sizing: border-box;
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