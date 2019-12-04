<template>
    <v-select
        :label="label"
        v-model="selected"
        :items="members"
        item-text="name"
        item-value="_id"
        multiple
        chips
        :return-object="returnObject"
        :loading="loading"
    ></v-select>
</template>

<script>
export default {
    props: {
        label: String,
        value: Array,
        returnObject: Boolean
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
        members_collection: [],
        members: [],
        unsubscribe: null
    }),
    created() {
        this.members_collection.get().then(snapshot => {
            this.setData(snapshot);
            this.loading = false;
        });
        this.unsubscribe = this.members_collection.onSnapshot(this.setData);
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
            this.members = snapshot.docs
                .map(doc => ({
                    ...doc.data(),
                    _id: doc.id
                }))
                .map(({ _id, name, ruby }) => ({
                    _id,
                    name,
                    ruby,
                    status: 0
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