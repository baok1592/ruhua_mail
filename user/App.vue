<script>
	import {
		WxToken
	} from './common/wx_token.js'
	import user from '@/api/user.js'
	
	import {Api_url} from './common/config.js'
	var wxtoken = new WxToken();
	export default {
	 	async onLaunch() {
			// #ifdef MP-WEIXIN
			console.log(Api_url)
			uni.login({
				provider: 'weixin',
				success: function(loginRes) {
					let data = {
						'code': loginRes.code
					}
					user.get_xcx_token(data).then(res => {
						uni.setStorageSync('token', res.data.token)
						user.get_info().then(res=>{
							uni.setStorageSync('sfm',res.data.invite_code)
						})
					})
				}
			})
			// #endif
			// #ifdef H5
			var ua = navigator.userAgent.toLowerCase();
			var isWeixin = ua.indexOf('micromessenger') != -1;
			if (!isWeixin) { 
				console.log("非公众号-暂不登陆")
			    return false;
			}
			// wxtoken.verify('userinfo'); //静默获取openid	
			//微信公众号获取token -必须是认证的服务号 
			let token =  uni.getStorageSync('token')
				
			if(!token){
				console.log(Api_url+'weixin/gzh_code')
				window.location.href = Api_url+'weixin/gzh_code'
			}
			
			// uni.request({
			// 	url:Api_url+'weixin/gzh_code',
			// 	method:'GET',
			// 	success: (res) => {
			// 		console.log(res)
			// 		// window.location.href = res.request_url;
			// 	}
			// })

			// #endif
		},
		onShow: function() {},
		onHide: function() {}
	}
</script>

<style lang="scss">
	@import '~@/static/styles/app.scss';
</style>
