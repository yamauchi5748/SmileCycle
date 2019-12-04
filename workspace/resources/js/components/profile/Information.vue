<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <div class="headline ml-4">情報</div>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="ふりがな" label="ふりがな" readonly></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="090-0000-0000" label="電話番号" readonly></v-text-field>
                    </v-col>

                    <v-col cols="12">
                        <v-text-field value="a.a@a.a" label="メールアドレス" readonly></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <span class="headline ml-4">秘書</span>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="丸秘 守" label="氏名" readonly></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="secret_secret@s.s" label="メールアドレス" readonly></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <v-row>
                    <v-col cols="12">
                        <span class="headline ml-4">所属</span>
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="愛媛笑門会" label="部門" readonly></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="サンプルカンパニー" label="会社名" readonly></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field value="社長" label="役職" readonly></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {};
</script>

<style>
</style>