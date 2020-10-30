import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state:{
		// 强制登录
		forceLogin:false,
		hasLogin:false,
		sId:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sId']:"",
		    sName:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sName']:"",
		    sPwd:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sPwd']:"",
		    sRole:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sRole']:"",
		    sStatus:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sStatus']:"",
	},
	getters:{
		getsId:(state)=>{
		      return state.sId
		    },
		    getsName:(state)=>{
		      return state.sName
		    },
		    getsPwd:(state)=>{
		      return state.sPwd
		    },
		    getsRole:(state)=>{
		      return state.sRole
		    },
		    getsStatus:(state)=>{
		      return state.sStatus
		    }
		// getName:(state)=>{
		// 	return state.username
		// },
		// getHasLogin:(state)=>{
		// 	return state.hasLogin
		// }
	},
	mutations:{
		setsId:function (state,id) {
		      state.sId = id;
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    setsName:function (state,name) {
		      state.sName = name;
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    setsPwd:function (state,pwd) {
		      state.sPwd = pwd;
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    setsRole:function (state,role) {
		      state.sRole = role;
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    setsStatus:function (state,status) {
		      state.sStatus = status;
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    delsId(state)
		    {
		      state.sId = "";
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    delsName(state)
		    {
		      state.sName = "";
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    delsPwd(state)
		    {
		      state.sPwd = "";
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    delsRole(state)
		    {
		      state.sRole = "";
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    },
		    delsStatus(state)
		    {
		      state.sStatus = "";
		      sessionStorage.setItem("vuex",JSON.stringify(state))
		    }
		// setName:function(state,user){
		// 	state.username = user
		// },
		// setHasLogin:function(state,haslogin){
		// 	state.hasLogin = haslogin
		// },
		// delName(state){
		// 	state.username=''
		// },
		// delHasLogin(state){
		// 	state.hasLogin =false
		// }
	},
	actions:{
		slogin:({commit},obj)=>{
		      commit('setsId',obj.id),commit('setsName',obj.username),commit('setsPwd',obj.password),
		        commit('setsRole',obj.role),
		        commit('setsStatus',obj.status)
		    },
		    slogout:({commit})=>{
		      commit('delsId'),commit('delsName'),commit('delsPwd'),
		        commit('delsRole'),
		        commit('delsStatus')
		    },
		// login(state,provider){
		// 	state.userInfo = provider ;
		// 	state.hasLogin = true;
		// 	uni.setStorage({
		// 		key:'userInfo',
		// 		data:provider
		// 	})
		// 	console.log(state.userInfo)
		// },
		// loginout(state){
		// 	state.userInfo = '';
		// 	state.hasLogin = false;
		// 	uni.removeStorage({
		// 		key:'userInfo'
		// 	})
		// }
	}
})

export default store