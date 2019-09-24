<template>
    <div>
        <ol>
            <li v-on:click="getName">testname</li><div class="unread"></div>
            <li>testname</li><div class="unread"></div>
            <li>testname</li><div class="unread"></div>
            <li>testname</li><div class="unread"></div>
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
