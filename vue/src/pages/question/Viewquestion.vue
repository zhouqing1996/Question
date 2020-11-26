<template>
  <div>
    <el-aside :span="4"></el-aside>
    <el-main :span="16">
      <div class="waimian">
        <div class="back">
          <el-page-header @back="back">
          </el-page-header>
        </div>
        <br>
        <div class="wenti">
          <h3><span class="typename">{{qList.typename}}</span>      {{qList.title}}</h3>
          <span><i class="el-icon-user"></i> {{qList.username}}</span>
          <span><i class="el-icon-date"></i> {{qList.ctime}}</span>
          <hr>
          <div v-html="qList.content">
            {{qList.content}}
          </div>
        </div>
      </div>
    </el-main>

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
            // typeList:[],
            // userList:[]
          }
      },
      methods:{
        back:function()
        {
          this.$router.push({
            path:'/question',
          })
        },
        getList:function () {
          let that =this
          this.$http.post('/question/index/query',{
            flag:5,
            qid:that.qid,
          }).then(function (res) {
            console.log(res.data)
            let List = res.data.data[0]
            that.qList.id=List.id
            that.qList.title=List.title
            that.qList.content=List.content
            that.qList.ctime=List.ctime
            that.qList.username =List.username
            that.qList.uid=List.uid
            that.qList.type = List.type
            that.qList.typename= List.typename
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
          this.$http.post('/question/index/query',{
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
          this.$http.post('/home/user/query',{
            flag:2
          }).then(function (res) {
            that.userList = res.data.data
            console.log(that.userList)
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
        // this.getType()
        // this.getUser()
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
    margin-right: 40px;
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
