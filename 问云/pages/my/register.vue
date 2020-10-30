<template>
	<view class="login-continer">
		<h3 class="title">问云注册</h3>
		<view class="shuru">
			<view>
				<input type="text" v-model="Musername" placeholder="用户名" class="i"/>
			</view>
			<view>
				<input type="password" v-model="Mpassword" placeholder="密码为6~10位包含数字/字母/下划线的组合"  class="i"/>
			</view>
			<view>
				<input type="password" v-model="Mpassword1" placeholder="确认密码"  class="i"/>
			</view>
		</view>
		<button type="primary" v-on:click="registerM" class="btnlogin">注册</button>
		<!-- <p class="other">
			<navigator url="./register" open-type="redirect">注册账号</navigator>
			<navigator url="./pwd" open-type="redirect">忘记密码</navigator>
		</p> -->
		
	</view>
</template>

<script>
	import mIcon from '../../components/uni-icons/uni-icons.vue'
	export default{
		components:{
			mIcon
		},
		data(){
			return{
				Musername:'',
				Mpassword:'',
				Mpassword1:'',
			}
		},
		methods:{
			registerM:function(){
				console.log(this.Musername)
				console.log(this.Mpassword)
				console.log(this.Mpassword1)
				let r = new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+`\-={}:";'<>,.\/]).{6,10}/)
				if(this.Musername === '')
				{
					uni.showToast({
						title:"用户名不能为空",
						icon:'none'
					})
				}
				else if(!r.test(this.Mpassword))
				{
					uni.showToast({
						title:'密码规则为：6-10位包含数字、字母、特殊字符的字串',
						icon:"none"
					})
				}
				else if(this.Mpassword !== this.Mpassword1)
				{
					uni.showToast({
						title:'两次输入的密码不一致！',
						icon:'none'
					})
				}
				else{
					console.log(this.Musername)
					console.log(this.Mpassword)
					console.log(this.Mpassword1)
					uni.request({
						url:'http://127.0.0.1/Question/Yii/backend/web/index.php/home/index/register',
						method:'POST',
						header: {
							'content-type': 'application/x-www-form-urlencoded', 
						},
						data:{
							username:this.Musername,
							password:this.Mpassword
						},
						// console.log(this.Musername)
						// console.log(this.Mpassword)
						
						success: (res) => {
							console.log(res.data)
							if(res.data.message=="注册成功"){
								uni.showToast({
									title:"注册成功",
									icon:"success"
								})
								uni.reLaunch({
									url:'./login'
								})
							}
							else{
								uni.showToast({
									title:res.data.message,
									icon:'none'
								})
							}
						}
						})
				}
				
				
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
		margin-left: 20rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
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
	    text-align: center;
	    width: auto;
	  }
</style>
