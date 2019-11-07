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
                        <router-view v-bind:roomName="roomName" v-on:setName="setName"></router-view>
                    </div>
                   <button class="add-button" v-on:click="createGroup"><img src="/img/add-button.png" alt="button"></button>
                </div>
            </div>
            <router-view name="details" v-bind:showDetails="showDetails" v-if="showDetails === true">
                <h1>{{ roomName }}</h1>
            </router-view>
            <div class="create-group-modal" v-if="showCreateGroupModal">
                <div>
                    <div class="modal-header">
                        <span class="title">グループ作成</span>
                        <button class="close" v-on:click="hiddenCreateGroupModal">×</button>
                    </div>
                    <div class="input-group-name">
                        <input type="text" placeholder="グループ名を入力してください。">
                    </div>
                </div>
                <div class="modal-button">
                    <button class="normal-button">作成</button>
                    <button class="flat-button" v-on:click="hiddenCreateGroupModal">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            type:  "group",
            roomName: "",
            showDetails: false,
            showCreateGroupModal: false
        };
    },
    methods: {
        isGroup() {
            this.type = "group";
        },
        isMember() {
            this.type = "member";
        },
        setName(name) {
            this.roomName = name;
            this.showDetails = true;
        },
        createGroup() {
            this.showCreateGroupModal = true;
        },
        hiddenCreateGroupModal () {
            this.showCreateGroupModal = false;
        }
    },
};
</script>
<style lang="scss">
.chat {
    overflow: hidden;
}

.controls-body {
    display: flex;
    justify-content: flex-start;
    position: relative;
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

.create-group-modal {
   display: flex;
   width: 455px;
   height: 249px;
   flex-direction: column;
   border: 1px solid #707070;
   position: absolute;
   top: 30%;
   left: 29%;
   background-color: $base-color;
   border-radius: 22px;
   justify-content: space-around;
    
   div {
      flex-direction: column;
      height: 45%;
      margin: 10px;
   }

    .modal-header {
        display: flex;
        justify-content: space-around;
        flex-direction: row;
        font-size: 16px;
        font-weight: bold;
        border-bottom: 1px solid #707070;
        
        .title {
            flex: 8;
            line-height: 40px;
        }
        .close {
            flex: 1;
            font-weight: bold;
        }


    }
    .input-group-name {
        margin-top: 20px;
        input {
            height: 20px;
            width: 100%;
            border: none;
            border-bottom: 1px solid #707070;
       }
   }
   .modal-button {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      padding: 10px;
      align-items: flex-end;
      .normal-button {
      }
      .flat-button {
      }
   }
}
</style>
