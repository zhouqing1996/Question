<template>
  <div>
    <div class="waimian">
      <div class="back">
        <el-page-header @back="back">
        </el-page-header>
      </div>
      <div >
        <div >
          <el-form :model="addList">
            <el-form-item>
              <input v-model="addList.title" class="inputTitle" placeholder="输入标题"></input>
            </el-form-item>

            <div class="rich-html">
              <vue-html5-editor :content="addList.content" :height="200" @change="updateData">
              </vue-html5-editor>
            </div>
            <el-form-item>
              <button type="button" class="btn2 el-icon-circle-plus-outline" @click.prevent="NewTVis=true">创建新分类</button>
            </el-form-item>
            <el-form-item v-if="NewTVis==true" v-cloak>
              <input v-model="TYList.typename" class="NTitle" placeholder="新建分类"></input>
              <br>
              <button class="btn1 el-icon-remove-outline" v-on:click="NewTVis=false">取消</button>
            </el-form-item>
            <el-form-item>
              <div>
                <li v-for="(x,i) in typeList" class="li">
                  <input type="radio" :name="1"
                         @change="Click(x.id,x.typename)" @click="NewTVis=false"/>{{x.typename}}
                </li>
              </div>
            </el-form-item>
            <el-form-item>
              <div>
                <button class="btn2 el-icon-circle-check" @click.prevent ="submit">完成</button>
              </div>
            </el-form-item>
          </el-form>
        </div>
        <div class="back">
          <el-page-header @back="back">
          </el-page-header>
        </div>
      </div>
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
        this.$router.push({
          path:'/question/personal',
        })
        this.addList.title=''
        this.addList.content=''
        this.addList.uid=''
        this.addList.type=''
      },
      submit:function () {
        let that =this
        that.addList.uid = that.$store.getters.getsId
        that.addList.type=that.TYList.typename
        console.log(that.addList)
        if(that.addList.content.length==0)
        {
          // that.$message({
          //   type:'警告',
          //   message:'内容为空'
          // })
          this.$alert('内容为空', '警告', {
            confirmButtonText: '确定',})
          return
        }
        else if(that.addList.title.length==0)
        {
          this.$message('题目为空', '警告', {
            confirmButtonText: '确定',})
          return
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
              that.$http.post('/question/index/uaddquestion',{
                title:that.addList.title,
                content:that.addList.content,
                type:that.addList.type,
                uid:that.addList.uid
              }).then(function (res) {
                console.log(res)
                if(res.data.message=="添加成功"){
                  that.$router.push('/question/personal')
                  // that.$router.push({
                  //   name:'Uquestion'
                  // })
                  alert(res.data.message)
                  this.addList.title=''
                  this.addList.content=''
                  this.addList.uid=''
                  this.addList.type=''
                }
                else{
                  alert(res.data.message)
                }
              }).catch(function (err) {
                console.log(err)
              })
            }).catch(function (err) {
              console.log(err)
            })
          }
          else {
            that.$http.post('/question/index/uaddquestion',{
              title:that.addList.title,
              content:that.addList.content,
              type:that.addList.type,
              uid:that.addList.uid
            }).then(function (res) {
              console.log(res)
              if(res.data.message=="添加成功"){
                that.$router.push('/question/personal')
                // that.$router.push({
                //   name:'Uquestion'
                // })
                alert(res.data.message)
                this.addList.title=''
                this.addList.content=''
                this.addList.uid=''
                this.addList.type=''
              }
              else{
                alert(res.data.message)
              }
            }).catch(function (err) {
              console.log(err)
            })
          }
        }
      },
      getType:function () {
        let that =this
        this.$http.post('/question/index/uquery',{
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
    height: auto;
  }
  .addcontent{
    margin-top: 10px;
    padding: 10px;
    margin-left: 10px;
    margin-right: 10px;
    width: auto;
    height: 20px;
    font-size: 20px;
    color: red;
  }
  .inputTitle{
    outline-style: none ;
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 14px 14px;
    width: 620px;
    font-size: 16px;
    margin-top: 20px;
    float: left;
  }
  .inputTitle :focus{
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)
  }
  .NTitle{
    outline-style: none ;
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 14px 14px;
    width: 100px;
    font-size: 16px;
    margin-top: 20px;
    float: left;
  }
  .NTitle:focus{
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)
  }
  .rich-html{
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .btn1{
    width: auto;
    padding: 7px;
    font-size: 14px;
    border-radius: 3px;
    border: none;
    color: white;
    background-color: #999aaa;
    float: left;
    margin-left: 5px;
    margin-top: 17px;
    margin-bottom: 5px;
  }
  .btn1:hover {
    background-color: #5FA7FE;
  }
  .btn2 {
    width: auto;
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
</style>
