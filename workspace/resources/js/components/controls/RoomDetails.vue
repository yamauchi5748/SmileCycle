<template>
    <div class="details">
        <div class="name">
            <slot></slot> 
        </div>
        <div class="contents">
            <div class="history">
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["showDetais"]
}
</script>
<style lang="scss">
.details {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
    background-color: $base-color;
    height: 800px;
    div {
      margin: 0px;
      margin-top: 20px
    }
    .name {
        border-bottom: 1px solid #707070;
        display: flex;
        height: 48px;
        padding: 0 16px;
        justify-content: start;
        align-items: center;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        color: $black;
    }
    .history {
    }
}
</style>
