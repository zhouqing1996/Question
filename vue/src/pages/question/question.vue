<template>
  <div >
    <el-container>
      <el-aside width="200px">
          <div class="aside">
            <el-menu
              class="el-menu-vertical-demo"
              >
              <div>
                <el-menu-item index="1">
                  <span slot="title" @click="Clickall" class="span"><i class="el-icon-menu">全部类型</i></span>
                </el-menu-item>
                <div v-for="(x,i) in typeList">
                  <el-menu-item :index="(i+2).toString()">
                    <span slot="title" @click="Click(x.id)" class="span">
                      <i class="el-icon-picture-outline-round">{{x.typename}}</i>
                    </span>
                  </el-menu-item>
                </div>
              </div>
            </el-menu>
          </div>
      </el-aside>
      <el-main :span="20">
        <div>
          <div class="meeting" >
            <el-input v-model="inputname" placeholder="模糊查找" size="mini"></el-input>
          </div>
          <button class="btn2 el-icon-search" v-on:click="Search">搜索问题</button>
          <router-link :to="{ name: 'Add' }">
            <button class="btn2 el-icon-circle-plus-outline">添加问题</button>
          </router-link>
        </div>
        <div >
          <div v-for="(x,i) in currentPageData" class="detail">
            <span class="typename">{{x.typename}}</span>
            <a @click="View(x.id,x.uid)" class="title">{{x.title}}</a>
            <p class="content">
              {{x.content}}
            </p>
            <br>
            <div>
              <img src="../../assets/avter.png" class="avter"/>{{x.uid}}
              <span class="time fr">{{x.ctime}}<span class="span1" @click="Delete(x.id)"><i class="el-icon-delete">删除</i></span></span>
            </div>
          </div>
        </div>
        <div class="page">
          <ul class="pagination pagination-sm"><!--分页-->
            <li class="page-item" v-if="currentPage!=1">
              <span class="page-link" v-on:click="prePage">上一页</span>
            </li>
            <li class="page-item" >
              <span class="page-link" >第{{ currentPage }}页/共{{totalPage}}页</span>
            </li>
            <li class="page-item" v-if="currentPage!=totalPage">
              <span class="page-link" v-on:click="nextPage">下一页</span>
            </li>
          </ul>
        </div>
      </el-main>
    </el-container>
  </div>
</template>

