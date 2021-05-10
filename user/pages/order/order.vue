<template>
	<view class="container">
		<view class="tabbar">
			<view class="item" :class="{ active: !tabIndex }" @tap="switchTab(0)">当前订单</view>
			<view class="item" :class="{ active: tabIndex }" @tap="switchTab(1)">历史订单</view>
		</view>
		<swiper :current="tabIndex" :duration="300" class="swiper" :show-scrollbar="false">
			<!-- 当前订单 begin -->
			<swiper-item @touchmove.stop="handleSwiperItemChange">
				<view class="no-order-content" v-if="!orders.length">
					<image src="../../static/icon-img/empty.png"></image>
					<view class="tips">
						<view>您今天还没有下单</view>
						<view>快去选择一杯喜欢的饮品吧</view>
					</view>
					<button @tap="zlyd()" type="primary" class="font-size-lg" hover-class="none">去下单</button>
				</view>
				<scroll-view scroll-y="true" v-else class="orders-scroll1">
					<view class="wrapper">
						<view class="order-list">
							<view class="order" v-for="(order, index) in orders" :key="index">
								<view class="header">
									<view class="flex-fill font-size-medium">{{ order.id }}</view>
									<view class="status"> 
										<view v-if="order.payment_state == 0" @click="jump_detail(order.order_id)">
											未支付
										</view>
										<view v-else>
											已支付
										</view>
										<image @click="jump_detail(order.order_id)" src="/static/images/common/black_arrow_right.png"></image>
									</view>
								</view>
								<navigator open-type="navigate" :url="'/pages/order/detail?id=' + order.order_id">
									<view class="images">
										<image :src="getimg + order.ordergoods[0].pic"></image>
										<view class="good_name">{{ order.ordergoods[0].goods_name }}</view>
									</view>
									<view class="info">
										<view class="left">
											<view>订单编号：{{ order.order_num }}</view>
											<view>下单时间：{{ order.created_at }}</view>
										</view>
										<view class="right">￥{{ order.order_money }}</view>
									</view>
								</navigator>
								<view class="action">
									<view v-if="order.payment_state==0" @tap='pay(order.order_id, order.payment_state)' class="button button_pay" hover-class="none">去支付</view>
									<view v-if="order.payment_state==0" @tap="deleteOrder(order.order_id)" class="button button_del" hover-class="none">删除</view>
									<view v-if="order.state==2">已评论</view>
									<view v-else-if="order.state!=0 && order.payment_state==1" @tap="ckpl(order.order_id)" class="button" hover-class="none">去评论</view>
								</view>
							</view>
						</view>
					</view>
				</scroll-view>
			</swiper-item>
			<!-- 当前订单 end -->
			<!-- 历史订单 begin -->
			<swiper-item @touchmove.stop="handleSwiperItemChange">
				<view class="history-order">
					<view class="menu">
						<view class="flex-fill d-flex justify-content-start">
							<view class="item" :class="{ active: !orderMenuIndex }" @tap="switchMenuTab(0)">店内订单</view>
							<view class="item" :class="{ active: orderMenuIndex }" @tap="switchMenuTab(1)">外卖订单</view>
						</view>
					</view>
					<swiper :current="orderMenuIndex" :duration="300" :show-scrollbar="false" class="history-order-swiper">
						<!-- 门店订单 begin -->
						<swiper-item @touchmove.stop="handleSwiperItemChange">
							<view class="no-order-content" v-if="!wmorders.length">
								<image src="../../static/icon-img/empty.png"></image>
								<view class="tips">
									<view>您今天还没有下单</view>
									<view>快去选择一杯喜欢的饮品吧</view>
								</view>
								<button @tap="zlyd()" type="primary" class="font-size-lg" hover-class="none">去下单</button>
							</view>
							<scroll-view scroll-y="true" class="orders-scroll">
								<view class="wrapper">
									<view class="order-list">
										<view class="order" v-for="(order, index) in wmorders" :key="index">
											<view class="header">
												<view class="flex-fill font-size-medium">{{ order.id }}</view>
												<view class="status">
													<view v-if="order.state == 1 ">已完成</view>
													<view v-if="order.state == -1 ">退款中</view>
													<view v-if="order.state == -2 ">已退款</view>
													<image @click="jump_detail(order.order_id)" src="/static/images/common/black_arrow_right.png"></image>
												</view>
											</view>
											<navigator open-type="navigate" :url="'/pages/order/detail?id=' + order.order_id">
												<view class="images">
													<image :src="getimg + order.ordergoods[0].pic"></image>
													<view class="good_name">{{ order.ordergoods[0].goods_name }}</view>
												</view>
												<view class="info">
													<view class="left">
														<view>订单编号：{{ order.order_num }}</view>
														<view>下单时间：{{ order.created_at }}</view>
													</view>
													<view class="right">￥{{ order.order_money }}</view>
												</view>
											</navigator>
											<view class="action" v-if=" order.state==1">
												<view v-if="order.state==2">已评论</view>
												<view v-else-if="order.state!=0 && order.payment_state==1" @tap="ckpl(order.order_id)" class="button" hover-class="none">去评论</view>
												<view @tap="zlyd()" v-if="order.state!=0" class="button button_re" hover-class="none">再来一单</view>
											</view>
										</view>
									</view>
								</view>
							</scroll-view>
						</swiper-item>
						<!-- 门店订单 end -->
						<!-- 百货订单 begin -->
						<swiper-item @touchmove.stop="handleSwiperItemChange">
							<view class="no-order-content" v-if="!wmorders.length">
								<image src="../../static/icon-img/empty.png"></image>
								<view class="tips">
									<view>您今天还没有下单</view>
									<view>快去选择一杯喜欢的饮品吧</view>
								</view>
								<button @tap="zlyd()" type="primary" class="font-size-lg" hover-class="none">去下单</button>
							</view>
							<scroll-view scroll-y="true" class="orders-scroll">
								<view class="wrapper">
									<view class="order-list">
										<view class="order" v-for="(order, index) in wmorders" :key="index">
											<view class="header">
												<view class="flex-fill font-size-medium">{{ order.id }}</view>
												<view class="status">
													<view v-if="order.state == 0">
														<view>{{ order.payment_state ? '已支付' : '未支付' }}</view>
													</view>
													<view v-if="order.state == 1">
														<view>{{ order.state == 1 ? '已完成' : '未完成' }}</view>
													</view>
													<view v-if="order.state == -1">
														<view>退款中</view>
													</view>
													<view v-if="order.state == -2">
														<view>已退款</view>
													</view>
													<image @click="jump_detail(order.order_id)" src="/static/images/common/black_arrow_right.png"></image>
												</view>
											</view>
											<navigator open-type="navigate" :url="'/pages/order/detail?id=' + order.order_id">
												<view class="images">
													<image :src="getimg + order.ordergoods[0].pic"></image>
													<view class="good_name">{{ order.ordergoods[0].goods_name }}</view>
												</view>
												<view class="info">
													<view class="left">
														<view>订单编号：{{ order.order_num }}</view>
														<view>下单时间：{{ order.created_at }}</view>
													</view>
													<view class="right">￥{{ order.order_money }}</view>
												</view>
											</navigator>
											<view class="action" v-if="order.state==1">
												<view v-if="order.state==2">已评论</view>
												<view v-else-if="order.state!=0 && order.payment_state==1" @tap="ckpl(order.order_id)" class="button" hover-class="none">去评论</view>
												<view @tap="zlyd()" v-if="order.state!=0" class="button button_re" hover-class="none">再来一单</view>
											</view>
										</view>
									</view>
								</view>
							</scroll-view>
						</swiper-item>
						<!-- 外卖订单 -->
						<!-- 历史订单 end -->
					</swiper>
				</view>
			</swiper-item>
		</swiper>
		<view class="" style="height: 60px;">
			
		</view>
	</view>
