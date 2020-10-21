<template>
  <div>
    <div v-for="(x,i) in currentPageData">
      <h3>{{x.title}}</h3>
      <span>问题创建人：{{x.uid}}|创建时间：{{x.ctime}}</span>
      <hr>
      <span>{{x.content}}</span>
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
</template>

<script>
    export default {
        name: "Search",
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
          this.$http.post('/yii/question/index/query',{
            flag:3,
            name:that.name
          }).then(function (res) {
            console.log(res.data)
            that.qList = res.data.data
            that.totalPage =Math.ceil(that.qList.length/that.pageSize)
            that.totalPage=that.totalPage==0?1:that.totalPage
            that.setCurrentPageDate()
          }).catch(function (error) {
            console.log(error)
          })
        },
      },
      created(){
          this.name = this.$route.query.search
        this.getList()
      }
    }
</script>

<style scoped>
  li{list-style-type:none;}
  .dialog1{
    width: 350px;
    height:400px;
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
</style>
