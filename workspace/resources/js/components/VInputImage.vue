<template>
    <fieldset>
        <legend class="p-title" v-if="$slots.default">
            <slot></slot>
        </legend>
        <div class="p-image-list-outer">
            <button class="slide-left-button"></button>
            <div class="p-image-list-wrapper">
                <div class="p-image-list-inner">
                    <ul class="p-image-list" @dragover="handleDragOver" @drop="handleDrop">
                        <li
                            class="p-image-wrapper"
                            v-for="(dataURL, index) in dataURL_list"
                            :key="index"
                        >
                            <button class="p-delete-button"></button>
                            <span class="p-image" :style="{'background-image':'url('+dataURL+')'}"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <button class="slide-right-button"></button>
        </div>
        <label class="p-add-image-label">
            <span class="p-add-image">画像を追加する</span>
            <input class="p-add-image-input" type="file" accept="image/png, image/jpeg" />
        </label>
    </fieldset>
</template>

<script>
export default {
    props: {
        value: { type: Array, required: true },
        only: { type: Boolean, default: false }
    },
    data: function() {
        return {
            dataURL_list: [
                "/img/profile_image.jpg",
                "/img/invitation-post-image.jpg",
                "/img/profile_image.jpg",
                "/img/profile_image.jpg",
                "/img/invitation-post-image.jpg",
                "/img/profile_image.jpg",
                "/img/invitation-post-image.jpg"
            ]
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
.p-image-list-outer {
    position: relative;
    display: inline-block;
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
        box-shadow:0 0 5px rgba(28, 28, 29, 0.45);
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
.p-image-list-wrapper {
    display: inline-block;
    border: solid 1px $gray;
    border-radius: 8px;
    background-repeat: no-repeat;
    background-position: center;
    background-color: rgba(248, 248, 248, 1);
    //スクロールバーなしでスクロールするための
    height: 86px;
    overflow-x: hidden;
    overflow-y: hidden;
}
.p-image-list-inner {
    display: block;
    width: 470px;
    //スクロールバーなしでスクロールするための
    height: calc(100%+17px);
    padding-bottom: -17px;
    overflow-x: scroll;
}
.p-image-list {
    display: inline-flex;
    padding: 12px;
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
.p-title {
    display: inline-flex;
    margin-bottom: 12px;
    font-size: 14px;
    font-weight: bold;
}
</style>