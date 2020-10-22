<template>
    <div>
      <el-container>
        <el-header>
          <el-menu class="el-menu-demo" mode="horizontal" >
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
            <el-menu-item index="3" v-on:click="logout" >注销</el-menu-item>
          </el-menu>
        </el-header>
        <el-main style="height: 520px;width: 100%">
          <router-view/>
        </el-main>
        <el-footer>
          <p>Copyrights©{{CurrentYear}} by zhouqing.</p>
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
    font-size: 1.4rem;
    margin: auto;
    color: #3d3d3d;
  }
</style>
