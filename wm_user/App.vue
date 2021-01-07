<script>
	import user from '@/api/user.js'
	import Api_url from '@/common/config.js'
	export default {
		onLaunch: function() {
			// #ifdef MP-WEIXIN
				uni.login({
					provider:'weixin',
					success: function (loginRes) {
						let data={'code':loginRes.code}
						user.get_xcx_token(data).then(res=>{
							uni.setStorageSync('token',res.data.token)
						})
					  }
				})
			// #endif
			// #ifdef H5
				//微信公众号获取token -必须是认证的服务号 
				var ua = navigator.userAgent.toLowerCase();
				var isWeixin = ua.indexOf('micromessenger') != -1;
				if (!isWeixin) { 
					console.log("非公众号-暂不登陆")
				    return false;
				}
				uni.request({
					url:Api_url+'weixin/gzh_code',
					method:'GET',
					success: (res) => {
						console.log(res)
					}
				})
				
			// #endif
		},
		onShow: function() {
		},
		onHide: function() {
		}
	}
</script>

<style lang="scss">
	@import '~@/static/styles/app.scss';
</style>
