<template>
  <div class="member">
      <div v-for="member_data in member" :key="member_data.id">
          <p class="member_user_icon">
              <img src=https://3.bp.blogspot.com/-ZWe9UUGMqDI/UylAX8vHpzI/AAAAAAAAeTE/ibSmOYMBp2A/s800/homeless_furousya.png>
              </p>
              <label>名前</label>
              <p class="profiledata">{{member_data.name}}</p>
              <label>ふりがな</label>
              <p class="profiledata">{{member_data.ruby}}</p>
              <label>部門</label>
              <p class="profiledata">{{member_data.department}}</p>
              <label>会社</label>
              <p class="profiledata">{{member_data.company}}</p>
              <label>役職</label>
              <p class="profiledata">{{member_data.post}}</p>
               <label>メールアドレス</label>
              <p class="profiledata">{{member_data.mail}}</p>
      </div>
  </div>
</template>

<script>

export default{
   data() {
       return{
           keyword: '',
            member: [
          　{ id: 1, icon: 'sample',
             name: '小川友也',
             ruby: 'おがわ　ともや', 
             post: '平社員',  
             company: '株式会社デイアイシステム',　
             department: '愛媛笑門会',
             mail: 'kbc16a01@stu.kawahara.ac.jp'}
            ]
      }
  }
}

</script>

<style lang="scss"　scoped>
.member {
    width: 1004px;
    height: 658px;
    margin-top : 70px ;
    display: table;
    vertical-align:top;
    margin-left: 7em;
    margin-bottom: 70px;
    box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
    background-color: #ffffff;
  }
.member_user_icon img{
    width: 190px;
    height: 190px;
    margin-top : 30px ;
    margin-left : 400px ;
  }
   .member_user_icon img{
    border-radius: 50px;
    height: 150px;
  }
  .profiledata
  {
    padding: 25px 54px;
    margin-top: 43px;
    margin-left : 84px ;
     margin-right : 84px ;
    margin-bottom : 83px;
    background-color: #f2f2f2;
    font-size: 20px;
   }
   label
   {
    margin-left : 84px ;
    font-size: 22px;
   }
</style>