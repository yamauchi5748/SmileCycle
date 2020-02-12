<template>
    <v-list-item v-if="3 <= Object.keys(content).length" class="d-block">
        <div class="mb-2">
            <v-avatar size="32" color="grey">
                <img :src="'/api/images/'+(content.avatar || 'iamtheavatar')" />
            </v-avatar>
            <span class="ml-2 subtitle-2">{{content.name}}</span>
            <span class="ml-4 caption">{{content.created_at | fromNow}}</span>
        </div>
        <p class="ml-10 d-flex">
            <span v-if="content.contentType==1" class="message-outer body-1 font-weight-light">
                <span class="message-decoration"></span>
                <span class="message-wrapper">{{content.message}}</span>
            </span>
            <span v-if="content.contentType==2" class="stamp">
                <v-img aspect-ratio="1" :src="'/api/images/'+content.stamp">
                    <template v-slot:placeholder>
                        <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-progress-circular indeterminate color="grey"></v-progress-circular>
                        </v-row>
                    </template>
                </v-img>
            </span>
            <v-img
                v-if="content.contentType==3"
                max-width="300"
                max-height="300"
                contain
                :src="'/api/images/'+content.image"
            >
                <template v-slot:placeholder>
                    <v-row class="fill-height ma-0" align="center" justify="center">
                        <v-progress-circular indeterminate color="grey"></v-progress-circular>
                    </v-row>
                </template>
            </v-img>
            <span class="d-flex flex-column justify-end ml-2">
                <span v-if="content.isHurry" class="red--text caption">急ぎ</span>
                <span
                    class="mt-auto grey--text caption"
                    v-show="content.alreadyReadCount"
                >既読{{content.alreadyReadCount-1}}</span>
            </span>
        </p>
    </v-list-item>
</template>

<script>
export default {
    props: {
        content: {
            type: Object,
            require: true
        }
    }
};
</script>

<style>
.stamp {
    display: block;
    width: 120px;
    height: 120px;
}
.message-outer {
    display: inline-block;
    position: relative;
    white-space: pre-line;
}
.message-wrapper {
    background-color: #ff9900;
    border-radius: 13px;
    display: inline-block;
    padding: 5px 10px;
    z-index: 3;
    position: relative;
    word-wrap: break-word;
    max-width: 300px;
}
.message-decoration {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    margin-left: -10px;
    margin-top: -10px;
    position: absolute;
    z-index: 1;
    background: radial-gradient(circle at 50% 0%, transparent 65%, #ff9900 65%);
}
</style>