<template>
    <v-select
        :label="label"
        v-model="selected"
        :items="companies"
        item-text="name"
        item-value="_id"
        :loading="loading"
    ></v-select>
</template>

<script>
export default {
    props: {
        label: String,
        value: String
    },
    data: () => ({
        loading: true,
        headers: [
            {
                text: "会員名",
                align: "left",
                sortable: true,
                value: "name"
            }
        ],
        companies_collection: [],
        companies: [],
        unsubscribe: null
    }),
    created() {
        this.companies_collection.get().then(snapshot => {
            this.setData(snapshot);
            this.loading = false;
        });
        this.unsubscribe = this.companies_collection.onSnapshot(this.setData);
    },
    computed: {
        selected: {
            get() {
                return this.value;
            },
            set(new_value) {
                this.$emit("input", new_value);
            }
        }
    },
    methods: {
        setData(snapshot) {
            this.companies = snapshot.docs.map(doc => ({
                ...doc.data(),
                _id: doc.id
            }));
        }
    },
    destroyed() {
        this.unsubscribe();
    }
};
</script>

<style>
</style>