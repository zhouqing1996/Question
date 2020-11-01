<template>
	<view>
		<view class="wenti">
			<h3>
				<view class="typename">{{qList.typename}}
				</view>
			{{qList.title}}</h3>
			    <view><i class="el-icon-user"></i> {{qList.uid}}</view>
			    <view><i class="el-icon-date"></i> {{qList.ctime}}</view>
			    <hr>
			        <view v-html="qList.content">
			          {{qList.content}}
			        </view>
		</view>
	</view>
</template>

<script>
	export default{
		data(){
			return{
				qid:'',
				uid:'',
				qList: {
				  id:'',
				  title:'',
				  content:'',
				  ctime:'',
				  uid:'',
				  typename:''
				},
				typeList:[],
				userList:[]
				
			}
		},
		onLoad(opt){
			this.qList.id = opt.id
			this.qList.title=opt.title
			this.qList.uid = opt.uid
			this.qList.ctime = opt.ctime
			this.qList.content = opt.content
			this.qList.typename = opt.type
			console.log(this.qList)
		},
		methods:{
			// getList:function () {
			//   let that =this
			//   this.$http.post('/yii/question/index/query',{
			// 	flag:5,
			// 	qid:that.qid,
			//   }).then(function (res) {
			// 	console.log(res.data)
			// 	let List = res.data.data[0]
			// 	that.qList.id=List.id
			// 	that.qList.title=List.title
			// 	that.qList.content=List.content
			// 	that.qList.ctime=List.ctime
			// 	that.qList.uid=that.getUserName(List.uid)
			// 	that.qList.typename= that.getTypeName(List.type)
			// 	console.log(that.qList)
			//   }).catch(function (error) {
			// 	console.log(error)
			//   })
			// },
			// getType:function(){
			// 	uni.request({
			// 		header: {
			// 			'content-type': 'application/x-www-form-urlencoded', 
			// 		},
			// 		method:'POST',
			// 		url:'http://127.0.0.1/Question/Yii/backend/web/index.php/question/index/query',
			// 		data:{
			// 			flag:2
			// 		},
			// 		success: (res) => {
			// 			console.log(res.data)
			// 			this.typeList = res.data.data
			// 			this.leftData = res.data.data
			// 		}
					
			// 	})
			// },
			// getTypeName:function(tid){
			// 	for (let i =0 ;i<this.typeList.length;i++)
			// 	{
			// 		if(tid == this.typeList[i].id){
			// 			return this.typeList[i].typename
			// 		}
			// 	}
			// },
			// getUser:function(){
			// 	uni.request({
			// 		header: {
			// 			'content-type': 'application/x-www-form-urlencoded', 
			// 		},
			// 		method:'POST',
			// 		url:'http://127.0.0.1/Question/Yii/backend/web/index.php/home/user/query',
			// 		data:{
			// 			flag:2
			// 		},
			// 		success: (res) => {
			// 			console.log(res)
			// 			this.userList =res.data.data
			// 		}
					
			// 	})
			// },
			// getUserName:function(uid){
			// 	for(let i=0;i<this.userList.length;i++){
			// 		if(uid == this.userList[i].id){
			// 			return this.userList[i].username
			// 		}
			// 	}
			// },
		},
		created() {
			// this.getType()
			// this.getUser()
			// this.getList()
		},
		mounted() {
			// this.getType()
			// this.getUser()
			// this.getList()
		}
	}
</script>

<style>
	.back{
	    margin-top: 30px;
	    margin-bottom: 20px;
	  }
	  .waimian{
	    margin-top: 10px;
	    padding: 10px;
	    background-color: aliceblue;
	    margin-left: 20px;
	    margin-right: 20px;
	    border: white;
	    width: auto;
	  }
	  .wenti{
	    margin-top: 20px;
	    margin-left: 20px;
	    margin-right: 20px;
	    height: auto;
	    text-align: left;
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
</style>
