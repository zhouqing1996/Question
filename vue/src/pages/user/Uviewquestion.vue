<template>
  <div>

    <div style="float:left;text-align: left">
      <div style="float: right">
        <button class="btn2 el-icon-search" v-on:click="back">返回</button>
      </div>
      <br>
      <h3>{{qList.title}}</h3>
      <span><i class="el-icon-user"></i> 问题创建人：{{qList.uid}}
        <i class="el-icon-s-flag"></i> 问题类型：{{qList.typename}}
        <i class="el-icon-date"></i> 创建时间：{{qList.ctime}}</span>
      <hr>
      <div v-html="qList.content">
        {{qList.content}}
      </div>
      <div>
        <button class="btn2 el-icon-search" v-on:click="back">返回</button>
      </div>
<!--      <span>{{qList[0].content}}</span>-->
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
          this.$http.post('/yii/question/index/uquery',{
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
          this.$http.post('/yii/question/index/query',{
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
          this.$http.post('/yii/home/user/queryrole3',{

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
  .btn2 {
    width: 100px;/*px*/
    padding: 7px;
    font-size: 14px;
    border-radius: 3px;
    border: none;
    color: white;
    background-color: #7F96FE;
    float: left;
    margin-left: 5px;
    margin-top: 17px;
    margin-bottom: 5px;
  }

  .btn2:hover {
    background-color: #5FA7FE;
  }
</style>
