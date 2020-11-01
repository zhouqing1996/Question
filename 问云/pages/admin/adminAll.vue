<template>
	<view>
		<view class="serach">
			<input v-model="serach" placeholder="搜索" class="sinput"/>
			<button @click="serachA" class="sbutton">搜索</button>
		</view>
		<scroll-view class="leftList">
			<view @click="getRightList" class="leftItem">
				<view >全部类型</view>
			</view>
			<view v-for="(item,ix) in leftData" :key="ix" class="leftItem">
				<view @click="Click(item.id)">{{item.typename}}</view>
			</view>
		</scroll-view>
		<scroll-view class="rightList" >
			<view v-for="(itemr,ix) in rightData" :key="ix" class="rightItem">
				<view @click="view(itemr.id,itemr.title,itemr.uid,itemr.ctime,itemr.content,itemr.type)">
					<view class="typename">{{itemr.type}}</view>
					<view class="title">{{itemr.title}}</view>
					<rich-text :nodes="itemr.content" class="content"></rich-text>
				</view>
				<view >
					<view class="Im">
						<image src="../../static/images/avter.png" class="avter">
						</image>
						<view class="name">{{itemr.uid}}</view>
					</view>
				</view>
				<view class="time fr">{{itemr.ctime}}<view class="time fr" @click="sdelete(itemr.id)">
					删除
				</view></view>
				
			</view>
		</scroll-view>
	</view>
</template>

<script>
	import graceRichText from '../../components/richText.js'
	export default{
		data(){
			return{
				leftData:[],
				rightData:[],
				typeList:[],
				userList:[],
				serach:''
			}
		},
		methods:{
			view:function(id,title,uid,ctime,content,type){
				console.log(id)
				let list = []
				list.push({
					id:id,
					title:title,
					uid:uid,
					ctime:ctime,
					content:content,
					type:type
				})
				uni.navigateTo({
					url:'./view?id='+id+'&title='+title+'&uid='+uid+'&ctime='+ctime+'&content='+content+'&type='+type
				})
			},
			serachA:function(){
				console.log(this.serach)
				if(this.serach==''){
					uni.showToast({
						title:"搜索的内容为空",
						icon:'none'
					})
				}
				else{
					uni.navigateTo({
						url:'./viewQuestion?search='+this.serach
					})
				}
			},
			sdelete:function(id){
				console.log(id)
				uni.showModal({
					title:'提醒',
					content:"是否删除该问题",
					success:(res)=>{
						if(res.confirm)
						{
							uni.request({
								header: {
									'content-type': 'application/x-www-form-urlencoded', 
								},
								method:'POST',
								url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/delete',
								data:{
									qid:id
								},
								success:(res)=>{
									this.rightData = []
									this.getRightList()
									uni.showToast({
										title:"删除成功",
										icon:'success'
									})
								}
							})
						}
					}
				})
			},
			getType:function(){
				uni.request({
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					method:'POST',
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/query',
					data:{
						flag:2
					},
					success: (res) => {
						console.log(res.data)
						this.typeList = res.data.data
						this.leftData = res.data.data
					}
					
				})
			},
			getTypeName:function(tid){
				for (let i =0 ;i<this.typeList.length;i++)
				{
					if(tid == this.typeList[i].id){
						return this.typeList[i].typename
					}
				}
			},
			getUser:function(){
				uni.request({
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					method:'POST',
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/home/user/query',
					data:{
						flag:2
					},
					success: (res) => {
						console.log(res)
						this.userList =res.data.data
					}
					
				})
			},
			getUserName:function(uid){
				for(let i=0;i<this.userList.length;i++){
					if(uid == this.userList[i].id){
						return this.userList[i].username
					}
				}
			},
			Click:function(tid){
				uni.request({
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					method:'POST',
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/query',
					data:{
						flag:4,
						id:tid
					},
					success: (res) => {
						console.log(res)
						let List = res.data.data
						this.rightData = []
						for(let i=0;i<List.length;i++){
							this.rightData.push({
								id:List[i].id,
								title:List[i].title,
								content:List[i].content,
								type:this.getTypeName(List[i].type),
								uid:this.getUserName(List[i].uid),
								ctime:List[i].ctime
							})
						}
					}
				})
			},
			
			getRightList:function(){
				uni.request({
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					method:'POST',
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/query',
					data:{
						flag:1
					},
					success: (res) => {
						console.log(res)
						let List = res.data.data
						this.rightData = []
						for(let i=0;i<List.length;i++){
							this.rightData.push({
								id:List[i].id,
								title:List[i].title,
								content:List[i].content,
								type:this.getTypeName(List[i].type),
								uid:this.getUserName(List[i].uid),
								ctime:List[i].ctime
							})
						}
					}
					
				})
			},
		},
		created() {
			this.getType()
			this.getUser()
			this.getRightList()
		},
		mounted() {
			this.getType()
			this.getUser()
			this.getRightList()
		}
	}
