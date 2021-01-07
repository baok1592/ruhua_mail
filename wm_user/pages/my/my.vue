<template>
	<view class="container">
		<view class="img" style="background: url(https://go.cdn.heytea.com/storage/products/2019/12/18/01954797f3fb470cb6ba1606476c658c.png);"></view>
		<!-- <image class="w-100 img" style="height: 160rpx;" src="https://go.cdn.heytea.com/storage/products/2019/12/18/01954797f3fb470cb6ba1606476c658c.png"></image> -->
		<view class="content">
			<view class="welcome" @tap="openLoginPopup">
				<view style="text-align: center;"><image v-if="isLogin" :src="userinfo.headpic" class="headpic"></image></view>
				<view v-if="isLogin" style="text-align: center;">{{userinfo.nickname}}</view>
				<view v-else style="text-align: center; margin-top: 70rpx;">立即登录</view>
			</view>
			<!-- member card begin -->
			
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
		<view class="info">
			<view>{{shopTel}}</view>
			<view>{{shopAddress}}</view>
		</view>
		<!-- 店家信息 end -->
		<!-- 登录popup -->
		<login-popup @auto="auto" ref="loginPopup"></login-popup>
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
	
	export default {
		components: {
			listCell,
			loginPopup
		},
		data() {
			return {
				boardcast: [],
				userinfo:{},
				isLogin:false,
				couponn:0,
				coupon:[],
				shopAddress: '',
				shopTel: '',
				articles:[]
			}
		},
		watch:{
			isLogin(v){
				// console.log(v)
				if(v){
					user.get_info().then(res=>{
						// console.log(res.data)
						this.userinfo=res.data
					})
				}
			}
		},
		computed: {
		},
		onShow() {
			
		},
		async onLoad() {
		
			this.get_artical() 
			this.show_data();
			this.getSystemConfig();
			
		},
		methods: {
			show_data() {
				this.auto()
				
				this.getSystemConfig();
			},
			get_artical(){
				article.getPersonArticle().then(res=>{
					this.articles=res.data
				})	
			},
			openLoginPopup() {
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
				user.get_info().then(res=>{
					if(res.data.nickname){
						this.isLogin=true
					}
					else
						this.isShow=false
					//this.isLogin=res.data
					// console.log(this.isLogin)
				})
				
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

.img {
	height: 250rpx;
	background-position: 0 0;
	background-size: 100%;
}

.content {
	padding: 0 30rpx;
}
.headpic{
	width: 80rpx;
	height: 80rpx;
}

.welcome {
	position: relative;
	margin-top: -190rpx;
	display: flex;
	flex-direction: column;
	font-size: $font-size-lg;
	color: $text-color-warning;
}

.info {
	position: fixed;
	bottom: 240rpx;
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
		
		.title {
			flex: 1;
			font-size: 40rpx;
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
			
			image {
				width: 100rpx;
				height: 100rpx;
			}
			
			.value {
				font-family: 'neutra';
				margin-bottom: $spacing-col-sm;
				font-size: $font-size-lg;
			}
			
			.title {
				font-size: $font-size-sm;
				color: $text-color-grey;
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
