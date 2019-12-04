<template>
    <v-list-item v-if="!content.is_none" class="d-block">
        <div class="mb-2">
            <v-avatar size="32" color="grey">
                <img :src="'/members/' + content.sender_id + '/profile-image'" />
            </v-avatar>
            <span class="ml-2 subtitle-2">{{content.sender_name}}</span>
            <span class="ml-4 caption">{{content.created_at | date_format}}</span>
        </div>
        <p
            v-if="content.content_type=='1'"
            class="ml-10 body-1 font-weight-light"
        >{{content.message}}</p>
        <p v-else-if="content.content_type=='2'" class="ml-10">
            <v-img
                width="120"
                height="120"
                contain
                :src="'/stamp-images/' + content.stamp_id"
            ></v-img>
        </p>
        <p v-else-if="content.content_type=='3'" class="ml-10">
            <v-img
                width="300"
                height="300"
                contain
                :src="'/chat-rooms/' + $route.params.id + '/images/' + content.content_id"
            ></v-img>
        </p>
    </v-list-item>
</template>

<script>
export default {
    props: {
        content: Object
    }
};
</script>

<style>
</style>