</script>

<style>
	.serach{
		width: 100%;
		margin-bottom: 10rpx;
		float: left;
		table-layout: fixed;
	}
	.sbutton{
		display: inline-block;
		height: auto;
		margin-bottom: 20rpx;
		float: left;
		width: auto;
		margin-top: 30rpx;
		border-radius: 5px;
		padding: 13px 14px;
		font-size: 14rpx;
		color: #F0AD4E;
	}
	.sinput{
		height: auto;
		margin-top: 30rpx;
		outline-style: none ;
		border: 1px solid #ccc; 
		border-radius: 5px;
		padding: 13px 14px;
		margin-left: 100rpx;
		margin-bottom: 20rpx;
		margin-right: 30rpx;
		float: left;
		width: auto;
	}
	.leftList{
		width: 30%;
		height: auto;
		float: left;
		color:#FFFFFF;
		background-color: #C0C0C0;
		line-height: 30rpx;
	}
	.leftItem{
		width: auto;
		font-size: 40rpx;
		text-align: left;
		margin-top: 40rpx;
		margin-bottom: 20rpx;
		margin-left: 20rpx;
		/* border: 1px solid #DD524D; */
 	}
	.leftItem:focus{
		color: #007AFF;
	}
	.leftItem:active{
		color: #4CD964;
	}
	.rightList{
		width: 70%;
		height: auto;
		display:inline-block;
	}
	.rightItem{
		border-collapse: collapse;
		width: 80%;
		margin-top: 5px;
		table-layout: fixed;
		white-space:nowrap;
		overflow:hidden;
		text-overflow: ellipsis;
		padding: 5px;
		text-align: left;
		font-size: 18px;
		border-bottom: 1px solid #f0f2f5;
		position: relative;
	}
	.typename{
	    color: #e33e33;
	    background-color: rgba(227,62,51,0.1);
	    display: inline-block;
	    -webkit-box-sizing: border-box;
	    box-sizing: border-box;
	    width: auto;
	    height: 20px;
	    line-height: 20px;
	    text-align: center;
	    font-size: 12px;
	    border-radius: 2px;
	  }
	  .fr{
	    float: right!important;
	  }
	  .time{
	    font-size: 12px;
	    color: #000;
	  }
	  .avter{
	      display: flex;
	      width: 24px;
	      height: 24px;
	      border-radius: 50%;
	      -o-object-fit: cover;
	      object-fit: cover;
	      overflow: hidden;
	    }
	.title{
	    display: inline-block;
	    font-size: 20px;
	    color: #000;
	    line-height: 30px;
	    padding-bottom: 4px;
	    font-weight: bold;
	    padding-left: 36px;
	  }
	  .content{
	    margin-top: 6px;
	    font-size: 14px;
	    line-height: 22px;
	    white-space: normal;
	    color: #999aaa;
	    display: block;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    display: -webkit-box;
	    -webkit-line-clamp: 2;
	    -webkit-box-orient: vertical;
	  }
	  .Im{
	      vertical-align: middle;
	      align-items: center;
	      justify-content: center;
	      display: flex;
	      float: left;
	    }
	    .name{
	      float: left;
	      font-size: 14px;
	      color: #8a8a8a;
	      line-height: 24px;
	      margin-top: 0;
	    }
</style>
