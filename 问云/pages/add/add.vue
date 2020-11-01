<template>
	<view v-if="hasLogin">
		<!-- <view v-if="role==1">管理员</view>
		<view v-else>学生</view> -->
		<view>
			<!-- <h3>添加问题</h3> -->
			<view class="item">
				<view class="item1">问题题干：</view>
				<textarea placeholder="问题题干" v-model="form.item" class="item2">
					
				</textarea>
			</view>
			<view class="ans">
				<view class="ans1">解决办法：</view>
				<textarea placeholder="解决办法" v-model="form.ans" class="ans2">
				</textarea>
			</view>
			<view class="type">
				<view v-if="typeFlag==true">
					<picker @change="ChangePicker" :range="type" :value="index">
						<label>选择类别：</label>
						<label style="color: #4CD964;">{{type[index]}}</label>
					</picker>
				</view>
				<button @click="ClickNew" class="new">新建分类</button>
				<button @click="submit" class="btnsubmit">提交答案</button>
				<view v-if="newflag==true">
					<input placeholder="分类名" v-model="form.type" class="in"/>
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
	export default{
		data(){
			return{
				hasLogin:false,
				username:"",
				role:0,
				uid:'',
				form:{
					item:'',
					ans:'',
					type:'',
				},
				typelist:[],
				type:['--选择--'],
				typeFlag:true,
				index:0,
				newType:'',
				newflag:false
				
			}
		},
		methods:{
			bindLogin:function(){
				uni.reLaunch({
					url:'../my/login'
				})
			},
			ChangePicker:function(e){
				this.index = e.target.value
				this.form.type = this.type[this.index]
				console.log(this.form.type)
			},
			ClickNew:function(){
				if(this.newflag == true)
				{
					this.newflag = false
				}
				else{
					this.newflag = true
				}
			},
			submit:function(){
			  if(this.form.ans.length==0)
			  {
				  uni.showToast({
				  	title:'内容为空！',
					icon:'none'
				  })
			}
			  else if(this.form.item.length==0)
			  {
				uni.showToast({
					title:'题目为空！',
					icon:'none'
				})
			  }
			  else if(this.form.type.length==0){
					uni.showModal({
						title:'提示',
						content:'类型尚未设置，默认为 未知',
						success:(res)=>{
							if(res.confirm){
								this.form.type = '未知'
								uni.request({
									url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/uaddquestion',
									method:'POST',
									data:{
										title:this.form.item,
										content:this.form.ans,
										type:this.form.type,
										uid:this.uid
									},
									header: {
										'content-type': 'application/x-www-form-urlencoded', 
									},
									success:(res)=>{
										
									}
								})
							}
							else{
								return
							}
						}
					})
				}
				else {
				  uni.request({
				  	url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/uaddquestion',
				  	method:'POST',
				  	data:{
				  		title:this.form.item,
				  		content:this.form.ans,
				  		type:this.form.type,
				  		uid:this.uid
				  	},
				  	header: {
				  		'content-type': 'application/x-www-form-urlencoded', 
				  	},
				  	success:(res)=>{
				  		
				  	}
				  })
				}
			},
			getType:function(){
				this.typelist=[]
				uni.request({
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/uquery',
					method:'POST',
					data:{
						flag:2,
						uid:this.uid
					},
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					success: (res) => {
						console.log(res.data)
						let list =res.data.data
						if(list.length==0)
						{
							this.typeFlag =false
						}
						else{
							for(let i=0;i<list.length;i++)
							{
								this.typelist.push({
									id:list[i].id,
									typename:list[i].typename
								})
								this.type.push(list[i].typename)
							}
							this.typeFlag =true
						}
					}
					
				})
			}
			
		},
		created() {
			if(this.$store.getters.getsId){
				this.hasLogin =true,
				this.username = this.$store.getters.getsName
				this.role = this.$store.getters.getsRole
				this.uid = this.$store.getters.getsId
				this.getType()
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
	.item{
		margin-top: 20rpx;
		margin-bottom: 20rpx;
		font-size: 20rpx;
		width: 80%;
		height: 200rpx;
		
	}
	.item2{
		height: 100rpx;
		margin-top: 30rpx;
		outline-style: none ;
		border: 1px solid #ccc; 
		border-radius: 3px;
		padding: 13px 14px;
		margin-left: 10rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
		width: 100%;
		float: left;
	}
	.ans{
		margin-top: 20rpx;
		margin-bottom: 20rpx;
		font-size: 20rpx;
		width: 80%;
		height: 200rpx;
	}
	.ans2{
		height: 200rpx;
		margin-top: 30rpx;
		outline-style: none ;
		border: 1px solid #ccc; 
		border-radius: 3px;
		padding: 13px 14px;
		margin-left: 10rpx;
		margin-right: 20rpx;
		margin-bottom: 20rpx;
		width: 100%;
		float: left;
	}
	.type{
		margin-top: 10rpx;
		float: left;
		width: auto;
		margin-left: 10rpx;
		height: auto;
		font-size: 25rpx;
		margin-bottom: 40rpx;
	}
	.in{
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
		font-size: 25rpx;
	}
	.new{
		margin-top: 20rpx;
		margin-left: 20rpx;
		width: auto;
		padding: 2rpx;
		background-color: #357ebd;  
		color: #fff;  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		border-radius: 10px; 
		-khtml-border-radius: 10px; 
		font-size: 25rpx;
		float: left;
	}
	.btnsubmit{
		margin-top: 20rpx;
		margin-left: 20rpx;
		width: auto;
		padding: 2rpx;
		background-color: #357ebd;  
		color: #fff;  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		border-radius: 10px; 
		-khtml-border-radius: 10px; 
		font-size: 25rpx;
		float: right!important;
	}
</style>
