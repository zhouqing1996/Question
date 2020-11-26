<template>
  <div>
    <el-container>
      <el-aside :span="4">
      </el-aside>
      <el-main :span="20">
        <div class="waimian">
          <div class="back">
            <el-page-header @back="back">
            </el-page-header>
          </div>
          <div>
          </div>
          <div>
            <table>
              <th>序号</th>
              <th>用户编号</th>
              <th>用户名</th>
              <th>密码</th>
              <th>操作</th>
              <tr v-for="(x,i) in currentPageData">
                <td>{{i+1}}</td>
                <td>{{x.id}}</td>
                <td v-if="x.role==1" style="color: red">{{x.username}}(管理员)</td>
                <td v-if="x.role==3">{{x.username}}</td>
                <td>{{x.password}}</td>
                <td>
                  <span @click="PassReset(x.id)" class="span2"><i class="el-icon-key">重置密码</i> </span>
                  <span v-if="x.role==1" class="span1">管理员</span>
                  <span v-else class="span1"  @click="DeleteUser(x.id)"><i class="el-icon-delete">删除</i></span>
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
        </div>
      </el-main>

      <el-aside :span="4">
        <div class="asRight">
          <button class="btn3 el-icon-circle-plus-outline" @click="dialogFormVisibleadd = true">添加</button>
          <el-dialog title="添加用户" :visible.sync="dialogFormVisibleadd">
            <el-form :model="addUser">
              <el-form-item label="用户名" :label-width="formLabelWidth">
                <el-input style="width: 350px;" v-model="addUser.username" auto-complete="off"></el-input>
              </el-form-item>
              <el-form-item label="身份" :label-width="formLabelWidth">
                <select class="inputdiv" v-model="addUser.role" style="font-size:15px;width:180px;" >
                  <option value="1">管理员</option>
                  <option value="3" selected="selected">学生</option>
                </select>
              </el-form-item>
            </el-form>
            <div slot="footer" style="align-content: center" class="dialog-footer">
              <el-button type="primary" @click="ADDUser">提交</el-button>
              <el-button @click="Reset">重置</el-button>
            </div>
          </el-dialog>
        </div>
      </el-aside>
    </el-container>
  </div>
</template>

<script>
    export default {
        name: "User",
      data(){
        return{
          userList:[],
          addUser:{
            username:'',
            role:0,
          },
          formLabelWidth:'300px',
          dialogFormVisibleadd:false,
          // 翻页相关
          currentPage: 1,
          totalPage: 1,
          pageSize: 8,
          currentPageData:[]
        }
      },
      methods:{

        back:function()
        {
          this.$router.push({
            path:'/question',
          })
        },
        Reset:function(){
          let that = this
          that.addUser.username=''
          that.addUser.role=''
        },
        //分页
        setCurrentPageDate: function () {
          let begin = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          this.currentPageData = this.userList.slice(begin, end)
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
        getUserList(){
          let that =this
          that.$http.post('/home/user/query',{
            flag:2
          }).then(function (res) {
            console.log(res.data)
            that.userList = res.data.data
            that.totalPage =Math.ceil(that.userList.length/that.pageSize)
            that.totalPage=that.totalPage==0?1:that.totalPage
            that.setCurrentPageDate()
          })
        },
        DeleteUser:function (id) {
          let that =this
          that.$confirm("是否删除该用户",{
            confirmButtonText:"确定",
            cancelButtonText:'取消',
            type:"warning"
          }).then(()=>{
            that.$http.post('/home/user/deleteuser',{
              flag:2,
              userid:id
            }).then(function (res) {
              console.log(res.data)
              that.getUserList()
              alert(res.data.message)
            })
          })
        },
        ADDUser:function () {
          let that = this
          if(that.addUser.username.length==0 )
          {
            this.$alert('添加用户中用户名为空！', '警告', {
              confirmButtonText: '确定',})
          }
          else if(that.addUser.role == 0)
          {
            this.$alert('添加用户中身份为空！', '警告', {
              confirmButtonText: '确定',})
          }
          else
          {
            that.$http.post('/home/user/adduser',{
              addname:that.addUser.username,
              addrole:that.addUser.role
            }).then(function (res) {
              console.log(res.data)
              if(res.data.message=="用户添加成功")
              {
                that.$alert("添加成功，默认密码为：zhou@123", '提示', {
                  confirmButtonText: '确定',})
                that.getUserList()
				that.dialogFormVisibleadd = false
                that.Reset()
              }
              else{
                alert(res.data.message)
              }
            })
          }

        },
        //批量添加
        AddB:function () {
          let that =this
          that.inputExcel.click()
        },
        importExcel (obj) {
          let _this = this
          let inputDOM = this.$refs.inputer   // 通过DOM取文件数据
          this.file = event.currentTarget.files[0]
          var rABS = false // 是否将文件读取为二进制字符串
          var f = this.file
          var reader = new FileReader()
          // if (!FileReader.prototype.readAsBinaryString) {
          FileReader.prototype.readAsBinaryString = function (f) {
            var binary = ''
            var rABS = false // 是否将文件读取为二进制字符串
            var pt = this
            var wb // 读取完成的数据
            var outdata
            var reader = new FileReader()
            reader.onload = function (e) {
              var bytes = new Uint8Array(reader.result)
              var length = bytes.byteLength
              for (var i = 0; i < length; i++) {
                binary += String.fromCharCode(bytes[i])
              }
              var XLSX = require('xlsx')
              if (rABS) {
                wb = XLSX.read(btoa(fixdata(binary)), { // 手动转化
                  type: 'base64'
                })
              } else {
                wb = XLSX.read(binary, {
                  type: 'binary'
                })
              }
              // outdata就是你想要的东西 excel导入的数据
              outdata = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]])
              // excel 数据再处理
              let arr = []
              outdata.map(v => {
                let obj ={}
                obj.name = v.用户名
                obj.publish= v.密码
                obj.author= v.作者
                obj.about=v.关于
                arr.push(obj)
              })
              _this.memberList = [...arr]
              let data = {
                data: JSON.stringify(_this.memberList)
              }
              console.log(data)
              _this.$http.post('/home/user/importexcel', data).then(body => {
                alert(body.data.message)
                _this.getUserList()
              })
            }
            reader.readAsArrayBuffer(f)
          }
          if (rABS) {
            reader.readAsArrayBuffer(f)
          } else {
            reader.readAsBinaryString(f)
          }
        },
        PassReset:function(id)
        {
          let that =this
          this.$http.post('/home/index/resetpass',{
            id:id
          }).then(function (res) {
            console.log(res.data)
            that.getUserList()
            // that.totalPage =Math.ceil(that.userList.length/that.pageSize)
            // that.totalPage=that.totalPage==0?1:that.totalPage
            // that.setCurrentPageDate()
          })
        },
      },
      created(){
          this.getUserList()
      },

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
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;

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
  /*修改*/
  .span2{
    width: 50px;
    padding: 7px;
    font-size: 14px;
    border-radius: 3px;
    border: none;
    color: white;
    background-color: sandybrown;
    margin-left: 5px;
    margin-top: 17px;
    margin-bottom: 5px;
  }
  .span2:hover{
    background-color: #5FA7FE;
  }
  .asRight{
    margin-top: 30px;
    background-color: beige;
    color: black;

  }
  .btn3 {
    width: 100px;
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

  .btn3:hover {
    background-color: #5FA7FE;
  }
</style>
