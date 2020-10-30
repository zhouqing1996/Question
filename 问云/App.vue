<script>
	import {mapMutations} from 'vuex';
export default {
	methods:{
		...mapMutations(['login'])
	},
	onLaunch: function() {
		// console.log('App Launch');
		let userInfo = uni.getStorageSync('userInfo')||'';
		if(userInfo.id){
			uni.getStorage({
				key:'userInfo',
				success:(res)=>{
					this.login(res.data.data);
					// console.log(res.data.data)
				}
			})
		}
	},
	onShow: function() {
		console.log('App Show');
	},
	onHide: function() {
		console.log('App Hide');
	},
	
};
</script>

<style>
/* 解决头条小程序组件内引入字体不生效的问题 */
/* #ifdef MP-TOUTIAO */
@font-face {
	font-family: uniicons;
	src: url('/static/uni.ttf');
}
/* #endif */
</style>
