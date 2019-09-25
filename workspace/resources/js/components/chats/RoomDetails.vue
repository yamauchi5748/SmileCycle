<template>
    <div class="details">
        <div class="name">
            <slot></slot> 
        </div>
        <div class="contents">
            <div class="history">
                <div class="content">
                    <div class="profile"><img src="" alt="profile"></div>
                    <div class="message">
                        <span>myName</span>
                        <span>2019/10/10 01:10</span>
                        <p>aaa</p>
                    </div>
                </div>
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
        justify-content: flex-start;
        align-items: center;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        color: $black;
    }
    
    .contents {
        margin: 0 auto;
        width: 93%;
        display: flex;
        .history {
            display: flex;
            width: 100%;
            .content {
                display: flex;
                justify-content: flex-start;
                background-color: #F2F2F2;
                .profile {
                    background-color: red;
                }
            }
        }
    }

}
</style>
