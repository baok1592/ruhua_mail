<template>
	<view class="container">
		<uni-nav-bar fixed backgroundColor="#424141" left-icon="arrowleft" color="#ffffff" @clickLeft="back"></uni-nav-bar>
		<view class="bg"></view>
		<view class="main">
			<view class="userinfo">
				<image class="avatar" :src="info.headpic"></image>
				<view class="username">{{info.nickname}}</view>
				<!-- <view class="desc">使用钱包喜茶钱包支付（您还未开通喜茶钱包）</view> -->
			</view>
			<view class="code-section">
				<view class="mb-20">我的二维码</view>
				<!-- #ifdef MP-WEIXIN -->
				<view class="ewm">
					<image class="img" :src="ewm_url" mode=""></image>
				</view>
				<!-- #endif -->
				
				<!-- qrcode begin -->
				<!-- #ifdef H5 -->
				<canvas canvas-id="memberCode" style="width: 350rpx; height: 350rpx;"></canvas>
				<!-- #endif -->
				
				<!-- qrcode end -->
				<view class="tips">打开微信扫一扫</view>
			</view>
		</view>
	</view>
</template>

<script>
	import uQRCode from '@/common/uqrcode'
	import uniNavBar from '@/components/uni-nav-bar/uni-nav-bar.vue'
	import userModel from '@/api/user.js'
	
	export default {
		components: {
			uniNavBar
		},
		data() {
			return {
				api: this.$getimg,
				info: {},
				ewm_url: '',
			}
		},
		onLoad(options) {
			
			this.getInfo();
			// let sfm = uni.getStorageSync('sfm')
			
		},
		methods: {
			show_data() {
				this.getInfo();
			},
			getInfo() {
				const _this = this;
				userModel.get_info().then(res => {
					_this.info = res.data;
					// #ifdef H5
					_this.ewm_url = res.data.h5;
					this.makeMemberCode(res.data.invite_code)
					// #endif
					// #ifdef MP-WEIXIN
					_this.ewm_url = res.data.invite_url;
					// #endif
					
				})
			},
			back() {
				uni.navigateBack()
			},
			makeMemberCode(sfm) {
				// #ifdef H5
					uQRCode.make({
						canvasId: 'memberCode',
						componentInstance: this,
						text: this.api+'/h5?sfm='+sfm,
						size: uni.upx2px(350),
						margin: 20,
						backgroundColor: '#ffffff',
						foregroundColor: '#000000',
						fileType: 'jpg',
						correctLevel: uQRCode.defaults.correctLevel,
						success: res => {
							console.log(res)
						}
					})
				// #endif
				// #ifdef MP-WEIXIN
				
				// #endif
			},
		}
	}
</script>

<style lang="scss" scoped>
.container {
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	background-color: #FFFFFF;
}

.bg {
	background-color: #424141;
	height: 25vh;
	/* #ifdef H5 */
	height: calc(25vh - 44px);
	/* #endif */
}

.main {
	flex: 1;
	display: flex;
	flex-direction: column;
}

.userinfo {
	display: flex;
	flex-direction: column;
	align-items: center;
	border-bottom: 1rpx solid rgba($color: $border-color, $alpha: 0.6);
	
	.avatar {
		position: relative;
		width: 140rpx;
		height: 140rpx;
		border-radius: 100%;
		margin-top: -70rpx;
		margin-bottom: 20rpx;
	}
	
	.username {
		font-size: $font-size-extra-lg;
		font-weight: bold;
		margin-bottom: 50rpx;
	}
	
	.desc {
		font-size: $font-size-sm;
		color: $text-color-assist;
		margin-bottom: 20rpx;
	}
}

.code-section {
	flex: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	font-size: $font-size-base;
	color: $font-size-base;
	
	.tips {
		font-size: $font-size-sm;
		color: $text-color-assist;
	}
	
	.ewm {
		width: 350rpx;
		height: 350rpx;
		.img {
			width: 100%;
			height: 100%;
		}
	}
}
</style>
