<template>
	<view class="container">
		<swiper class="banner-swiper" circular autoplay :interval="5000" :duration="1000">
			<swiper-item class="banner-swiper-item" v-for="(item, index) in swipers" :key="index">
				<image v-if="item.imgs" :src="getimg+item.imgs.url" mode="widthFix"></image>
			</swiper-item>
		</swiper>
		<view class="content">
			<!-- section-1 begin -->
			<view class="section-1">
				<navigator v-if="sendMethods == 0" class="item item_one" open-type="reLaunch" url="/pages/index/index?type=配送" hover-class="none">
					<image src="/static/images/home/home_icon_waimai1.png" mode="widthFix"></image>
					<view class="wenyue-font">配送</view>
					<view class="text-color-assist">无需接触 送到家</view>
				</navigator>
				<navigator v-else-if="sendMethods == 1" class="item item_one" open-type="reLaunch" url="/pages/index/index?type=店内就餐" hover-class="none">
					<image src="/static/images/home/home_icon_ziqu1.png" mode="widthFix"></image>
					<view class="wenyue-font">店内就餐</view>
					<view class="text-color-assist">更加热闹 有气氛</view>
				</navigator>
				<template v-else>
					<navigator class="item" open-type="reLaunch" url="/pages/index/index?type=配送" hover-class="none">
						<image src="/static/images/home/home_icon_waimai1.png" mode="widthFix"></image>
						<view class="wenyue-font">配送</view>
						<view class="text-color-assist">无需接触 送到家</view>
					</navigator>
					<navigator class="item" open-type="reLaunch" url="/pages/index/index?type=店内就餐" hover-class="none">
						<image src="/static/images/home/home_icon_ziqu1.png" mode="widthFix"></image>
						<view class="wenyue-font">店内就餐</view>
						<view class="text-color-assist">更加热闹 有气氛</view>
					</navigator>
				</template>
			</view>
			<!-- section-2 end -->
			<!-- section-2 begin -->
			<!-- <view class="section-2">
				<navigator class="item" open-type="switchTab" url="/pages/mart/mart" hover-class="none">
					<view class="title">
						<image src="/static/images/home/home_icon_baihuo1.png"></image>
						<view>喜茶百货</view>
					</view>
					<view class="tips">灵感商品 立即选购</view>
				</navigator>
				<navigator class="item" open-type="navigate" url="/pages/home/group-dinner" hover-class="none">
					<view class="title">
						<image src="/static/images/home/home_icon_qiye1.png"></image>
						<view>企业团餐</view>
					</view>
					<view class="tips">50份起送</view>
				</navigator>
			</view> -->
			<!-- section-2 end -->
			<view class="section-3">
				<navigator class="my-integral" open-type="navigate" url="/pages/integrals/scores" hover-class="none">
					<view class="integrals">
						<view>我的积分</view>
						<view class="neutra-font">{{info.points || 0}}</view>
					</view>
					<view class="tips">
						积分可用于优惠劵兑换
					</view>
				</navigator>
				<navigator class="my-code" open-type="navigate" url="/pages/my/code" hover-class="none">
					<image src="/static/images/home/home_icon_erweima.png"></image>
					<view>二维码</view>
				</navigator>
			</view>
			<!-- 店家信息 -->
			<view class="info">
				<view>{{shopTel}}</view>
				<view>{{shopAddress}}</view>
			</view>
			<!-- 店家信息 end -->
			
		</view>
		<!-- 店家信息 -->
		<!-- <view class="info">
			<view><text>联系电话</text><text>{{shopTel}}</text></view>
			<view><text>商家地址</text><text>{{shopAddress}}</text></view>
		</view> -->
		<!-- 店家信息 end -->
	</view>
</template>

<script>
	import merchant from '@/api/merchant.js'
	import banner from '@/api/banner.js'
	import systemModel from '@/api/system.js'
	import userModel from '@/api/user.js'
	export default {
		data() {
			return {
				swipers: [],
				mer: [],
				getimg: this.$getimg,
				shopAddress: '',
				sendMethods: 2,
				shopTel: '',
				info: {},
			}
		},
		onLoad() {
			// this.mer = uni.getStorageSync('merchant')
			// if (!this.mer.length) {
			// 	merchant.get_merchant().then(res => {
			// 		this.mer = res.data
			// 		uni.setStorageSync('merchant', this.mer);
			// 	})
			// }
			this.getBanner();
			this.getSystemConfig();
			this.getInfo();
		},
		methods: {
			show_data() {
				this.getBanner();
				this.getSystemConfig();
				this.getInfo();
			},
			getSystemConfig() {
				const _this = this;
				systemModel.getSystemConfig(6).then(res => {
					for(let k in res.data)
					{
						if(res.data[k].key == 'drive_type') {
							_this.sendMethods = Number(res.data[k].value);
						}
						if(res.data[k].key == 'merchan_address') {
							_this.shopAddress = res.data[k].value;
						}
						if(res.data[k].key == 'merchant_phonto') {
							_this.shopTel = res.data[k].value;
						}
						if(res.data[k].key == 'merchant_name') {
							uni.setNavigationBarTitle({
								title: res.data[k].value
							})
						}
					}
				})
			},
			getBanner() {
				banner.get_banner(1).then(res => {
					this.swipers = res.data.items
				})
			},
			getInfo() {
				const _this = this;
				userModel.get_info().then(res => {
					_this.info = res.data;
				});
			},
			
		}
	}
