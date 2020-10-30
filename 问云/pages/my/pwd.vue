<template>
	<div class="login-continer">
		<h3 class="title">找回密码</h3>
		<view class="shuru">
			<view>
				<image src="../../static/images/wode1.png" class="image"></image>
				<input type="text" v-model="Musername" placeholder="用户名" class="i"/>
			</view>
			<view>
				<image src="../../static/images/mima.png" class="image"></image>
				<input type="password" v-model="Mpassword" placeholder="密码为6~10位包含数字/字母/下划线的组合"  class="i"/>
			</view>
			<view>
				<image src="../../static/images/mima.png" class="image"></image>
				<input type="password" v-model="Mpassword1" placeholder="再次输入新密码"  class="i"/>
			</view>
		</view>
		<button type="primary" v-on:click="Forget" class="btnlogin">确定</button>
		<p class="other">
			<navigator url="./register" open-type="redirect">没有账号，注册账号</navigator>
			<navigator url="./login" open-type="redirect">有账号，直接登录</navigator>
		</p>
	</div>
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
			Forget:function(){
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
					uni.request({
						url:'http://127.0.0.1/Question/Yii/backend/web/index.php/home/index/forget',
						method:'POST',
						header: {
							'content-type': 'application/x-www-form-urlencoded', 
						},
						data:{
							username:this.Musername,
							password:this.Mpassword
						},
						success: (res) => {
							console.log(res.data)
							if(res.data.message==="修改密码成功")
							{
								uni.showToast({
									icon:'success',
									title:res.data.message
								})
								uni.reLaunch({
									url:'./login'
								})
							}
							else{
								uni.showToast({
									icon:'none',
									title:res.data.message
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
