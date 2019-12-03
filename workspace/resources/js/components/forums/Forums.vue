<template>
    <v-container>
        <forum-item
            class="mx-auto mb-4"
            v-for="forum in forums"
            :key="forum._id"
            :forum="forum"
            :max-width="300"
        ></forum-item>
    </v-container>
</template>

<script>
import axios from "axios";
import ForumItem from "./ForumItem";
export default {
    data: () => ({
        forums: []
    }),
    created() {
        this.initialize();
    },
    methods: {
        initialize() {
            // https://next.json-generator.com/api/json/get/EkR9sJSsv
            axios
                .get("https://next.json-generator.com/api/json/get/EkR9sJSsv")
                .then(response => {
                    this.forums = response.data;
                    this.loading = false;
                });
        }
    },
    components: { ForumItem }
};
</script>
