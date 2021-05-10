<template>
	<view class="container">
		<view class="img" style="background: url(https://go.cdn.heytea.com/storage/products/2019/12/18/01954797f3fb470cb6ba1606476c658c.png);"></view>
		<!-- <image class="w-100 img" style="height: 160rpx;" src="https://go.cdn.heytea.com/storage/products/2019/12/18/01954797f3fb470cb6ba1606476c658c.png"></image> -->
		<view class="content">
			<view class="welcome" @tap="openLoginPopup">
				<view v-if="isLogin">
					<image v-if="isLogin" :src="userinfo.headpic" class="headpic"></image>
					<view>
						<text>{{userinfo.nickname}}</text>
						<text>普通用户</text>
					</view>
				</view>
				<!-- <view style="text-align: center;">{{userinfo.nickname}}</view> -->
				
				<view v-else style="text-align: center; margin-top: 70rpx;">立即登录</view>
			</view>
			<!-- member card begin -->
			<view class="member-card">
				
				<view class="row">
					<navigator class="grid" open-type="navigate" url="/pages/integrals/scores">
						<image  src="/static/images/my/jf.png"></image>
						<view class="value">{{userinfo.points || 0}}</view>
						<view class="title">积分</view>
					</navigator>
					<view class="grid" hover-class="opacity-6" @tap="toGoCoupon">
						<image src="/static/images/my/yhq.png"></image>
						<view class="value">{{couponn || 0}}</view>
						<view class="title">优惠券</view>
					</view>
					<navigator class="grid" open-type="navigate" url="/pages/my/wallet">
						<image src="/static/images/my/ye.png"></image>
						<view class="value">{{userinfo.money || 0}}</view>
						<view class="title">余额</view>
					</navigator>
				</view>
			</view>
			<!-- member card end -->
		</view>
		
		<navigator open-type="navigate" url="../addresses/addresses">
		<list-cell hover arrow last>
			<view class="list-cell-wrapper">
				<view view="title">地址管理</view>
			</view>
		</list-cell>
		</navigator>
		<view v-for="(item,index) in articles" :key="index" @click="nav(item)">
		
		<list-cell hover arrow>
			<view class="list-cell-wrapper">
				<view view="title">{{item.title}}</view>
			</view>
		</list-cell>

		</view>
		<!-- <list-cell hover arrow>
			<view class="list-cell-wrapper">
				<view view="title">消息中心</view>
			</view>
		</list-cell> -->
		
		<!-- 店家信息 -->
		<view class="info22" >
			<view>{{shopTel}}</view>
			<view>{{shopAddress}}</view>
		</view>
		<!-- 店家信息 end -->
		<!-- 登录popup -->
		<login-popup @auto="auto" ref="loginPopup" @getInfo="updateUserInfo"></login-popup>
		<xcx-auth v-if="is_show_auth"  @getInfo="updateUserInfo" @getInfoFail="getInfoFail"></xcx-auth>
	</view>
</template>