<script>
    export default {
        name: "question",
      data(){
          return{
            //数据返回
            inputname:'',
            questionList:[],
            userList:[],
            typeList:[],
            typeVis :true,
            // 翻页相关
            currentPage: 1,
            totalPage: 1,
            pageSize: 20,
            currentPageData:[]
          }
      },
      methods:{
          Delete:function(id){
            this.$confirm("是否删除该题目",{
              confirmButtonText:"确定",
              cancelButtonText:'取消',
              type:"warning"
            }).then(()=>{
              let that =this
              that.$http.post('/yii/question/index/delete',{
                qid:id
              }).then(function (res) {
                console.log(res.data)
                that.questionList =[]
                that.getList()
                alert(res.data.message)
              })
            }).catch(function (err) {
              console.log(err)
            })
          },
        //分页
        setCurrentPageDate: function () {
          let begin = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          this.currentPageData = this.questionList.slice(begin, end)
        },
        prePage() {
          console.log(this.currentPage)
          if (this.currentPage == 1)
            return
          this.currentPage--;
          this.setCurrentPageDate()
        },
        nextPage() {
          if (this.currentPage == this.totalPage) return
          this.currentPage++;
          this.setCurrentPageDate()
        },
          Clickall:function()
          {
            let that = this
            that.questionList =[]
            that.getList()
          },
          View:function(id,uid) {
            this.$router.push({
              path:'/question/view',
              query:{
                qid:id,
                uid:uid
              }
            })
          },
        Click:function(id){
          let that = this
          that.typeVis = false
          that.questionList=[]
          this.$http.post('/yii/question/index/query',{
            flag:4,
            id:id
          }).then(function (res) {
            console.log(res.data)
            let List = res.data.data
            for(let i=0;i<List.length;i++)
            {
              that.questionList.push({
                id:List[i].id,
                title:List[i].title,
                content:List[i].content,
                ctime:List[i].ctime,
                uid:that.getUserName(List[i].uid),
                typename: that.getTypeName(List[i].type)
              })
            }
            that.totalPage =Math.ceil(that.questionList.length/that.pageSize)
            that.totalPage=that.totalPage==0?1:that.totalPage
            that.setCurrentPageDate()
          }).catch(function (error) {
            console.log(error)
          })
        },
        Search:function() {
            this.$router.push({
              path:'/question/search',
              query:{
                search:this.inputname
              }
            })
          },
        getList:function () {
            let that =this
          that.questionList=[]
            this.$http.post('/yii/question/index/query',{
              flag:1
            }).then(function (res) {
              console.log(res.data)
              let List = res.data.data
              for(let i=0;i<List.length;i++)
              {
                  that.questionList.push({
                    id:List[i].id,
                    title:List[i].title,
                    content:that.escapeHTML(List[i].content),
                    ctime:List[i].ctime,
                    uid:that.getUserName(List[i].uid),
                    typename: that.getTypeName(List[i].type)
                  })
              }
              console.log(that.questionList)
              that.totalPage =Math.ceil(that.questionList.length/that.pageSize)
              that.totalPage=that.totalPage==0?1:that.totalPage
              that.setCurrentPageDate()
            }).catch(function (error) {
              console.log(error)
            })
          },
        escapeHTML:function(untrusted) {
      // Escape untrusted input so that it can safely be used in a HTML response
      // in HTML and in HTML attributes.
          return untrusted.replace(/<[^>]+>/g, '')
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
        getUser:function(){
          let that =this
          this.$http.post('/yii/home/user/query',{
            flag:2
          }).then(function (res) {
            console.log(res.data)
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
      },
      created(){
        this.getType()
        this.getUser()
        this.getList()
        console.log(this.typeList)
        console.log(this.questionList)

      }
    }
</script>

<style scoped>
  .aside{
    margin-top: 50px;
    margin-right: 0px;
    padding: 0;
    float: left;
    line-height: 30px;
    font-size: 14px;
    font-weight: bold;
  }
  .typename{
    color: #e33e33;
    background-color: rgba(227,62,51,0.1);
    display: inline-block;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 34px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    border-radius: 2px;
  }
  .detail {
    border-collapse: collapse;
    width: 80%;
    margin-top: 5px;
    table-layout: fixed;
    white-space:nowrap;
    overflow:hidden;
    text-overflow: ellipsis;
    padding: 5px;
    text-align: left;
    font-size: 18px;
    border-bottom: 1px solid #f0f2f5;
    position: relative;
  }
  .title{
    display: inline-block;
    font-size: 20px;
    color: #000;
    line-height: 30px;
    padding-bottom: 4px;
    font-weight: bold;
    padding-left: 36px;
  }
  .content{
    margin-top: 6px;
    font-size: 14px;
    line-height: 22px;
    white-space: normal;
    color: #999aaa;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }
  .title {
    font-size: 14px;
    color: #000;
    font-weight: bold;
  }
  .avter{
    display: block;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    -o-object-fit: cover;
    object-fit: cover;
    overflow: hidden;
  }
  .fr{
    float: right!important;
  }
  .time{
    font-size: 12px;
    color: #000;
  }
  .meeting{
    float:left;
    margin:14px 0 10px 0;
    font-weight: bold;
    background-color: #00AAFF;
    border:solid 1px #00AAFF;
    border-radius: 5px;
    width: 20%;
    padding:2px;
  }
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
  /*导航*/
  .span{
    width: 200px;
    padding: 7px;
    font-size: 14px;
    border-radius: 3px;
    border: none;
    color: white;
    background-color: deepskyblue;
    margin-left: 5px;
    margin-top: 17px;
    margin-bottom: 5px;
  }
  .span:hover{
    background-color: #5FA7FE;
  }
  /*删除*/
  .span1{
    width: 100px;
    padding: 7px;
    font-size: 14px;
    border-radius: 3px;
    border: none;
    color: white;
    background-color: gray;
    margin-left: 5px;
    margin-top: 17px;
    margin-bottom: 5px;
  }
  .span1:hover{
    background-color: #5FA7FE;
  }
  .span2{
    width: 50px;
    padding: 7px;
    font-size: 14px;
    background-color: sandybrown;
    margin-top: 15px;
    color: white;
    border: none;
    border-radius: 3px ;
  }
  li{list-style-type:none;}
  ul {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
  }
  ul li {
    list-style: none;
    text-align: center;
    line-height: 30px;
    padding: 10px;
    height: 30px;
    width: 100px;
    margin: 0 10px;
  }
</style>
