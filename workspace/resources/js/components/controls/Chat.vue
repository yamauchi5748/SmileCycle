<template>
    <div class="chat">
        <div class="controls-body">
            <div class="room-list">
                <div class="type-tab">
                    <router-link :to="{name:'chat-group'}" class="tab-link" exact-active-class="active" @click.native="isGroup">グループ</router-link>
                    <router-link :to="{name:'chat-member'}" class="tab-link" exact-active-class="active" @click.native="isMember">会員</router-link>
                </div>
                <div>
                    <div class="search-box">
                        <img src="/img/search-icon.png" alt="検索アイコン">
                        <input type="text" v-if="type === 'group'"  placeholder="グループ名検索">
                        <input type="text" v-if="type === 'member'"  placeholder="会員名検索">
                    </div>
                    <div class="room">
                        <router-view></router-view>
                    </div>
                   <button class="add-button"><img src="/img/add-button.png" alt="button"></button>
                </div>
            </div>
            <div class="details">
                <router-view name="details"></router-view>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            type:  "group",
            roomName: ""
        };
    },
    methods: {
        isGroup() {
            this.type = "group";
        },
        isMember() {
            this.type = "member";
        }
    }
};
</script>
<style lang="scss">
.chat {
}

.controls-body {
    display: flex;
    justify-content: start;
}

.room-list {
    display: flex;
    flex-direction: column;
    background-color: rgba($sub-color, 0.45);
    height: 800px;
    width: 349.95px;
    div {
        margin: 0 auto;
        margin-top: 20px;
        width: 330px;
        .add-button { 
           float: right;
           img {
               user-select: none;
           } 
        }
    }
}

.type-tab {
    display: flex;
    border-bottom: 1px solid #707070;
    justify-content: space-around;
    .tab-link {
        display: flex;
        height: 48px;
        padding: 0 16px;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        color: $black;
        &.active {
            color: $accent-color;
        }
    }
}

.search-box {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 40px;
    background-color: $base-color;
    border: 1px solid #707070;
    img {
        display: flex;
        margin: 0 auto;
        height: 18px;
    }
    input {
        flex-grow: 1;
        height: 100%;
        background-color: rgba(0, 0, 0, 0);
        border: none;
        outline: none;
    }
}

.room {
    display: flex;
    ol {
        display: flex;
        width: 100%;
        flex-direction: column;
        .profile {
            float: left;
        }
        li {
            display: flex;
            border-bottom: 1px solid #707070;
            font-size: 16px;
            margin-bottom: 40px;
        }
    }
}

.details {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
    background-color: $base-color;
    height: 800px;
}
</style>
