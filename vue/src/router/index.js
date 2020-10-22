import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Question from '../pages/question/question'
import Home from '../pages/Home'
import Search from '../pages/question/Search'
import Add from '../pages/question/Addquestion'
import Viewquestion from '../pages/question/Viewquestion'

import Register from '../pages/register'
import Forget from '../pages/forget'
import Login from '../pages/login'
//404错误
import NotFound from '../pages/404'
Vue.use(Router)
import UHome from '../pages/user/Uhome'
import UQuestion from '../pages/user/Uquestion'
import UviewQuestion from '../pages/user/Uviewquestion'
import USearchQuestion from '../pages/user/Usearch'
import UaddQuestion from '../pages/user/Uaddquestion'

export default new Router({
  mode:'history',
  routes: [
    {
      //注册
      path: '/register',
      name: 'Register',
      meta:{
        isLogin:false,
      },
      component: Register
    },
    {
      //忘记密码
      path:'/forget',
      name:'Forget',
      meta:{
        isLogin:false,
      },
      component:Forget
    },
    {
      //登录
      path:'/login',
      name:'Login',
      meta:{
        isLogin:false,
      },
      component:Login
    },
    {
      path:'*',
      name:'notfound',
      meta:{
        isLogin:false
      },
      component:NotFound
    },
    {
      path: '/',
      name: 'Home',
      meta:{
        isLogin:true,
      },
      component: Home,
      children:[
        {
          path: '/question',
          name:'Question',
          meta:{
            isLogin:true,
          },
          component: Question
        },
        {
          path:'/question/search',
          name:'Search',
          meta:{
            isLogin:true,
          },
          component:Search
        },
        {
          path:'/question/add',
          name:'Add',
          meta:{
            isLogin:true,
          },
          component:Add
        },
        {
          path:'/question/view',
          name:'View',
          meta:{
            isLogin:true,
          },
          component:Viewquestion
        }
      ]
    },
    {
      path:'/u',
      name:'U',
      component:UHome,
      children: [
        {
          path:'/u/question',
          name:'Uquestion',
          meta:{
            isLogin:true
          },
          component:UQuestion
        },
        {
          path:'/u/search',
          name:'USearch',
          meta:{
            isLogin:true
          },
          component:USearchQuestion
        },
        {
          path:'/u/addquestion',
          name:"Uadd",
          meta:{
            isLogin:true
          },
          component:UaddQuestion
        },
        {
          path:'/u/viewquestion',
          name:'UViewQuestion',
          meta:{
            isLogin:true
          },
          component:UviewQuestion
        }
      ]
    }
  ]
})
