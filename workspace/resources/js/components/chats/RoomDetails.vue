<template>
    <div class="details">
        <div class="name">
            <slot></slot> 
        </div>
        <div class="contents">
            <div class="history">
                <ol>
                    <li>
                        <div class="content">
                            <div class="profile">
                                <img src="" alt="profile">
                            </div>
                            <div class="signature">
                                <span>myName</span>
                                <span>2019/10/10 01:10</span>
                            </div>
                            <div class="message">aaa</div>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="send-content">
                <div class="input-box">
                    <img src="" alt="動画像">
                    <textarea></textarea>
                    <img src="" alt="stamp" class="stamp">
                </div>
                <button class="normal-button">send</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["showDetais"]
}
</script>
<style lang="scss" scoped>
.details {
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
        height: 100%;
        flex-direction: column;
        position: relative;
        .history {
            width: 100%;
            height: 60%;
            overflow: scroll;
            ol {
                width: 100%;
                li {
                    width: 100%
                }
            }
        }
    }

}
.content {
    display: grid;
    grid-template-columns: 1fr 9fr;
    grid-template-rows: auto auto;
    width: 100%;
    background-color: #F2F2F2;
    .profile {
        grid-column: 1/1;
        grid-row: 1/1;
        margin:  0px;
        pading: 0px;
        background-color: red;
    }
    .signature {
        pading: 0px;
        margin: 0px;
        grid-column: 2/2;
        grid-row: 1/1;
    }
    .message {
       pading: 0px;
       margin: 0px;
       grid-column: 2/2;
       grid-row: 2/2
    }
}
.send-content {
    background-color: blue;
    position: absolute;
    top: 64%;
    height: 64px;
    width: 100%;
    display: flex;
    .input-box {
        display: flex;
        flex-grow: 9;
        margin: 0px;
        img {
            flex-grow: 1;
        }
        textarea {
            box-sizing: border-box;
            height: 100%;
            flex-grow: 8;
            font-size: 30px;;
        }
        .stamp {
            flex-grow: 1;
        }
        background-color: red;
    }
    .normal-button {
        flex-grow: 1;
        height: 100%;
    }
}
</style>
