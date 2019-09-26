
<template>
<body>
  <div id="header">
  </div>
  <div class="members">
    <h1 class="member_deploy_name">愛媛笑門会</h1>
      <div class="member_user_icon">sample</div>
      <p class="member_user_name">小川知也</p>
      <p class="member_user_post">株式会社デイアイシステム</p>
      <p class="member_user_company">平社員</p>
  </div>
</body>
</template>
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
    margin-left : 11px ;
  }

  .member_user_name{
    height: 50px;
    margin-top : -50px ;
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
</style>