</template>

<script>
import ordermodel from '@/api/orders.js';
import tokenModel from '@/api/token.js'

export default {
	data() {
		return {
			tabIndex: 0,
			orderMenuIndex: 0,
			orders: [],
			storeOrders: [],
			wmorders: [],
			getimg: this.$getimg
		};
	},
	async onLoad() {
		await this.verifyToken();
		this.getOrders(0);
	},
	onShow() {
		this.getOrders(0);
	},
	computed: {
		batchInvoiceVisible() {
			return (!this.orderMenuIndex && this.orders.length) || (this.orderMenuIndex && this.storeOrders.length);
		}
	},
	methods: {
		jump_detail(id){
			uni.navigateTo({
				url:'./detail?id='+id
			})
		},
		show_data() {
			this.getOrders(this.tabIndex);
			// 下拉刷新之后将切片换为店内订单
			this.orderMenuIndex = 0;
		},
		//切换历史订单或当前订单
		switchTab: async function(index) {
			if (this.tabIndex === index) return;
			this.tabIndex = index;
			await this.getOrders(index);
		},
		handleSwiperItemChange() {
			//禁止手动滑动
			return true;
		},
		//切换店内订单或外卖订单
		async switchMenuTab(index) {
			if (this.orderMenuIndex === index) return;
			this.orderMenuIndex = index;
			if (index == '0') {
				let arr = [];
				this.storeOrders.forEach(order => {
					if (order.drive_type != '配送') arr.push(order);
				});
				this.wmorders = arr;
			} else {
				let arr = [];
				this.storeOrders.forEach(order => {
					if (order.drive_type == '配送') arr.push(order);
				});
				this.wmorders = arr;
			}
		},
		//获取当前订单
		getOrders(index) {
			var that = this;
			if (index == 0) {
				//获取当前订单
				ordermodel.get_not_order().then(res => {
					that.orders = res.data;
				});
			} else {
				//获取历史订单
				ordermodel.get_all_order().then(res => {
					that.storeOrders = res.data;
					let arr = [];
					this.storeOrders.forEach(order => {
						if (order.drive_type != '配送') arr.push(order);
					});
					this.wmorders = arr;
				});
			}
		},
		deleteOrder(id) {
			const _this = this;
			uni.showModal({
			    title: '提示',
			    content: '是否确定删除该订单',
			    success: function (res) {
			        if (res.confirm) {
			            ordermodel.deleteOrder(id).then(res => {
			            	if(res.status == 200) {
								uni.showToast({
									title: '删除成功'
								})
			            		_this.getOrders(0);
			            	}
			            })
			        }
			    }
			});
		},
		//跳转到下单页面
		zlyd() {
			uni.switchTab({
				url: '../index/index',
			})
		},
		//跳转评价页面
		ckpl(id){
			uni.navigateTo({
				url: '../goods_list/goods_list?order_id=' + id
			})
		},
		pay(id, payment_state){
			if(payment_state == 0) {
				uni.navigateTo({
					url:'../pay/pay?id='+id
				})
			}
		},
		async verifyToken() {
			let token = uni.getStorageSync('token')
			await tokenModel.verifyToken(token).then(async res => {
				if(res.status != 200) {
					await uni.showToast({
						title: '请登录',
						icon: 'none'
					})
					uni.reLaunch({
						url: '/pages/my/my'
					})
				}
			})
		},
	}
};
</script>

