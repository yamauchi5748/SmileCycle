<template>
    <v-data-iterator
        :items="items"
        :items-per-page.sync="itemsPerPage"
        :footer-props="{ itemsPerPageOptions }"
    >
        <template v-slot:default="props">
            <v-row class="px-6">
                <v-col v-for="item in props.items" :key="item.name" cols="12" sm="6" md="4" lg="3">
                    <v-card>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="headline">タイトル</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-carousel height="180" show-arrows-on-hover color="grey">
                            <v-carousel-item
                                v-for="n in 4"
                                :key="n"
                                src="https://picsum.photos/200/300"
                                contain
                            ></v-carousel-item>
                        </v-carousel>
                        <v-card-text class="font-regular black--text">本文</v-card-text>
                        <div class="mx-4 text-right caption grey--text">{{new Date()}}</div>
                        <v-divider></v-divider>
                    </v-card>
                </v-col>
            </v-row>
        </template>
    </v-data-iterator>
</template>

<script>
export default {
    data: () => ({
        itemsPerPageOptions: [4, 8, 12],
        itemsPerPage: 4,
        items: [
            {
                name: "Frozen Yogurt",
                calories: 159,
                fat: 6.0,
                carbs: 24,
                protein: 4.0,
                sodium: 87,
                calcium: "14%",
                iron: "1%"
            },
            {
                name: "Ice cream sandwich",
                calories: 237,
                fat: 9.0,
                carbs: 37,
                protein: 4.3,
                sodium: 129,
                calcium: "8%",
                iron: "1%"
            },
            {
                name: "Eclair",
                calories: 262,
                fat: 16.0,
                carbs: 23,
                protein: 6.0,
                sodium: 337,
                calcium: "6%",
                iron: "7%"
            },
            {
                name: "Cupcake",
                calories: 305,
                fat: 3.7,
                carbs: 67,
                protein: 4.3,
                sodium: 413,
                calcium: "3%",
                iron: "8%"
            },
            {
                name: "Gingerbread",
                calories: 356,
                fat: 16.0,
                carbs: 49,
                protein: 3.9,
                sodium: 327,
                calcium: "7%",
                iron: "16%"
            },
            {
                name: "Jelly bean",
                calories: 375,
                fat: 0.0,
                carbs: 94,
                protein: 0.0,
                sodium: 50,
                calcium: "0%",
                iron: "0%"
            },
            {
                name: "Lollipop",
                calories: 392,
                fat: 0.2,
                carbs: 98,
                protein: 0,
                sodium: 38,
                calcium: "0%",
                iron: "2%"
            },
            {
                name: "Honeycomb",
                calories: 408,
                fat: 3.2,
                carbs: 87,
                protein: 6.5,
                sodium: 562,
                calcium: "0%",
                iron: "45%"
            },
            {
                name: "Donut",
                calories: 452,
                fat: 25.0,
                carbs: 51,
                protein: 4.9,
                sodium: 326,
                calcium: "2%",
                iron: "22%"
            },
            {
                name: "KitKat",
                calories: 518,
                fat: 26.0,
                carbs: 65,
                protein: 7,
                sodium: 54,
                calcium: "12%",
                iron: "6%"
            }
        ]
    })
};
</script>

<style>
</style>