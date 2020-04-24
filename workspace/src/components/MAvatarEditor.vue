<template>
    <v-avatar size="164" @click="onClick">
        <v-img :src="'/api/images/' + avatar"></v-img>
        <input v-show="false" @change="onFileChange" ref="input" type="file" accept="image/*" />
    </v-avatar>
</template>

<script>
import { axios } from "@/store";
export default {
    props: {
        value: {
            type: String,
            default: "avatar"
        }
    },
    computed: {
        avatar() {
            return this.value || "avatar";
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
                    this.$emit("input", data.name);
                });
            }
        }
    }
};
</script>

<style>
</style>