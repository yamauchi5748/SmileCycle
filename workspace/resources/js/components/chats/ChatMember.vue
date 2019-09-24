<template>
    <div>
        <ol>
            <li v-on:click="getName">testMember</li>
            <li>testMember</li>
            <li>testMember</li>
            <li>testMember</li>
        </ol>
    </div>
</template>
<script>
export default {
    props: ["roomName", "showDetails"],
    methods: {
        getName(e) {
            this.$emit('setName', e.srcElement.innerHTML);
            
        }
    }
}
</script>
