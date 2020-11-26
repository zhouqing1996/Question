
<template>
  <div >
    <div class="waimian">
      <div class="back">
        <el-page-header @back="back">
        </el-page-header>共{{qList.length}}个相关问题
      </div>
      <div class="wenti">
        <div v-for="(x,i) in currentPageData">
          <h3>{{i+1}}:{{x.title}}     <span class="typename">{{x.typename}}</span></h3>
          <span><i class="el-icon-date"></i> {{x.ctime}}</span>
          <hr>
          <div v-html="x.content">
            {{x.content}}
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
    </div>

  </div>
</template>

<script>
  export default {
    name: "ViewSear",
    data(){
      return{
        name:'',
        //查询的问题
        qList:[],
        // 翻页相关
        currentPage: 1,
        totalPage: 1,
        pageSize: 1,
        currentPageData:[]
      }
    },
    methods:{
      back:function()
      {
        this.$router.push({
          path:'/u/viewall',
        })
      },
      //分页
      setCurrentPageDate: function () {
        let begin = (this.currentPage - 1) * this.pageSize;
        let end = this.currentPage * this.pageSize;
        this.currentPageData = this.qList.slice(begin, end)
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
      getList:function () {
        let that =this
        this.$http.post('/question/index/query',{
          flag:3,
          name:that.name
        }).then(function (res) {
          console.log(res.data)
          let List = res.data.data
          for(let i=0;i<List.length;i++)
          {
            that.qList.push({
              id: List[i].id,
              title: List[i].title,
              content: List[i].content,
              ctime: List[i].ctime,
              uid: List[i].uid,
              typename: that.getTypeName(List[i].type)
            })
          }
          that.totalPage =Math.ceil(that.qList.length/that.pageSize)
          that.totalPage=that.totalPage==0?1:that.totalPage
          that.setCurrentPageDate()
        }).catch(function (error) {
          console.log(error)
        })
      },
      getType:function () {
        let that =this
        this.$http.post('/question/index/query',{
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
      this.name = this.$route.query.search
      this.getType()
      this.getList()
    }
  }
</script>

<style scoped>
  li{list-style-type:none;}
  .back{
    margin-top: 30px;
    margin-bottom: 20px;
  }
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
