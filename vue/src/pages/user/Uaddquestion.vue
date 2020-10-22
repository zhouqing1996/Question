<template>
  <div class="div">
    <div >
      <el-form :model="addList">
        <el-form-item label="标题：" :label-width="labelWidth">
          <el-input v-model="addList.title" style="width: 200px"></el-input>
        </el-form-item>
        <div class="rich-html">
          <vue-html5-editor :content="addList.content" :height="200" @change="updateData">
          </vue-html5-editor>
        </div>
        <el-form-item label="类型:" :label-width="labelWidth" >
<!--          <el-input v-model="addList.type" style="width: 200px"></el-input>-->
          <button type="button" class="btn2 el-icon-circle-plus-outline" @click.prevent="NewTVis=true">创建新分类</button>
          <br>
          <div style="float: left" v-if="NewTVis==true" v-cloak>
            <el-form :model="TYList">
              <el-form-item label="新建分类：">
                <el-input v-model="TYList.typename" style="width: 200px"></el-input>
              </el-form-item>
            </el-form>
          </div>
        </el-form-item>
        <br>
        <div>
          <li v-for="(x,i) in typeList" class="li">
            <input type="radio" :name="1"
                   @change="Click(x.id,x.typename)" @click="NewTVis=false"/>{{x.typename}}
          </li>
        </div>
      </el-form>
    </div>
    <div>
    </div>
    <br>
    <div>
      <button class="btn2 el-icon-search" v-on:click="back">返回</button>
      <button class="btn2 el-icon-search" v-on:click="submit">完成</button>
    </div>
  </div>
</template>

<script>
    export default {
        name: "uAddquestion",
      data(){
          return{
            addList:{
              title:'',
              content:'',
              uid:'',
              type:'',
            },
            labelWidth:'60px',
            typeList:[],
            TYList: {
              id:'',
              typename:''
            },
            NewTVis:false
          }
      },
      methods:{
        NewTY:function()
        {
          this.NewTY = true
        },
        Click:function(id,str)
        {
          this.TYList.id = id
          this.TYList.typename =str
          console.log(this.TYList)
        },
        updateData (e="") {
          console.log(e)
          let c1 = e.replace(/<img width="50%"/g, "<img");
          let c2 = c1.replace(/<img/g, '<img width="50%"');
          this.addList.content = c2
          console.log(this.addList.content)
        },
        back:function()
        {
          this.addList.title=''
            this.addList.content=''
            this.addList.uid=''
            this.addList.type=''
          this.$router.push({
            path:'/u/question',
          })
        },
        submit:function () {
          let that =this
          that.addList.uid = that.$store.getters.getsId
          that.addList.type=that.TYList.typename
          console.log(that.addList)
          if(that.addList.content.length==0)
          {
            this.$alert('内容为空', '警告', {
              confirmButtonText: '确定',})
          }
          else if(that.addList.title.length==0)
          {
            this.$alert('题目为空', '警告', {
              confirmButtonText: '确定',})
          }
          else {
            if(that.addList.type.length==0)
            {
              that.$confirm("类型尚未设置，默认为 未知 ",{
                confirmButtonText:"确定",
                cancelButtonText:'取消',
                type:"warning"
              }).then(()=>{
                that.addList.type="未知"
                that.$http.post('/yii/question/index/uaddquestion',{
                  title:that.addList.title,
                  content:that.addList.content,
                  type:that.addList.type,
                  uid:that.addList.uid
                }).then(function (res) {
                  alert(res.data.message)
                  that.$router.push({
                    path:'/u/question'
                  })
                  this.addList.title=''
                  this.addList.content=''
                  this.addList.uid=''
                  this.addList.type=''
                }).catch(function (err) {
                  console.log(err)
                })
              }).catch(function (err) {
                console.log(err)
              })
            }
            else {
              that.$http.post('/yii/question/index/uaddquestion',{
                title:that.addList.title,
                content:that.addList.content,
                type:that.addList.type,
                uid:that.addList.uid
              }).then(function (res) {
                alert(res.data.message)
                that.$router.push({
                  path:'/u/question'
                })
                this.addList.title=''
                this.addList.content=''
                this.addList.uid=''
                this.addList.type=''
              }).catch(function (err) {
                console.log(err)
              })
            }
          }
        },
        getType:function () {
          let that =this
          this.$http.post('/yii/question/index/uquery',{
            flag:2,
            uid:that.$store.getters.getsId
          }).then(function (res) {
            console.log(res.data)
            that.typeList = res.data.data
            console.log(that.typeList)
          }).catch(function (error) {
            console.log(error)
          })
        },
      },
      created() {
          this.getType()
      }
    }
</script>

<style scoped>
.rich-html{
  margin-top: 20px;
  margin-bottom: 20px;
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
.div{
  margin-top: 30px;
  margin-left: 10px;
}
.btn2:hover {
  background-color: #5FA7FE;
}
.li{
  list-style-type:none;
  float: left;
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
  margin: 0 10px;
}
  [v-cloak]{
    display: none!important;
  }
</style>
