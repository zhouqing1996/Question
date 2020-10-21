<template>
  <div >
    <el-container>
      <el-aside width="200px">
        <el-menu
          class="el-menu-vertical-demo"
          style="width: 150px" v-for="(x,i) in typeList">
          <el-menu-item index="i+1">
            <i class="el-icon-menu"></i>
            <span slot="title" @click="Click(x.id)">{{x.typename}}</span>
          </el-menu-item>
        </el-menu>
      </el-aside>
      <el-main>
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
              <th>题目编号</th>
              <th>标题</th>
              <th>解决办法</th>
              <th>类型</th>
              <th>操作</th>
            </tr>
            <tr v-for="(x,i) in questionList">
              <td width="20px">{{i+1}}</td>
              <td width="20px">{{x.id}}</td>
              <td>{{x.title}}</td>
              <td>{{x.content}}</td>
              <!--<td if="{{Item.id}}=={{x.type}}" v-for="Item in typeList">{{Item.typename}} </td>-->
              <td>类型</td>
              <td>
                <span >查看</span>
              </td>
            </tr>
          </table>
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
            typeList:[],

          }
      },
      methods:{
        Click:function(id){
          let that = this
          this.$http.post('/yii/question/index/query',{
            flag:4,
            id:id
          }).then(function (res) {
            console.log(res.data)
            that.questionList = res.data.data
          }).catch(function (error) {
            console.log(error)
          })
        },
          Search:function()
          {
            this.$router.push({
              path:'/search',
              query:{
                search:this.inputname
              }
            })
          },

          getList:function () {
            let that =this
            this.$http.post('/yii/question/index/query',{
              flag:1
            }).then(function (res) {
              console.log(res.data)
              that.questionList = res.data.data
            }).catch(function (error) {
              console.log(error)
            })
          },
        getType:function () {
            let that =this
          this.$http.post('/yiiquestion/index/query',{
            flag:2
          }).then(function (res) {
            console.log(res.data)
            that.typeList = res.data.data
          }).catch(function (error) {
            console.log(error)
          })
        }
      },
      created(){
          this.getList()
        this.getType()
          console.log(this.questionList)
      }
    }
</script>

<style scoped>
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
</style>
