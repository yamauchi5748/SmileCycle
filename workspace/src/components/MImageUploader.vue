<template>
    <v-btn color="primary" @click="onClick">
        画像のアップロード
        <input
            v-show="false"
            @change="onFileChange"
            ref="input"
            type="file"
            accept="image/*"
            multiple
        />
    </v-btn>
</template>

<script>
import { axios } from "@/store";
export default {
    props: {
        value: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        onClick() {
            this.$refs.input.value = null;
            this.$refs.input.click();
        },
        async onFileChange(event) {
            for (const file of event.target.files) {
                const formData = new FormData();
                formData.append("file", file);
                const config = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };
                axios.post("/images", formData, config).then(({ data }) => {
                    this.$emit("input", this.value.concat(data.name));
                });
            }
        }
    }
};
</script>

<style>
</style>