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
          <table>
            <tr>
              <th>序号</th>
              <!--<th>题目编号</th>-->
              <th>标题</th>
              <th>内容</th>
              <th>创建人</th>
              <th v-if="typeVis==true">类型</th>
              <th>操作</th>
            </tr>
            <tr v-for="(x,i) in currentPageData">
              <td width="20px">{{i+1}}</td>
              <!--<td width="20px">{{x.id}}</td>-->
              <td style="color: #00AAFF">{{x.title}}</td>
              <td>{{x.content}}</td>
              <td>{{x.uid}}</td>
              <td v-if="typeVis==true">{{x.typename}}</td>
              <td>
                <span class="span2" @click="View(x.id,x.uid)">查看</span>
                <span class="span1" @click="Delete(x.id)"><i class="el-icon-delete">删除</i></span>
              </td>
            </tr>
          </table>
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
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
    table-layout: fixed;
    white-space:nowrap;
    overflow:hidden;
    text-overflow: ellipsis;
  }
  th {
    font-size: 14px;
    border: solid 1px #ccc;
    font-weight: bold;
    padding: 5px;
    background-color: #F1F1F1;
    text-align: center;
  }

  table, td {
    border: solid 1px #ccc;
    padding: 5px;
    text-align: center;
    font-size: 18px;
    table-layout: fixed;
    white-space:nowrap;
    overflow:hidden;
    text-overflow: ellipsis;
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
