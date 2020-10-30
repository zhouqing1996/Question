<template>
	<div class="login-continer">
		<h3 class="title">问云登录</h3>
		<view class="shuru">
			<view>
				<image src="../../static/images/wode1.png" class="image"></image>
				<input type="text" v-model="username" placeholder="用户名" class="i"/>
			</view>
			<view>
				<image src="../../static/images/mima.png" class="image"></image>
				<input type="password" v-model="password" placeholder="密码"  class="i"/>
			</view>
		</view>
		<button type="primary" v-on:click="bindLogin" class="btnlogin">登录</button>
		<p class="other">
			<navigator url="./register" open-type="redirect">没有账号，注册账号</navigator>
			<navigator url="./pwd" open-type="redirect">有账号，忘记密码</navigator>
		</p>
	</div>
</template>

<script>
	import mIcon from '../../components/uni-icons/uni-icons.vue'
	import {
		mapState,
		mapMutations
	} from 'vuex'
	export default{
		components:{
			mIcon
		},
		data(){
			return{
				username:'',
				password:'',
			}
		},
		computed:{
		},
		methods:{
			bindLogin:function(){
				console.log(this.username)
				console.log(this.password)
				uni.request({
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/home/index/login',
					method:'POST',
					data:{
						username:this.username,
						password:this.password
					},
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					success:(res)=>{
						console.log(res)
						if(res.data.message==="密码错误，登录失败")
						{
							uni.showToast({
								title:"账号或者密码错误",
								icon:'none'
							});
						}
						else if(res.data.message==="该用户不存在")
						{
							uni.showToast({
								title:"该用户不存在",
								icon:'none'
							});
						}
						else{
							uni.showToast({
								title:res.data.message,
								icon:"success"
							});
							this.$store.dispatch('slogin',res.data.data)
							uni.reLaunch({
								url:'../index/index'
							})
						}
					},
					fail: () => {
						console.log('登录失败')
					},
					complete: () => {	
					}
				})
			}
		}
	}
</script>

<style>
	.login-container {
	    border-radius: 15px;
	    background-clip: padding-box;
	    margin-top: 80rpx;
	    width: 350px;
	    padding: 35px 35px 15px 35px;
	    background: #fff;
	    border: 1px solid #eaeaea;
	    box-shadow: 0 0 25px #cac6c6;
	  }
	  .title {
	    margin-top: 50rpx;
		margin-bottom: 20rpx;
	    text-align: center;
	    color: #505458;
	  }
	  .shuru{
		  margin-top: 50rpx;
		  text-align: left;
		  border-radius: 3px;
		  width: 80%px;
		  font-size: 14px;
	  }
	  .i{
		height: 20rpx;
		margin-top: 30rpx;
		outline-style: none ;
		border: 1px solid #ccc; 
		border-radius: 3px;
		padding: 13px 14px;
		margin-left: 100rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
		width: 500rpx;
		/* vertical-align: middle; */
	  }
	  .image{
		  float: left;
		  width: 100rpx;
		  height: 100rpx;
	  }
	  .btnlogin{
		  margin-top: 40rpx;
		  width: 40%;
		  padding: 2rpx;
		  border-color: #357ebd;  
		  color: #fff;  
		 -moz-border-radius: 10px;  
		 -webkit-border-radius: 10px;  
		 border-radius: 10px; 
		 -khtml-border-radius: 10px; 
	  }
	  .other {
	    margin-top: 10px;
	    font-size: 14px;
	    line-height: 22px;
	    cursor: pointer;
	    text-align: right;
	    width: auto;
		color: #007AFF;
		margin-right: 20rpx;
	  }
	
</style>
