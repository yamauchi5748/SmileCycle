<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <div class="headline ml-4">会のご案内</div>
                <v-divider></v-divider>
            </v-col>
            <v-col v-if="invitations.length == 0" cols="12">投稿はありません。</v-col>
            <v-col v-else cols="12" md="6" v-for="invitation in invitations" :key="invitation.id">
                <invitation-item class="mx-auto mb-4" :invitation="invitation"></invitation-item>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { watch, auth } from "@/store";
import InvitationItem from "./InvitationItem";
export default {
    components: {
        InvitationItem
    },
    data: () => ({
        invitations: []
    }),
    created() {
        watch("invitations", this.invitations, {
            insert(array, change) {
                const { documentId, document } = change;
                if (
                    document.members.find(val => val == auth.user._id) ==
                    undefined
                ) {
                    return;
                }
                Object.defineProperty(document, "id", {
                    value: documentId,
                    writable: false
                });
                array.splice(0, 0, document);
            }
        });
    }
};
</script>
