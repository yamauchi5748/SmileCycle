<<template>
  <div class="component">
    <MembersTabMenu　
      class="tabitem"
      v-for="Department in Department_list"
      v-bind="Department" :key="Department.id"
      @click="event"
      v-model="currentId"
    />
    <MembersSerch 
    class="serch"
    placeholder="会員名または会社名を検索してください"
    name="sample-input"
    type="text"
    v-model="keyword"
  />
    <div class="members_list">
      <h2 class="member_deploy_name">愛媛笑門会</h2>
      <div v-for="member in $root.member_list" :key="member.id">
        <p class="member_user_icon">
          <img src=https://3.bp.blogspot.com/-ZWe9UUGMqDI/UylAX8vHpzI/AAAAAAAAeTE/ibSmOYMBp2A/s800/homeless_furousya.png>
          </p>
          <p class="member_user_name">{{member.name}}</p>
          <p class="member_user_post">{{member.post}}</p>
          </div>
      </div>
  </div>
</template>

<script>
import MembersSerch from "./MembersSerche";
import MembersTabMenu from "./MembersTabMenu";
export default {
  name: "app",
  components: {
    MembersSerch,
    MembersTabMenu,
  },
    data() {
       return{
           keyword: '',
           currentId: 1,
            users: [
          　{ id: 1, icon: 'sample', name: '小川友也', post: '平社員',  company: '株式会社デイアイシステム',　department: '愛媛笑門会'},
          　{ id: 2, icon: 'sample', name: '木村祐太郎', post: 'ノージョブ',  company: 'なし' ,　department: '大阪笑門会'},
          　{ id: 3, icon: 'sample', name: '山口海都', post: '平社員',  company: '株式会社明光フォーラム' ,　department: '鎌倉笑門会'},
          　{ id: 4, icon: 'sample', name: '渡邊小輝', post: '平社員',  company: '株式会社セキ',　department: '東京笑門会' },
            ],
            Department_list: [
            { id: 1, name: '愛媛笑門会'},
            { id: 2, name: '東京笑門会'},
            { id: 3, name: '大阪笑門会'},
            { id: 4, name: '鎌倉笑門会'}
            ]
      }
  },
  created: function() {
        this.$root.loadMembers();
    },
   computed: {
            filteredUsers: function() {
                var users = [];
                for(var i in this.users) {
                    var user = this.users[i];
                    if(user.department.indexOf(this.currentId) !== -1　||
                      user.name.indexOf(this.keyword) !== -1 ||
                        user.company.indexOf(this.keyword) !== -1
                        ) {
                        users.push(user);
                    }
                }
                return users;
            }
          }
}
</script>

<style lang="scss">
.component{
    margin-left: 7em;
    margin-right: 7em;

}

  .serch{
    margin-top: 30px;
    margin-bottom: 10px;
    margin-left : 180px ;
  }
.members {
  width: 1004px;
  height: 658px;
  margin-top: 90px;
  display: table;
  vertical-align: top;
  margin-left: 7em;
  margin-bottom: 70px;
  background-color: #ffffff;
}
.member_deploy_name {
  margin-left: 24px;
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
  padding: 0.9em;
}
.member_deploy_name::before,
.member_deploy_name::after {
  content: "";
  position: absolute;
  bottom: 0;
}
.member_deploy_name:before {
  margin-left: -80px;
  border-bottom: 1px solid #707070;
  width: 100%;
}
.member_user_icon {
  margin-top: 60px;
  margin-left: 30px;
}
.member_user_icon img {
  border-radius: 50px;
  height: 100px;
  width: 100px;
}

.member_user_name {
  height: 50px;
  margin-top: -100px;
  margin-left: 170px;
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

.member_user_post {
  margin-left: 180px;
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

</style>