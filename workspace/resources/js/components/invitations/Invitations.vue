<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <div class="headline ml-4">会のご案内</div>
                <v-divider></v-divider>
            </v-col>
            <v-col cols="12" md="6" v-for="invitation in invitations" :key="invitation._id">
                <invitation-item class="mx-auto mb-4" :invitation="invitation"></invitation-item>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import InvitationItem from "./InvitationItem";
export default {
    data: () => ({
        invitations_collection: [],
        invitations: []
    }),
    created() {
        this.invitations_collection.get().then(this.setData);
        this.unsubscribe = this.invitations_collection.onSnapshot(this.setData);
    },
    methods: {
        setData(snapshot) {
            this.invitations = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        }
    },
    destroyed() {
        this.unsubscribe();
    },
    components: {
        InvitationItem
    }
};
</script>
