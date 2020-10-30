<template>
	<view v-if="hasLogin">
		<view v-if="role==1">管理员</view>
		<view v-else>学生</view>
	</view>
	<view v-else class="NotLogin">
		<view>
			还没登录，点击登录
		</view>
		<button type="primary" @click="bindLogin" class="btnlogin">登录</button>
	</view>
</template>

<script>
	export default{
		data(){
			return{
				hasLogin:false,
				username:"",
				role:0,
			}
		},
		methods:{
			bindLogin:function(){
				uni.reLaunch({
					url:'../my/login'
				})
			},
			
		},
		created() {
			if(this.$store.getters.getsId){
				this.hasLogin =true,
				this.username = this.$store.getters.getsName
				this.role = this.$store.getters.getsId
			}
		}
	}
</script>

<style>
	.NotLogin{
		margin-top: 200rpx;
		margin-left: 50rpx;
		margin-bottom: 50rpx;
		text-align: center;
		color: #333333;
		/* background-image: url(../../static/images/tongji2.png); */
		width: auto;
		height: 500rpx;
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
</style>
