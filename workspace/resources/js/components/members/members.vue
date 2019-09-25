
<template>
<body>
  <div id="header">
  </div>
  <div class="members">
    <h1 class="member_deploy_name"></h1>
      <div class="member_user_icon"></div>
        <img src="">
      <li class=member_"user_name"></li>
      <li class="member_user_post"></li>
      <l1 class="member_user_company"></l1>
  </div>
</body>
</template>

<script>
  var demo = new user_date({
    el: '#demo',
    user_date:{
      items:[
        {deploy_name:'愛媛笑門会', user_name: '小川知也',
         user_post: '平社員', user_company:'株式会社デイアイシステム'}
      ]
    }
  })
</script>
<style lang="scss">
.members {
    width: 1004px;
    height: 658px;
    margin-top : 70px ;
    display: table;
    vertical-align:top;
    margin-left: 7em;
    box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
    background-color: #ffffff;

    .members_deploy_name{
      .members_deploy_name::before,
      .members_deploy_name::after{
        content: "";
        position: absolute;
        bottom: 0;
      }
    }
    .member_deploy_name:before{
        width: 1004px;
        height: 4px;
        margin-top : 120px ;
        margin-left : -100px ;
        border-bottom: 1px solid #707070;
        width: 100%;
    }
    .member_user_icon{
      margin-top : 60px ;
      margin-left : 11px ;
    }
    .member_user_name{
        height: 40px;
        margin-top : -140px ;
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
    .member_user_company{
        width: 256px;
        height: 20px;
        margin-top : 20px ;
        margin-left : 180px ;
        font-family: Roboto;
        font-size: 20px;
        font-weight: normal;
        font-style: normal;
        font-stretch: normal;
        line-height: 1.7;
        letter-spacing: normal;
        text-align: left;
        color: rgba(149, 149, 149, 0.87);
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
  }
</style>