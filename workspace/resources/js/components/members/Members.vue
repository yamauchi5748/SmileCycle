<template>
    <div class="members">
      <MembersSerch class="serch"></MembersSerch>
      <MembersTabMeny class="tab"></MembersTabMeny>
        <h2 class="member_deploy_name">愛媛笑門会</h2>
          <div v-for="member in members" :key="member.id">
            <div class="member_user_icon">
            　<img src=https://3.bp.blogspot.com/-ZWe9UUGMqDI/UylAX8vHpzI/AAAAAAAAeTE/ibSmOYMBp2A/s800/homeless_furousya.png>
            </div>
            <p class="member_user_name">{{member.name}}</p>
            <p class="member_user_post">{{member.post}}</p>
            <p class="member_user_company">{{member.company}}</p>
          </div>
    </div>
</template>

<script>
import MembersSerch from "./MembersSerche"
import MembersTabMenu from"./MembersTabMenu"

export default{
  name: "app",
  components: {
      MembersSerch,
      MembersTabMenu 
  },
   data() {
       return{
         members: [
           { id: 1, icon: 'sample', name: '小川友也', post: '平社員',  company: '株式会社デイアイシステム' },
           { id: 2, icon: 'sample', name: '木村祐太郎', post: 'ノージョブ',  company: 'なし' },
           { id: 3, icon: 'sample', name: '山口海都', post: '平社員',  company: '株式会社明光フォーラム' },
           { id: 4, icon: 'sample', name: '渡邊小輝', post: '平社員',  company: '株式会社セキ' },
         ]
       }
  }
/*
検索の処理（予定）opels

  computed: {
    filteredUsers: function() {
      for(var i in this.users) {
        var user = this.users[i];
      if(user.name.indexOf(this.keyword) !== -1) {
        this.users.push(user);
      }else{
         this.users.push(user);
      }
      }
    return this.users;
    */
}
</script>

<style lang="scss">
.members {
    width: 1004px;
    height: 658px;
    margin-top : 90px ;
    display: table;
    vertical-align:top;
    margin-left: 7em;
    margin-bottom: 70px;
    box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
    background-color: #ffffff;
  }
  .member_deploy_name{
    margin-left : 24px ;
    font-family: HiraKakuProN-W3;
    font-size: 60px;
    font-weight: normal;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.9;
    letter-spacing: normal;
    text-align: left;
    color: #f57d00;
    position: relative;
    overflow: hidden;
    padding: .9em;
  }
  .member_deploy_name::before,
  .member_deploy_name::after{
    content: "";
    position: absolute;
    bottom: 0;
  }
  .member_deploy_name:before{
    margin-left : -80px ;
    border-bottom: 1px solid #707070;
    width: 100%;
  }
  .member_user_icon {
    margin-top : 60px ;
    margin-left : 30px ;

  }
  .member_user_icon img{
      border-radius: 50px;
      height: 100px;
      width:  100px;
  }

  .member_user_name{
    height: 50px;
    margin-top : -100px ;
    margin-left : 170px ;
    vertical-align: middle;
    font-family: Roboto;
    font-size: 22px;
    font-weight: normal;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.32;
    letter-spacing: normal;
    text-align: left;
    color: #000000;
  }

  .member_user_post{
    margin-left : 180px ;
    font-family: Roboto;
    font-size: 20px;
    font-weight: normal;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.3;
    letter-spacing: normal;
    text-align: left;
    color: rgba(149, 149, 149, 0.87);
  }
  .member_user_company{
    margin-top : 20px ;
    margin-left : 180px ;
    margin-bottom: 30px;
    font-family: HiraKakuProN-W3;
    font-size: 20px;
    font-weight: normal;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.7;
    letter-spacing: normal;
    text-align: left;
    color: rgba(149, 149, 149, 0.87);
  }
  .tab{
     margin-top : 0px ;
    margin-left : 180px ;
    margin-bottom: 30px;
  }
   .serch{
    top: -70px;
    margin-left : 736px ;
    margin-bottom: 30px;
  }
</style>