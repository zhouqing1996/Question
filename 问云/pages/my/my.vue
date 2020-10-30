<template>
	<view v-if="hasLogin">
		<!-- 已经登录的用户 -->
		<view>
			<view class="usertop">
				<!-- 图片 -->
				<image src="../../static/images/yonghu.png" class="images"></image>
				<!-- 用户名 -->
				<view class="username">
					<view>{{username}}</view>
					<!-- 角色 -->
					<view>
						<view v-if="role==1">
							身&nbsp;&nbsp;&nbsp;份：教师
						</view>
						<view v-if="role==3">
							身&nbsp;&nbsp;&nbsp;份：学生
						</view>
					</view>
				</view>
			</view>
			<!-- 编辑资料 -->
			<view>
				<view class="listinfo">
					<uni-list>
						<block v-for="list in listData">
							<uni-list-item :title="list.title" :thumb="list.img" @click="clickBtn(list.id)"></uni-list-item>
						</block>
					</uni-list>
				</view>
				<view>
					<image src="../../static/images/geren.png" class="kongbai"></image>
				</view>
				<view>
					<button @click="loginout" class="btn"><image src="../../static/images/tuichu.png" class="images1"></image>退出登录</button>
				</view>
			</view>
		</view>
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
		// computed:mapState(['hasLogin','userInfo']),
		data(){
			return{
				hasLogin:false,
				username:"",
				role:0,
				
				listData:[{
					"id":"1",
					"title":"个人资料",
					"img":"../../static/images/yonghu.png"
					},
					{
						"id":"2",
						"title":"修改密码",
						"img":"../../static/images/yonghu.png"
					}
				],
				
			}
		},
		methods:{
			bindLogin:function(){
				console.log(this.hasLogin)
				uni.reLaunch({
					url:'./login'
				})
			},
			clickBtn:function(i){
				console.log(i)
				if(i==="1"){
					// 查看个人资料
					uni.showToast({
						title:"个人资料"
					})
					
				}
				else if(i ==="2")
				{
					// 修改密码
					// uni.showToast({
					// 	title:"修改密码"
					// })
					uni.navigateTo({
						url:'./changepwd'
					})
				}
			},
			loginout:function()
			{
				uni.showModal({
					title:"提示",
					content:"继续退出?",
					success: (res) => {
						if(res.confirm)
						{
							uni.reLaunch({
								url:'./login'
							})
						}
					}
				})
			}
			
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
	.usertop{
		width: 100%;
		height: 200rpx;
		margin-left: 20rpx;
		margin-top: 20rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
		/* background-color:#E5E5E5; */
	}
	.images{
		width: 20%;
		height: 150rpx;
		float: left;
	}
	.username{
		color: #333333;
		margin-top: 50rpx;
		margin-left: 200rpx;
		margin-bottom: 10rpx;
		font-size: 35rpx;
		font-weight: bold;
		text-align: left;
		line-height: 60rpx;
		top: 50%;
	}
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
	.btn {
		margin-top: 50rpx;
		font-size: 32rpx;
		text-align: center;
		width: 50%;
		height: auto;
		
	}
	.listinfo {
		padding: 20upx;
		background-color: #ffffff;
		margin: 20upx 0;
	}
	.kongbai{
		text-align: center;
	}
	.images1{
		float: left;
		width: 80rpx;
		height: 80rpx;
	}
</style>
