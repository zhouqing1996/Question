<template>
  <div>

    <div class="waimian">
      <div class="back">
        <el-page-header @back="back">
        </el-page-header>
      </div>
      <br>
      <div class="wenti">
        <h3><span class="typename">{{qList.typename}}</span>      {{qList.title}}</h3>
        <span><i class="el-icon-user"></i></span>
        <span><i class="el-icon-date"></i> {{qList.ctime}}</span>
        <hr>
        <div v-html="qList.content">
          {{qList.content}}
        </div>
      </div>
    </div>

  </div>
</template>

<script>
    export default {
        name: "Viewquestion",
      data(){
          return{
            qid:'',
            uid:'',
            qList: {
              id:'',
              title:'',
              content:'',
              ctime:'',
              uid:'',
              typename:''
            },
            typeList:[],
            userList:[]
          }
      },
      methods:{
        back:function()
        {
          this.$router.push({
            path:'/u/question',
          })
        },
        getList:function () {
          let that =this
          this.$http.post('http://120.78.150.89/Question/Yii/backend/web/index.php/question/index/uquery',{
            flag:5,
            qid:that.qid,
            uid:that.uid
          }).then(function (res) {
            console.log(res.data)
            let List = res.data.data[0]
            that.qList.id=List.id
            that.qList.title=List.title
            that.qList.content=List.content
            that.qList.ctime=List.ctime
            that.qList.uid=that.getUserName(List.uid)
            that.qList.typename= that.getTypeName(List.type)
            console.log(that.qList)
          }).catch(function (error) {
            console.log(error)
          })
        },
        escapeHTML:function(untrusted) {
      // Escape untrusted input so that it can safely be used in a HTML response
      // in HTML and in HTML attributes.
      return untrusted
        .replace(/&/g, '&')
        .replace(/</g, '<')
        .replace(/>/g, '>')
        .replace(/"/g, '"')
        .replace(/'/g, '\'');
    },
        getType:function () {
          let that =this
          this.$http.post('http://120.78.150.89/Question/Yii/backend/web/index.php/question/index/query',{
            flag:2
          }).then(function (res) {
            console.log(res.data)
            that.typeList = res.data.data
            console.log(that.typeList)
          }).catch(function (error) {
            console.log(error)
          })
        },
        getUser:function(){
          let that =this
          this.$http.post('http://120.78.150.89/Question/Yii/backend/web/index.php/home/user/query',{
            flag:2
          }).then(function (res) {
            that.userList = res.data.data
          })
        },
        getUserName:function(id){
          let that =this
          for(let k=0;k<that.userList.length;k++)
          {
            if(id==that.userList[k].id)
            {
              return that.userList[k].username
            }
          }
        },
        getTypeName:function (id) {
          let that = this
          for(let j=0;j<that.typeList.length;j++)
          {
            if(id == that.typeList[j].id)
            {
              return that.typeList[j].typename
            }
          }
        },
      },
      created(){
          this.qid = this.$route.query.qid
        this.uid =this.$route.query.uid
        this.getType()
        this.getUser()
        this.getList()
      }

    }
</script>

<style scoped>
  .back{
    margin-top: 30px;
    margin-bottom: 20px;
  }
  .waimian{
    margin-top: 10px;
    padding: 10px;
    background-color: aliceblue;
    margin-left: 20px;
    margin-right: 20px;
    border: white;
    width: auto;
  }
  .wenti{
    margin-top: 20px;
    margin-left: 20px;
    margin-right: 20px;
    height: auto;
    text-align: left;
  }
  .typename{
    color: #e33e33;
    background-color: rgba(227,62,51,0.1);
    display: inline-block;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: auto;
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    border-radius: 2px;
  }
</style>