</script>

<style lang="scss" scoped>
	page {
		max-height: 100%;
	}

	.banner-swiper {
		width: 100%;
		height: 600rpx;

		.banner-swiper-item {
			image {
				width: 100%;
			}
		}
	}

	.content {
		width: 100%;
		padding: 0 30rpx;
		position: relative;
	}

	.section-1 {
		position: relative;
		background-color: $bg-color-white;
		margin-top: -60rpx;
		border-radius: $border-radius-lg;
		padding: 60rpx 0;
		display: flex;
		margin-bottom: 30rpx;
		box-shadow: $box-shadow;

		.item {
			flex: 1;
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			position: relative;
			
			&_one {
				&:nth-child(1):before {
					content: '';
					position: absolute;
					left: 0;
					top: 0;
					bottom: 0;
					width: 2rpx;
					background-color: $border-color;
				}
			}

			&:nth-child(1):after {
				content: '';
				position: absolute;
				right: 0;
				top: 0;
				bottom: 0;
				width: 2rpx;
				background-color: $border-color;
			}

			image {
				width: 100rpx;
				margin-bottom: 20rpx;
			}

			.wenyue-font {
				font-size: 48rpx;
				margin-bottom: 10rpx;
			}
		}
	}

	.section-2 {
		display: flex;
		justify-content: space-between;
		margin-bottom: 30rpx;

		.item {
			width: 335rpx;
			background-color: #EAEBEC;
			padding: $spacing-row-lg 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			border-radius: $border-radius-lg;

			.title {
				width: 100%;
				display: flex;
				align-items: center;
				justify-content: center;
				font-size: $font-size-lg;

				image {
					width: 60rpx;
					height: 60rpx;
					margin-right: 10rpx;
				}
			}

			.tips {
				color: $text-color-assist;
				font-size: $font-size-base;
			}
		}
	}

	.section-3 {
		margin-bottom: 30rpx;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: $font-size-base;
		color: $text-color-assist;
		padding: 0 10rpx;

		.my-integral {
			flex: 1;
			display: flex;
			flex-direction: column;

			.integrals {
				display: flex;
				align-items: center;
				font-size: $font-size-lg;
				color: $text-color-base;
				margin-bottom: 10rpx;

				.neutra-font {
					margin-left: 10rpx;
					font-size: 42rpx;
				}
			}
		}

		.my-code {
			display: flex;
			flex-direction: column;
			align-items: center;
			padding: 0 30rpx;
			position: relative;

			image {
				width: 60rpx;
				height: 60rpx;
				margin-bottom: $spacing-col-sm;
			}

			&:before {
				content: " ";
				position: absolute;
				left: 0;
				top: 0;
				bottom: 0;
				border-left: 1rpx solid rgba($color: $border-color, $alpha: 0.6);
			}
		}
	}
	.info {
		position: fixed;
		bottom: 140rpx;
		left: 0;
		width: 100%;
		text-align: center;
		margin-top: 80rpx;
		color: #777;
		font-size: 0.9rem;
		>view {
			&:first-child {
				margin-bottom: 10rpx;
			}
		}
	}
	/* #ifdef MP-WEIXIN */
	.info {
		position: fixed;
		bottom: 40rpx;
		left: 0;
		width: 100%;
		text-align: center;
		margin-top: 80rpx;
		color: #777;
		font-size: 0.9rem;
		>view {
			&:first-child {
				margin-bottom: 10rpx;
			}
		}
	}
	/* #endif */
	
	// .info {
	// 	width: 100%;
	// 	// text-align: center;
	// 	padding: 30rpx;
	// 	margin-top: 50rpx;
	// 	color: #777;
	// 	font-size: 1rem;
	// 	background-color: white;
	// 	>view {
	// 		display: flex;
	// 		>text {
	// 			&:first-child {
	// 				display: inline-block;
	// 				width: 150rpx;
	// 				font-size: 0.9rem;
	// 				flex-shrink: 0;
	// 			}
	// 		}
	// 		&:first-child {
	// 			margin-bottom: 10rpx;
	// 		}
	// 	}
	// }
</style>