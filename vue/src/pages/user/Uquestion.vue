<template>
  <div >
    <el-container>
      <el-aside :span="4">
        <div class="aside">
          <table>
            <tr >
              <td @click="Clickall">
                <a><i class="el-icon-menu">全部类型</i></a>
              </td>
            </tr>
            <tr v-for="(x,i) in typeList" name="title">
              <td slot="title" @click="Click(x.id)">
               <a><i class="el-icon-picture-outline-round">{{x.typename}}</i></a>
              </td>
            </tr>
          </table>
        </div>
      </el-aside>
      <el-main :span="16">
        <div>
          <div class="meeting" >
            <el-input v-model="inputname" placeholder="模糊查找" size="mini"></el-input>
          </div>
          <button class="btn2 el-icon-search" v-on:click="Search">搜索问题</button>
          <router-link :to="{ name: 'Uadd' }">
            <button class="btn2 el-icon-circle-plus-outline">添加问题</button>
          </router-link>
        </div>
        <div v-if="currentPageData.length>0" >
          <div v-for="(x,i) in currentPageData" class="detail">
            <div @click="View(x.id,x.uid)" >
              <span class="typename">{{x.typename}}</span>
              <span class="title">{{x.title}}</span>
              <div v-html="x.content" class="content">
                {{x.content}}
              </div>
            </div>
            <br>
            <div>
              <img src="../../assets/avter.png" class="avter"/>
              <span class="time fr">{{x.ctime}}<span class="span1" @click="Delete(x.id)"><i class="el-icon-delete">删除</i></span></span>
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
        </div>
        <div v-else class="detail">
          <br>
          <span style="color: red;">暂无数据!</span>
        </div>

      </el-main>
      <el-aside :span="4">
        <div>
          <div class="personalData" @click="personalData" >
            <img src="../../assets/tongji.png" style="width: 50px;height: 50px;"/>
            个人问题数据分析结果
          </div>
          <div class="allData" @click="allData">
            <img src="../../assets/web.png" style="width: 50px;height: 50px;"/>
            查看全站问题数据
          </div>
        </div>
      </el-aside>
    </el-container>
  </div>
</template>

<script>
  export default {
    name: "Uquestion",
    data(){
      return{
        //数据返回
        inputname:'',
        questionList:[],
        typeList:[],
        uid:'',
        // 翻页相关
        currentPage: 1,
        totalPage: 1,
        pageSize: 20,
        currentPageData:[]
      }
    },
    methods:{
      personalData:function(){
        this.$router.push({
          path:'/u/panalyse'
        })
      },
      allData:function(){
        this.$router.push({
          path:'/u/viewall'
        })
      },
      Delete:function(id){
        this.$confirm("是否删除该题目",{
          confirmButtonText:"确定",
          cancelButtonText:'取消',
          type:"warning"
        }).then(()=>{
          let that =this
          that.$http.post('/question/index/udelete',{
            qid:id,
            uid:that.uid
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
          path:'/u/viewquestion',
          query:{
            qid:id,
            uid:uid
          }
        })
      },
      Click:function(id){
        let that = this
        that.questionList=[]
        this.$http.post('/question/index/uquery',{
          flag:4,
          id:id,
          uid:that.uid
        }).then(function (res) {
          console.log(res.data)
          console.log(id)
          that.getType()
          let List = res.data.data
          for(let i=0;i<List.length;i++)
          {
            that.questionList.push({
              id:List[i].id,
              title:List[i].title,
              content:List[i].content,
              ctime:List[i].ctime,
              uid:List[i].uid,
              username:List[i].username,
              type: List[i].type,
              typename:List[i].typename
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
      Search:function() {
        if(this.inputname.length==0)
        {
          this.$alert('内容为空', '警告', {
            confirmButtonText: '确定',})
        }
        else{
          this.$router.push({
            path:'/u/search',
            query:{
              search:this.inputname
            }
          })
        }
      },
      getList:function () {
        let that =this
        this.$http.post('/question/index/uquery',{
          flag:1,
          uid:that.uid
        }).then(function (res) {
          console.log(res.data)
          that.getType()
          that.questionList=[]
          let List = res.data.data
          for(let i=0;i<List.length;i++)
          {
            that.questionList.push({
              id:List[i].id,
              title:List[i].title,
              content:List[i].content,
              ctime:List[i].ctime,
              uid:List[i].uid,
              username:List[i].username,
              type: List[i].type,
              typename:List[i].typename
            })
          }
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
        this.$http.post('/question/index/uquery',{
          flag:2,
          uid:this.uid
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
    },
    created(){
      this.questionList=[]
      this.uid = this.$store.getters.getsId
      console.log(this.uid)
      this.getType()
      this.getList()
      console.log(this.questionList)
      console.log(this.typeList)
    }
  }
</script>

<style scoped>
  .page{
    margin-top: 50px;
    position: relative;
    bottom: 0;
    width: 100%;
    text-align: center;
    height: 30px;/*脚部的高度*/
    clear:both;
  }
  .personalData{
    width: auto;
    height: 100px;
    color: #FFF;
    background-color: #FFCC66;
    font-size: large;
    font-weight: bold;
    text-align: center;
    margin-top: 50px;
    margin-right: 20px;
    padding: 20px;
    border-radius: 20px;
    vertical-align: middle;
  }
  .allData{
    width: auto;
    height: 100px;
    color: #FFF;
    background-color:lightblue;
    font-size: large;
    font-weight: bold;
    text-align: center;
    margin-top: 50px;
    margin-right: 20px;
    padding: 20px;
    border-radius: 20px;
  }
  .aside{
    width: auto;
    margin-top: 50px;
    font-size: 20px;
    margin-left: 50px;
    background-color: deepskyblue;
    margin-right: 50px;
    border-radius: 10px;
  }
  table{
    font-size: 14px;
    /*border-right: gray 1px solid;*/
    line-height: 20px;
    width: auto;
  }
  table td{
    text-align: left;
    height: 50px;
    vertical-align: center;
    width: 100px;
    background-color: transparent;
    line-height: 20px;
    color: white;
    font-size: 16px;
    font-weight: bolder;
    padding-left: 20px;
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
    height: 80px;
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
    width: auto;
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
  a:link{
    color: dodgerblue;
    text-decoration:none;
  }
  a:visited{
    color: deepskyblue;
  }
  a:hover{
    color: yellowgreen;
  }
  a:active{
    color: yellow;
  }
</style>