<style lang="scss" scoped>
page {
	background-color: #f6f6f6;
}
.navbar {
	height: calc(44px + var(--status-bar-height));
	/* #ifdef H5 */
	height: 44px;
	/* #endif */
	display: flex;
	background-color: #ffffff;
}

.talk-btn {
	height: 32px;
	margin-left: 10px;
	margin-top: 26px;
	/* #ifdef H5 */
	margin-top: 6px;
	/* #endif */
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: $font-size-sm !important;
	padding: 0 20rpx;
	border-radius: 50rem !important;

	image {
		width: 40rpx;
		height: 40rpx;
		margin-right: $spacing-row-sm;
	}
}

.tabbar {
	/* #ifdef MP-WEIXIN */
	margin-top: 60px;
	/* #endif */
	
	height: 100rpx;
	background-color: $bg-color-white;
	display: flex;
	align-items: center;
	justify-content: space-around;
	// margin-top: 100rpx;

	.item {
		height: 100%;
		font-size: $font-size-lg;
		color: $text-color-assist;
		font-weight: 400 !important;
		display: flex;
		align-items: center;

		&.active {
			color: $text-color-base;
			border-bottom: 4rpx solid $text-color-base;
		}
	}
}

.swiper {
	width: 100%;
	height: calc(100vh - 44px);
	/* #ifdef H5 */
	height: calc(100vh - 100px);
	/* #endif */
}

