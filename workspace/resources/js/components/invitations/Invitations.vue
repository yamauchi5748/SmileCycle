<template>
    <v-container>
        <invitation-item
            class="mx-auto mb-4"
            v-for="invitation in invitations"
            :key="invitation._id"
            :invitation="invitation"
            :max-width="300"
        ></invitation-item>
    </v-container>
</template>

<script>
import axios from "axios";
import InvitationItem from "./InvitationItem";
export default {
    data: () => ({
        invitations: []
    }),
    created() {
        this.initialize();
    },
    methods: {
        initialize() {
            // https://next.json-generator.com/api/json/get/VysGuyBiw
            axios
                .get("https://next.json-generator.com/api/json/get/VysGuyBiw")
                .then(response => {
                    this.invitations = response.data;
                    this.loading = false;
                });
        }
    },
    components: { InvitationItem }
};
</script>
