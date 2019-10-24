<template>
    <fieldset class="p-input-image">
        <legend class="p-title" v-if="$slots.default">
            <slot></slot>
        </legend>
        <div class="p-image-wrapper" @dragover="handleDragOver" @drop="handleDrop">
            <span class="p-image" v-show="dataURL" :style="{'background-image':'url('+dataURL+')'}">
                <button class="p-delete-button" @click="deleteImage"></button>
            </span>
        </div>
        <label class="p-add-image-label">
            <span class="p-add-image">画像を変更する</span>
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
        value: { type: [String, File] },
        prefix: { type: String }
    },
    data: function() {
        return {
            dataURL: this.value
        };
    },
    watch: {
        value: function(new_value) {
            if (typeof new_value == "string") {
                this.dataURL = this.prefix + new_value;
            }
        }
    },
    methods: {
        deleteImage() {
            this.dataURL = null;
            this.$emit("input", null);
        },
        handleDragOver(event) {
            event.dataTransfer.dropEffect = "copy";
            event.stopPropagation();
            event.preventDefault();
        },
        handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();
            this.loadImageFromFile(event.dataTransfer.files[0]);
        },
        handleFileInput(event) {
            this.loadImageFromFile(event.target.files[0]);
        },
        loadImageFromFile(file) {
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                this.dataURL = reader.result;
            };
            this.$emit("input", file);
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
.p-image-wrapper {
    position: relative;
    display: block;
    width: 124px;
    height: 124px;
    padding: 12px;
    border: solid 1px $gray;
    border-radius: 8px;
    background-repeat: no-repeat;
    background-position: center;
    background-color: rgba(248, 248, 248, 1);
    .p-image {
        display: block;
        height: 100%;
        width: 100%;
        border-radius: 4px;
        box-shadow: inset 0 0 0 1px rgba(28, 28, 29, 0.13);
        background-color: rgba(221, 221, 221, 1);
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;

        .p-delete-button {
            display: none;
            width: 20px;
            height: 20px;
            position: absolute;
            right: 12px;
            top: 12px;
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