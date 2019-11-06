<template>
  <div class="member">
          <p class="member_user_icon">
          <div>
            <Button
               class = "button"
               name="チャット画面"
                onclick="history.back()"
             />
            </div>
              <p class="member_user_icon">
                <img 
                :src="'/members/' + $route.params.id + '/profile-image'"
              >
              </p>
              <label>名前</label>
              <p class="profiledata">{{member.name}}</p>
              <label>ふりがな</label>
              <p class="profiledata">{{member.ruby}}</p>
              <label>部門</label>
              <p class="profiledata">{{member.department}}</p>
              <label>会社</label>
              <p class="profiledata">{{member.company}}</p>
              <label>役職</label>
              <p class="profiledata">{{member.post}}</p>
               <label>メールアドレス</label>
              <p class="profiledata">{{member.mail}}</p>
  </div>
</template>

<script>

import Button from "./Button";

export default {
  name: "app",
  components: {
    Button,
  },
   data() {
       return{
           keyword: '',
            member: [],
      }
  },
    created: function() {
        this.$root
            .getMember(this.$route.params.id)
            .then(function(res) {
                this.member = response.data.member;
            })
            .catch(function(error) {
                console.error(error);
            });
    },
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
    .button{
    margin-left : 85px ;
  }
   label
   {
    margin-left : 84px ;
    font-size: 22px;
   }
</style>