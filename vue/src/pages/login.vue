<template>
  <body id="poster">
  <el-form class="login-container" label-position="left" label-width="0px">
    <h3 class="login_title">登录</h3>
    <el-form-item>
      <el-input type="text" v-model="loginForm.username" auto-complete="off" placeholder="账号"></el-input>
    </el-form-item>
    <el-form-item>
      <el-input :type="passwordVisible" v-model="loginForm.password" auto-complete="off" placeholder="密码">
        <i slot="suffix" :class="icon" @click="showPass"></i>
      </el-input>
    </el-form-item>
    <el-form-item style="width: 100%">
      <el-button type="primary" style="width: 100%;background: dodgerblue;border: none" v-on:click="login">登录</el-button>
    </el-form-item>
    <p class="other"><router-link to="/register">没有账号？立即注册</router-link>|||<router-link to="/forget">忘记密码？立即找回</router-link></p>
  </el-form>
  </body>
</template>


<script>
  export default {
    name: "Login",
    data() {
      return {
        passwordVisible:'password',
        icon:"el-icon-view",
        loginForm: {
          username: '',
          password: ''
        },
        responseResult: []
      }
    },
    methods: {
      showPass() {
        if (this.passwordVisible === "text") {
          this.passwordVisible = "password";
          //更换图标
          this.icon = "el-icon-view";
        } else {
          this.passwordVisible = "text";
          this.icon = "el-icon-lock";
        }
      },
      login() {
        console.log('/yii')
        this.$http.post('/yii/home/index/login',{
          username:this.loginForm.username,
          password:this.loginForm.password,
        }).then(res=>{
          console.log(res.data)
          var message = res.data.message
          if(message=="登录成功")
          {
            this.$store.dispatch('slogin',res.data.data)
            let role = this.$store.getters.getsRole
            alert(message)
            if(role==1)
            {
              //管理员
              this.$router.push({path:'/question'})
            }
            else if(role ==2)
            {
              //二级管理员
              this.$router.push({path:'/t/question'})
            }
            else
            {
              this.$router.push({path:'/u/question'})
            }
          }
          else if(message=="该用户不存在")
          {
            alert(message)
          }
          else if(message=="密码错误，登录失败")
          {
            alert(message)
          }

          // console.log(localStorage.getItem("Token"))
        }).catch(function (error) {
          console.log(error)
        })
      },
      // gotoReigster() {
      //   this.$router.push({
      //     path: "/register"
      //   });
      // },
      // gotoForget(){
      //   this.$router.push({
      //     path:"/forget"
      //   });
      // }
    },
    created:function ()
    {
      this.loginForm.username = this.$route.params.username;
      this.loginForm.password = this.$route.params.password
    }
  }
</script>

<style>
  #poster {
    /*background:url("../assets/eva.jpg") no-repeat;*/
    background-position: center;
    height: 100%;
    width: 100%;
    background-size: cover;
    position: fixed;
  }
  body{
    margin: 0px;
    padding: 0;
  }

  .login-container {
    border-radius: 15px;
    background-clip: padding-box;
    margin: 90px auto;
    width: 350px;
    padding: 35px 35px 15px 35px;
    background: #fff;
    border: 1px solid #eaeaea;
    box-shadow: 0 0 25px #cac6c6;
  }

  .login_title {
    margin: 0px auto 40px auto;
    text-align: center;
    color: #505458;
  }

  .other {
    margin-top: 10px;
    font-size: 14px;
    line-height: 22px;
    color: #1ab2ff;
    cursor: pointer;
    text-align: center;
    /*text-indent: 8px;*/
    width: 360px;
  }
  .other:hover {
    /*color: #2c2fd6;*/
  }
</style>
