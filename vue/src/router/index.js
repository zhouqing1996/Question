import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Question from '../pages/question/question'
import Home from '../pages/Home'
import Search from '../pages/question/Search'
import Add from '../pages/question/Addquestion'
import Viewquestion from '../pages/question/Viewquestion'
import User from '../pages/question/User'
import PersonQuestion from  '../pages/question/personQuestion'
import PersonSearch from '../pages/question/personalSearch'
import PersonalAnalyse from '../pages/question/personalAnalyse'
import PersonalViewQuestion from '../pages/question/personalViewQuestion'

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
import UView from '../pages/user/Viewall'
import UViewview from '../pages/user/Viewview'
import UViewSear from '../pages/user/ViewSear'

import SLineChart from '../components/SLineChart'
import CalenderHeatmap from '../components/CalenderHeatmap'
import BarChart from '../components/BarChart'
//测试
import CalenderHeatmap1 from '../components/CalenderHeatmap1'
import Analyse from '../pages/question/Analyse'
import PAnalyse from '../pages/user/PAnalyse'

import My from '../pages/My'
import ChangePwd from '../pages/Changepwd'


import Data from '../pages/home/Data'
export default new Router({
  // base:'/Question/vue',
  mode:'history',
  routes: [
    {
      path:'/slinechart',
      name:'slinechart',
      meta:{
        isLogin:false
      },
      component:SLineChart
    },
    {
      path:'/heatmap',
      name:'heatmap',
      meta:{
        isLogin:false
      },
      component:CalenderHeatmap
    },
    {
      path:'/heatmap1',
      name:'heatmap1',
      meta:{
        isLogin:false
      },
      component:CalenderHeatmap1
    },
    {
      path:'/barchart',
      name:'barchart',
      meta:{
        isLogin:false
      },
      component:BarChart
    },
    {
      path:'/my',
      name:'my',
      meta:{
        isLogin:true
      },
      component:My
    },
    {
      path:'/data',
      name:'data',
      meta:{
        isLogin:false
      },
      component:Data
    },
    {
      path:'/changepwd',
      name:'changepwd',
      meta:{
        isLogin:true
      },
      component:ChangePwd
    },
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
          path:'/question/personal',
          name:'PersonQuestion',
          meta:{
            isLogin:true
          },
          component:PersonQuestion
        },
        {
          path:'/question/personalsearch',
          name:'PersonSearch',
          meta:{
            isLogin:true
          },
          component:PersonSearch
        },
        {
          path:'/question/personalAnalyse',
          name:'PersonalAnalyse',
          meta:{
            isLogin:true
          },
          component:PersonalAnalyse
        },
        {
          path:'/question/personalviewquestion',
          name:'PersonalViewQuestion',
          meta:{
            isLogin:true
          },
          component:PersonalViewQuestion
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
        },
        {
          path:'/question/analyse',
          name:'analyse',
          meta:{
            isLogin:true
          },
          component:Analyse
        },
        {
          path:'/question/user',
          name:'user',
          meta:{
            isLogin:true
          },
          component:User
        }
      ]
    },
    {
      path:'/u',
      name:'U',
      component:UHome,
      children: [
        {
          path:'/u/viewall',
          name:'viewall',
          meta:{
            isLogin:true
          },
          component:UView
        },
        {
          path:'/u/viewview',
          name:'viewview',
          meta:{
            isLogin:true
          },
          component:UViewview
        },
        {
          path:'/u/viewsear',
          name:'viewsear',
          meta:{
            isLogin:true
          },
          component:UViewSear
        },
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
          path:'/u/panalyse',
          name:'panalyse',
          meta:{
            isLogin:true
          },
          component:PAnalyse
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
