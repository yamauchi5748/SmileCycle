<template>
    <v-app>
        <v-content>
            <div class="fill-height d-flex justify-center align-center">
                <v-container>
                    <v-row>
                        <v-col cols="12" md="6">
                            <h1 class="text-center">このページは存在しません。</h1>
                        </v-col>
                        <v-col cols="12" md="6">
                            <div class="display-4 text-center">404</div>
                        </v-col>
                        <v-col cols="12" class="text-center mt-6">
                            <v-btn outlined color="accent" exact :to="{name:'main'}">Topページに戻る</v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
        </v-content>
    </v-app>
</template>

<script>
export default {};
</script>

<style>
</style>