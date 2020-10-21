import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Question from '../pages/question/question'
import Home from '../pages/Home'
import Search from '../pages/question/Search'
import Add from '../pages/question/Addquestion'
Vue.use(Router)

export default new Router({
  mode:'history',
  routes: [

    {
      path: '/',
      name: 'Home',
      component: Home,
      children:[
        {
          path: '/question',
          name:'Question',
          component: Question
        },
        {
          path:'/search',
          name:'Search',
          component:Search
        },
        {
          path:'/add',
          name:'Add',
          component:Add
        }
      ]
    }
  ]
})