.no-order-content {
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;

	image {
		width: 300rpx;
		height: 300rpx;
		margin-bottom: 50rpx;
	}

	.tips {
		color: $text-color-assist;
		display: flex;
		flex-direction: column;
		align-items: center;
		line-height: 1.2rem !important;
		margin-bottom: 70rpx;
	}

	button {
		width: 50%;
	}
}

.history-order {
	width: 100%;
	height: 100%;
	position: relative;

	.menu {
		padding: 18rpx 30rpx;
		display: flex;
		align-items: center;
		font-size: $font-size-base;
		color: $text-color-grey;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		z-index: 10;

		.item {
			padding: 14rpx 30rpx;
			display: flex;
			align-items: center;
			justify-content: center;

			image {
				width: 40rpx;
				height: 40rpx;
				margin-right: 10rpx;
			}

			&.active {
				color: $color-primary;
				background-color: $bg-color-white;
			}
		}
	}

	.history-order-swiper {
		width: 100%;
		height: 100%;
	}
}

.store-order-wrapper {
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	font-size: $font-size-base;
	color: $text-color-assist;
	line-height: 1.3rem !important;

	image {
		width: 400rpx;
		height: 333rpx;
		margin-bottom: 40rpx;
	}
}

.orders-scroll {
	width: 100%;
	height: 100%;
	padding-top: 104rpx;
}
.orders-scroll1 {
	width: 100%;
	height: 100%;
	padding-top: 10rpx;
}
.good_name {
	padding-left: 30rpx;
	padding-top: 15rpx;
	color: #555;
	font-weight: 600;
}

.order-list {
	display: flex;
	width: 100%;
	flex-direction: column;

	.order {
		background-color: $bg-color-white;
		padding: 30rpx 40rpx;
		margin-bottom: 18rpx;

		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;

			.status {
				font-size: $font-size-base;
				color: $text-color-grey;
				display: flex;
				align-items: center;
				image {
					width: 30rpx;
					height: 30rpx;
					margin-left: $spacing-row-sm;
				}
			}
		}

		.images {
			display: flex;
			padding: 30rpx 0;
			image {
				flex-shrink: 0;
				width: 150rpx;
				height: 112.5rpx;
			}
		}

		.info {
			display: flex;
			align-items: center;
			margin-bottom: 30rpx;

			.left {
				flex: 1;
				display: flex;
				flex-direction: column;
				font-size: $font-size-base;
				color: $text-color-grey;
				>view {
					margin-bottom: 10rpx;
					font-size: 0.8rem;
					&:last-child {
						margin-bottom: 0;
					}
				}
			}

			.right {
				font-size: $font-size-lg;
				color: $text-color-base;
			}
		}

		.action {
			display: flex;
			justify-content: flex-end;
			align-items: center;

			button {
				margin-left: 30rpx;
				font-size: $font-size-sm;
			}
		}
	}
	.button {
		margin-left: 30rpx;
		padding: 15rpx 20rpx;
		font-size: $font-size-sm;
		border-radius: 70rpx;
		background-color: #eee;
		&_pay {
			background-color: #DBA871;
			color: white;
			border: none;
			border-radius: 70rpx;
		}
		&_del {
			color: white;
			background-color: #F56C6C;
		}
		&_re {
			color: white;
			background-color: #5CB87A;
		}
	}
}
</style>
