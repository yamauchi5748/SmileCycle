<template>
    <v-data-iterator
        :items="timelines"
        :items-per-page.sync="itemsPerPage"
        :footer-props="{ itemsPerPageOptions }"
    >
        <template v-slot:default="props">
            <v-container>
                <v-row>
                    <v-col v-for="item in props.items" :key="item.id" cols="12" sm="6" md="4">
                        <v-card>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="headline">{{item.title}}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-carousel
                                v-if="item.images.length > 0"
                                height="180"
                                show-arrows-on-hover
                                hide-delimiter-background
                                color="grey"
                            >
                                <v-carousel-item
                                    v-for="name in item.images"
                                    :key="name"
                                    :src="'/api/images/'+name"
                                    contain
                                ></v-carousel-item>
                            </v-carousel>
                            <v-card-text class="font-regular black--text">{{item.text}}</v-card-text>
                            <div
                                class="mx-4 text-right caption grey--text"
                            >{{item.created_at | fromNow}}</div>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </template>
    </v-data-iterator>
</template>

<script>
import { watch, auth } from "@/store";
export default {
    data: () => ({
        itemsPerPageOptions: [4, 8, 12],
        itemsPerPage: 4,
        watch,
        timelines: []
    }),
    created() {
        watch("timelines", this.timelines, {
            url: "/me/timelines",
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

<style>
</style>