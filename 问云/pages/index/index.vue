<template>
	<view v-if="hasLogin">
		<view v-if="role==1">
			<!-- 管理员 -->
			<image src="../../static/images/notData.png"></image>
			<view class="icon">
				<view class="item" @click="personal">
					<view>
						<image src="../../static/images/person.png" style="width: 60rpx;height: 60rpx;"></image>
						<view class="menu">个人信息</view>
					</view>
				</view>
				<view class="item" @click="webData">
					<view>
						<image src="../../static/images/web.png" style="width: 60rpx;height: 60rpx;"></image>
						<view class="menu">网站信息</view>
					</view>
				</view>
				<view class="item" @click="dataAn">
					<view>
						<image src="../../static/images/tongji.png" style="width: 60rpx;height: 60rpx;"></image>
						<view class="menu">统计分析</view>
					</view>
				</view>
			</view>
			<image src="../../static/images/success.png"></image>
		</view>
		<!-- 学生 -->
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
	export default {
		data() {
			return {
				hasLogin:false,
				username:"",
				role:0,
			}
		},
		methods: {
			bindLogin:function(){
				console.log(this.$store.getters.getHasLogin)
				uni.reLaunch({
					url:'../my/login'
				})
			},
			personal:function(){
				if(this.role==1){
					uni.navigateTo({
						url:'../admin/person'
					})
				}
				else{
					uni.navigateTo({
						url:'../user/person'
					})
				}
			},
			webData:function(){
				if(this.role==1){
					uni.navigateTo({
						url:'../admin/adminAll'
					})
				}
				else{
					uni.navigateTo({
						url:'../user/weball'
					})
				}
			},
			dataAn:function(){
				if(this.role==1){
					uni.navigateTo({
						url:'../admin/adminAn'
					})
				}
				else{
					uni.navigateTo({
						url:'../user/personAN'
					})
				}
			},
			s:function(i){
				if(i=='1'){
					// 个人内容
					if(this.role==1){
						// 管理员
						console.log("11")
					}
					else{
						// 学生
						console.log("12")
					}
				}
				else if(i == '2'){
					// 全站信息
					if(this.role==1){
						// 管理员
						console.log("21")
					}
					else{
						// 学生
						console.log("31")
					}
				}
				else if(i=='3'){
					// 数据分析
					if(this.role==1){
						// 管理员
						console.log("31")
					}
					else{
						// 学生
						console.log("32")
					}
				}
			}
		},
		created() {
			if(this.$store.getters.getsId){
				this.hasLogin =true,
				this.username = this.$store.getters.getsName,
				this.role = this.$store.getters.getsRole
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
	.container {
		padding: 20px;
		font-size: 14px;
		line-height: 24px;
	}
	.icon{
		display: flex;
		flex-direction: row;
		margin-top: 30px;
	}
	.item{
		width: 25%;
		text-align: center;
		margin: 0 auto;
	}
	.menu{
		font-size: 11px;
		width:100px;
	}
</style>
