<template>
    <v-sheet @click="onClick" height="180" width="180" color="gray" :elevation="2">
        <v-img v-if="this.value" :src="'/api/images/' + this.value" aspect-ratio="1">
            <template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey"></v-progress-circular>
                </v-row>
            </template>
        </v-img>
        <v-icon v-else size="180">mdi-account</v-icon>
        <input v-show="false" @change="onFileChange" ref="input" type="file" accept="image/*" />
    </v-sheet>
</template>

<script>
import { axios } from "@/store";
export default {
    props: {
        value: {
            type: String,
            default: () => ""
        }
    },
    computed: {
        url() {
            return this.value || null || "/api/images" + this.value;
        }
    },
    methods: {
        test() {},
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