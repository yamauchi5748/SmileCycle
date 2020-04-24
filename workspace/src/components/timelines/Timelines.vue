<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-row>
                    <div class="headline ml-4">タイムライン</div>
                    <v-spacer></v-spacer>
                    <v-btn color="accent" @click="controlEditor('createItem')">投稿</v-btn>
                </v-row>
                <MTimelineEditor ref="editor"></MTimelineEditor>
                <v-divider></v-divider>
            </v-col>
            <v-col v-if="timelines.length == 0" cols="12">投稿はありません。</v-col>
            <v-col cols="12" md="6" v-for="timeline in timelines" :key="timeline.id">
                <TimelineItem :timeline="timeline"></TimelineItem>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { watch } from "@/store";
import TimelineItem from "@/components/timelines/TimelineItem";
import MTimelineEditor from "@/components/MTimelineEditor";
export default {
    components: {
        TimelineItem,
        MTimelineEditor
    },
    data: () => ({
        timelines: []
    }),
    created() {
        watch("timelines", this.timelines);
    },
    methods: {
        controlEditor(action, ...value) {
            this.$refs.editor[action](...value);
        }
    }
};
</script>
