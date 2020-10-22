<template>
    <div>
      <el-container>
        <el-header class="header">
          <el-menu
            class="el-menu-demo"
            mode="horizontal"
            background-color="#3686f1"
            text-color="#FFFFFF"
            active-text-color="#ffd04b"
          float="right">
            <el-menu-item>       </el-menu-item>
            <el-menu-item>        </el-menu-item>
            <el-menu-item index="1">处理中心</el-menu-item>
            <el-submenu index="2">
              <template slot="title">我的工作台</template>
              <el-menu-item index="2-1">选项1</el-menu-item>
              <el-menu-item index="2-2">选项2</el-menu-item>
              <el-menu-item index="2-3">选项3</el-menu-item>
              <el-submenu index="2-4">
                <template slot="title">选项4</template>
                <el-menu-item index="2-4-1">选项1</el-menu-item>
                <el-menu-item index="2-4-2">选项2</el-menu-item>
                <el-menu-item index="2-4-3">选项3</el-menu-item>
              </el-submenu>
            </el-submenu>
            <el-submenu index="3">
              <template slot="title">
                <div>
                  <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png">注销</el-avatar>
                </div>
              </template>
              <el-menu-item index="3-1" v-on:click="logout" >注销
              </el-menu-item>
            </el-submenu>

          </el-menu>
        </el-header>
        <el-main class="main">
          <router-view/>
        </el-main>
        <el-footer class="footer">
          <!--<p>Copyrights©{{CurrentYear}} by zhouqing.</p>-->
        </el-footer>
      </el-container>
    </div>
</template>

<script>
    export default {
        name: "Home",
      data(){
        var copyright=new Date();
        var update=copyright.getFullYear()
          return {
            CurrentYear:update
          }
      },
      methods: {
        logout:function () {
          let suserid = this.$store.getters.getsId
          console.log(suserid)
          let that = this
          this.$confirm("是否退出？", "提示", {
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            type: "warning"
          }).then(function (res) {
            that.$store.dispatch('slogout')
            alert("退出成功！")
            that.$router.push({path: '/login'})
          }).catch(function (err) {
            console.log(err)
          })
        }
      },
      created(){

      }
    }
</script>

<style scoped>
  p {
    font-size: 14px;
    margin: auto;
    color: #3d3d3d;
  }
  .header{
    position: fixed;
    top:0;
    left:0;
    z-index: 50;
    /*background-image: none;*/
    background-color: #3686f1;
    font-size: 14px;
    color: white;
    width: 100%;
    border-color: #1995dc;
    text-align: right;
  }
  .main{
    height: 80%;
    width: 100%;
    margin-top: 30px;
    padding: 10px;
    margin-left: 30px;

  }
  .footer{
    position: relative;
    bottom: 0;
    width: 100%;
    text-align: center;
    height: 30px;/*脚部的高度*/
    /*background: #6cf;*/
    clear:both;
  }
</style>
