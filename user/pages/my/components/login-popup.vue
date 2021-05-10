<template>
	<uni-popup ref="popup" type="bottom" @change="change">
		<view class="popup-content d-flex flex-column">
			<view class="d-flex justify-content-end">
				<image src="/static/images/common/clousex-big.png" class="close_btn" @tap="close"></image>
			</view>
			<view class="d-flex flex-fill flex-column justify-content-between">
				<view class="d-flex flex-column">
					<view class="font-size-extra-lg font-weight-bold text-color-base mb-30">欢迎登陆如花-外卖点餐</view>
					<view class="font-size-base text-color-assist">登录后消费可获取积分，享受更好的服务体验</view>
				</view>
				<view class="d-flex flex-column">
					<!-- #ifdef MP-WEIXIN -->
					<button  type="primary" class="w-100 font-size-lg mb-30" style="font-size: 30rpx;height: 45px;line-height: 45px;" v-if="canIUseGetUserProfile" size="mini"
						@click="getUserProfile"> 获取头像昵称 </button>
					<button v-else type="primary" class="w-100 font-size-lg mb-30" open-type="getUserInfo"
						@getuserinfo="getUserInfo">微信一键登陆</button>
					<!-- #endif -->
					<!-- #ifdef H5 -->
					<button type="primary" class="w-100 font-size-lg mb-30" @click="getUserInfo">微信一键登陆</button>
					<!-- #endif -->
					<view class="text-center mb-30 font-size-sm text-color-assist">
						点击登陆如花-外卖点餐，即表示已阅读并同意
						<font class="text-color-primary">《如花隐私政策》</font>
					</view>
					<view class="text-center font-primary font-size-sm text-color-primary">《如花-外卖点餐服务指南》</view>
				</view>
			</view>
		</view>
	</uni-popup>
</template>

<script>
	import uniPopup from '@/components/uni-popup/uni-popup.vue';
	import {
		mapMutations
	} from 'vuex';
	import user from '@/api/user.js';
	import {
		Api_url
	} from '../../../config.js'

	export default {
		name: 'LoginPopup',
		components: {
			uniPopup
		},
		data() {
			return {
				canIUseGetUserProfile: false,
				login: false
			}
		},
		props: {},
		created() {
			// #ifdef MP-WEIXIN						
			if (wx.getUserProfile) {
				console.log("新授权")
				this.canIUseGetUserProfile = true
			} else {
				console.log("老授权")
			}
			// #endif
		},
		methods: {
			getUserProfile(e) {
				// #ifdef MP-WEIXIN	 
				const that = this
				this.login = false
				wx.getUserProfile({
					desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
					success: (res) => {
						console.log('profile:', res.userInfo)
						if (res.userInfo) {
							console.log('rrr')
							const user = res.userInfo
							that.UpUser(user, res.encryptedData, res.iv)
						}
					}
				})
				// #endif	
			},
			open() {
				this.$refs['popup'].open();
			},
			close() {
				this.$refs['popup'].close();
			},
			change({
				show
			}) {
				this.$emit('change', show);
			},
			UpUser(user, keys, iv) {
				const that = this
				
				console.log('3333')
				that.$emit('getInfo',user);
				// uni.request({
				// 	url: Api_url + 'weixin/upinfo',
				// 	method: 'POST',
				// 	data: {
				// 		nickname: user.nickName,
				// 		headpic: user.avatarUrl,
				// 		keys,
				// 		iv
				// 	},
				// 	header: {
				// 		token: uni.getStorageSync("token")
				// 	},
				// 	success: function(res) {
				// 		console.log('auth/upinfo',res)
				// 		// that.$emit('userinfo', user)
				// 		// that.$emit('getInfo',user);
				// 	},
				// });
			},
			async getUserInfo(e) {
				const that = this
				console.log('跳转微信')
				// #ifdef H5
				window.location.href = 'http://mail.ruhuashop.com/weixin/gzh_code'
				// #endif
				// #ifdef MP-WEIXIN
				//请配置AppID，否则获取失败
				if (e.target.errMsg !== 'getUserInfo:ok') {
					uni.showModal({
						title: '提示',
						content: '您已取消了授权，请重新授权登录',
						showCancel: false
					});
					return;
				}
				// 获取用户信息
				// await uni.getUserInfo({
				// 	provider: 'weixin',
				// 	success: function(infoRes) {
				// 		user.upinfo(infoRes.userInfo).then(res => {
				// 			return true;
				// 		});
				// 	}
				// })
				await uni.getUserInfo({
					success: data => {
						let user = data.userInfo
						that.UpUser(user, data.encryptedData, data.iv)
					}
				})
				this.$emit('auto');
				// #endif


				// this.close();
			}
		}
	};
</script>

<style lang="scss" scoped>
	.popup-content {
		background-color: #ffffff;
		border-radius: 24rpx 24rpx 0 0;
		height: 50vh;
		padding: 50rpx 40rpx;
	}

	.close_btn {
		width: 40rpx;
		height: 40rpx;
	}
</style>
