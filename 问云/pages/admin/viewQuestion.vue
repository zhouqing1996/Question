<template>
	<view>
		<view v-for="item in result">
			<view class="typename">{{item.type}}</view>
			<view class="title">{{item.title}}</view>
			<rich-text :nodes="item.content" class="content"></rich-text>
			<view >
				<view class="Im">
					<image src="../../static/images/avter.png" class="avter">
					</image>
					<view class="name">{{item.uid}}</view>
				</view>
			</view>
			<view class="time fr">{{item.ctime}}</view>
		</view>
	</view>
</template>

<script>
	export default{
		data(){
			return{
				name:'',
				result:[]
			}
		},
		methods:{
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
			Query:function(){
				uni.request({
					header: {
						'content-type': 'application/x-www-form-urlencoded', 
					},
					method:'POST',
					url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/query',
					data:{
						flag:3,
						name:this.name
					},
					success:(res)=>{
						console.log(res)
						let List = res.data.data
						this.result = []
						for(let i=0;i<List.length;i++){
							this.result.push({
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
			}
		},
		onLoad(opt){
			this.name = opt.search
			console.log(this.name)
		},
		created(){
			this.Query()
			this.getType()
			this.getUser()
		},
		mounted(){
			this.getType()
			this.getUser()
		}
	}
</script>

<style>
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