<script>
	import listCell from '@/components/list-cell/list-cell.vue'
	import loginPopup from './components/login-popup.vue'
	import { mapState } from 'vuex'
	import user from '@/api/user.js'
	import usercoupon from "@/api/user_coupon.js"
	import systemModel from '@/api/system.js'
	import article from '@/api/article.js'
	import XCXauth from './components/xcx_auth.vue'
	
	export default {
		components: {
			listCell,
			loginPopup,
			'xcx-auth': XCXauth,
		},
		data() {
			return {
				boardcast: [],
				userinfo:{},
				isLogin: false,
				couponn:0,
				coupon:[],
				shopAddress: '',
				shopTel: '',
				articles:[],
				// 显示授权登录
				is_show_auth: false,
			}
		},
		watch:{
			// isLogin(v){
			// 	// console.log(v)
			// 	if(v){
			// 		// user.get_info().then(res=>{
			// 		// 	// console.log(res.data)
			// 		// 	this.userinfo = res.data
			// 		// })
			// 	}
			// }
		},
		onLoad() {
			this.getUserInfo();
			this.get_artical() 
			// this.show_data();
			// this.getSystemConfig();
		},
		onShow() {
			this.show_data();
		},
		methods: {
			// 获取用户优惠劵
			show_data() {
				this.auto()
				usercoupon.get_coupon().then(res=>{
					this.coupon=res.data
					this.couponn=res.data.length
				})
				this.getSystemConfig();
			},
			// 获取个人信息
			async getUserInfo() {
				const _this = this;
				await user.get_info().then(async res => {
					console.log('get_info',res)
					_this.$refs['loginPopup'].close()
					if( res.data && !(res.data.headpic || res.data.nickname) || (res.data.headpic == null && res.data.nickname == null)) {
						await uni.getSetting({
							success(res1) {
								// 已授权
								if(res1.authSetting['scope.userInfo']) {
									// 获取用户信息
									// uni.getUserInfo({
									// 	provider: 'weixin',
									// 	success: function(infoRes) {
									// 		user.upinfo(infoRes.userInfo).then(res => {
									// 			_this.getUserInfo();
									// 		});
									// 	}
									// })
									wx.getUserProfile({
									  desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
									  success: (res) => {
										console.log('profile:',res.userinfo)		
										// if (res.userInfo) {
										// 	const user = res.userInfo		 
										// 	that.UpUser(user,res.encryptedData,res.iv) 
										// }
									  }
									})
								}
								else {
									_this.is_show_auth = true;
								}
							}
						})
					}
					else {
						this.isLogin = true;
						this.userinfo = res.data;
						this.is_show_auth = false;
					}
				})
			},
			// 保存微信头像昵称信息
			updateUserInfo(infoRes) {
				const _this = this;
				console.log('infoRes',infoRes)
				user.upinfo(infoRes).then(res => {
					_this.getUserInfo();
					this.is_show_auth = false;
				});
			},
			// 拒接授权获取个人信息
			getInfoFail() {
				this.is_show_auth = false;
				uni.showModal({
					title: '提示',
					content: '您已取消了授权，请重新授权登录',
					showCancel: false
				});
			},
			get_artical(){
				article.getPersonArticle().then(res=>{
					this.articles=res.data
				})	
			},
			openLoginPopup() {
				console.log(this.isLogin)
				if(this.isLogin) {
					return
				}
				this.$refs['loginPopup'].open()
			},
			nav(item){
				uni.setStorageSync('content',item.content)
				uni.navigateTo({
					url:'article/article'
				})
			},
			info() {
				uni.navigateTo({
					url: '/pages/my/info'
				})
			},
			taskCenter() {
				uni.navigateTo({
					url: '/pages/task-center/task-center'
				})
			},
			openMember() {
				uni.navigateTo({
					url: '/pages/my/member'
				})
			},
			myCode() {
				uni.navigateTo({
					url: '/pages/my/code'
				})
			},
			openBenefits() {
				if(this.isLogin) {
					uni.navigateTo({
						url: '/pages/my/benefits'
					})
				} else {
					this.$refs['loginPopup'].open()
				}
			},
			auto(){
				this.getUserInfo();
				// user.get_info().then(res => {
				// 	if(res.data.nickname){
				// 		this.isLogin = true
				// 	}
				// 	else
				// 		this.isLogin = false
				// 	//this.isLogin=res.data
				// 	// console.log(this.isLogin)
				// })
				
			},
			// 跳转优惠券列表
			toGoCoupon() {
				uni.navigateTo({
					url: '../coupon/coupon'
				})
			},
			getSystemConfig() {
				const _this = this;
				systemModel.getSystemConfig(6).then(res => {
					for(let k in res.data)
					{
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
			
		}
	}
</script>

<style lang="scss" scoped>
/* #ifdef H5 */
page {
	height: auto;
	min-height: 100%;
}
/* #endif */
.info22{
		position: fixed;text-align: center;width: 100%; color: #777;
		/* #ifdef H5 */
		bottom: 90px;
		/* #endif */
		/* #ifdef MP-WEIXIN */
		bottom: 10px;
		/* #endif */
	}
.img {
	height: 28vh;
	background-position: 0 0;
	background-size: 100%;
}

.content {
	padding: 0 30rpx;
}
.headpic{
	width: 100rpx;
	height: 100rpx;
	border-radius: 50%;
}

.welcome {
	position: relative;
	margin-top: -190rpx;
	display: flex;
	flex-direction: column;
	font-size: $font-size-lg;
	color: $text-color-warning;
	
	>view {
		padding-left: 50rpx;
		display: flex;
		
		>view {
			margin-left: 30rpx;
			display: flex;
			flex-direction: column;
			
			>text {
				&:last-child {
					color: #777;
					font-size: 0.8rem;
					margin-top: 10rpx;
				}
			}
		}
	}
}

.info {
	position: fixed;
	bottom: 240rpx;
	left: 0;
	width: 100%;
	text-align: center;
	margin-top: 80rpx;
	color: #777;
	font-size: 12px;
	>view {
		&:first-child {
			margin-bottom: 10rpx;
		}
	}
}
/* #ifdef MP-WEIXIN */
.info {
	position: fixed;
	bottom: 170rpx;
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
// 	margin-top: 80rpx;
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

.member-card {
	background-color: $bg-color-white;
	padding: 20rpx;
	display: flex;
	flex-direction: column;
	border-radius: $border-radius-base;
	margin-bottom: 40rpx;
	margin-top: 30rpx;
	
	.info {
		position: relative;
		margin-top: -50rpx;
		display: flex;
		align-items: center;
		position: relative;
		padding: 20rpx 0;
		border-bottom: 1rpx solid rgba($color: $border-color, $alpha: 0.3);
		font-size: 12px;
		.title {
			flex: 1;
			font-size: 12px;
			color: $text-color-base;
			display: flex;
			align-items: center;
		
			.tips {
				margin-left: 10rpx;
				font-size: $font-size-sm;
				color: $text-color-assist;
				background-color: #e9e9e9;
				padding: 10rpx 30rpx;
				border-radius: 50rem !important;
				display: flex;
				align-items: center;
				
				image {
					width: 20rpx;
					height: 20rpx;
				}
			}
		}
		
		.avatar {
			width: 150rpx;
			height: 150rpx;
			border-radius: 100%;
		}
		
		.badage {
			font-family: 'neutra';
			position: absolute;
			bottom: 20rpx;
			left: 0;
			border: 2rpx solid $text-color-base;
			padding: 2rpx 20rpx;
			border-radius: $border-radius-lg;
			font-size: $font-size-base;
		}
	}
	
	.row {
		margin-top: $spacing-row-base;
		width: 100%;
		display: flex;
		align-items: center;

		.grid {
			flex: 1;
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			
			// image {
			// 	width: 100rpx;
			// 	height: 100rpx;
			// }
			
			.value {
				font-family: 'neutra';
				margin-bottom: $spacing-col-sm;
				font-size: $font-size-lg;
			}
			
			.title {
				font-size: $font-size-sm;
				color: $text-color-grey;
			}
			image{
				width: 30px;
				height: 30px;
				margin-bottom: 10px;
			}
		}
	}
}

.xinqiubobao {
	width: 100%;
	position: relative;
	
	.title {
		margin: 10rpx 0;
		font-size: $font-size-lg;
		font-weight: 500;
	}
	
	.swiper {
		height: 200rpx;
		margin-bottom: 10rpx;
		
		.swiper-item {
			
			.swiper-item-wrapper {
				display: flex;
				background-color: $bg-color-white;
				padding: 40rpx 60rpx;
				border-radius: $border-radius-base;
				align-items: center;
				margin-right: 40rpx;
				
				image {
					width: 100rpx;
					height: 100rpx;
					border-radius: 100%;
					margin-right: 20rpx;
				}
				
				.desc {
					display: flex;
					flex-direction: column;
					
					.title {
						font-size: $font-size-medium;
						font-weight: 500;
						margin-bottom: 10rpx;
					}
					
					.desc {
						font-size: $font-size-sm;
						color: $text-color-grey;
					}
				}
			}
		}
	}
}

.task-center {
	margin: 40rpx 0;
	background-color: $bg-color-white;
	padding: 10rpx 0;
	display: flex;
	align-items: center;
	border-radius: $border-radius-lg;
	
	.intro {
		flex: 1;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		.title {
			font-size: $font-size-lg;
			color: $text-color-base;
		}
		.subtitle {
			font-family: 'neutra';
			font-size: $font-size-sm;
		}
	}
	
	.image-wrapper {
		flex: 1;
		display: flex;
		justify-content: center;
		align-items: center;
		
		image {
			width: 200rpx;
			height: 200rpx;
		}
	}
}

.open-gift {
	width: 100%;
	background-color: $bg-color-white;
	padding: 30rpx 40rpx;
	margin-bottom: 20rpx;
	
	.header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20rpx;
		
		.title {
			font-size: $font-size-lg;
			font-weight: 500;
		}
		
		.subtitle {
			font-size: $font-size-base;
			color: $text-color-grey;
		}
	}
	
	.row {
		display: flex;
		flex-wrap: wrap;
		
		.grid {
			width: 33.3333%;
			display: flex;
			flex-direction: column;
			align-items: center;
			padding: 20rpx;
			
			image {
				width: 70rpx;
				height: 70rpx;
				margin-bottom: $spacing-row-base;
			}
			
			.title {
				font-size: $font-size-base;
				color: $text-color-base;
				display: flex;
				align-items: baseline;
				
				.number {
					margin-left: 5rpx;
					font-family: 'neutra';
					color: $color-warning;
				}
			}
		}
	}
}

.list-cell-wrapper {
	width: 100%;
	display: flex;
	justify-content: space-between;
	align-items: center;
	
	.title {
		font-size: $font-size-lg;
	}
	
	.subtitle {
		font-size: $font-size-sm;
		color: $text-color-assist;
	}
}
</style>
